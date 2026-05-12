<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Order;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\PatientBehalf;
use App\Models\ShippingAddess;
use App\Models\PrescriptionImage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Response;
use Mail;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {



        if (!empty($request->input('area'))) {

            $area = $request->input('area');
            $customers = User::where('user_type', '=', 'customer')->where('area', '=', $area)->orWhere('city', '=', $area)->orWhere('region', '=', $area)->orderBy('created_at', 'desc')->get();
        } else {
            $customers = User::where('user_type', '=', 'customer')->orderBy('created_at', 'desc')->get();
        }
        return view('customers.index', compact('customers'));
    }
    public function viewMedUser()
    {
        $customers = User::where('user_type', '=', 'customer')->where('medication', '=', 'Yes')->orderBy('created_at', 'desc')->get();
        return view('customers.meduser', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $region = Division::all();
        $districts = District::all();
        $upazilas = Upazila::all();

        return view('customers.create', compact('upazilas', 'districts', 'region'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patient = new User;
        $patient->name = $request->name;
        $patient->email = $request->email;
        $patient->password = Hash::make(123456);
        $patient->email_verified_at = null;
        $patient->dob = $request->dob;
        $patient->medication = $request->medication;
        $patient->address = $request->address;
        $patient->city = $request->city;
        $patient->region = $request->region;
        $patient->area = $request->area;
        $patient->postal_code = $request->postal_code;
        $patient->shipping_cost = $request->shipping_cost;
        $patient->phone = $request->phone;
        $patient->ref_by = 'reference';
        $patient->status = '1';

        if ($patient->save()) {
            $shipping = new ShippingAddess;
            $shipping->user_id = $patient->id;
            $shipping->name = $request->name;
            $shipping->email = $request->email;
            $shipping->address = $request->address;
            $shipping->phone = $request->phone;
            $shipping->city = $request->city;
            $shipping->region = $request->region;
            $shipping->area = $request->area;
            $shipping->post_code = $request->postal_code;
            $shipping->shipping_cost = $request->shipping_cost;

            if ($shipping->save()) {
                $user = User::findOrFail($patient->id);
                $user->shipping_address = $shipping->id;
                $user->save();
            }

            //email send
            $mail['subject'] = "Apon Health Register Confirmation";
            $mail['msg'] = "123456";
            $mail['email'] = $request->email;
            $mail['phone'] = $request->phone;
            $email_to = $request->email;
            Mail::send('emails.doctor', compact('mail'), function ($message) use ($mail, $email_to) {
                $message->from('support@shundorjo', 'Shundorjo Care');
                $message->to($email_to)
                    ->subject($mail['subject']);
            });
            // sms send
            //     $phone = $request->phone;
            //     $sms = "Your account user phone: ".$phone.", and password: 123456 Please visit https://aponhealth.com/users/login";
            //     $curl = curl_init();
            //   curl_setopt_array($curl, array(
            //       CURLOPT_URL => "https://api.mobireach.com.bd/SendTextMessage?Username=lextlink&Password=Dhaka@5599&From=Apon%20Health&To=88".$phone."&Message=".urlencode($sms)."",
            //       CURLOPT_RETURNTRANSFER => true,
            //       CURLOPT_TIMEOUT => 30,
            //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //       CURLOPT_CUSTOMREQUEST => "GET",
            //       CURLOPT_HTTPHEADER => array(
            //           "cache-control: no-cache"
            //       ),
            //   ));
            //   $response = curl_exec($curl);
            //   $err = curl_error($curl);
            //   curl_close($curl);



            $customer = new Customer;
            $customer->user_id = $patient->id;
            if ($customer->save()) {
                flash(__('New Patient added successfully'))->success();
                return redirect()->route('customers.index');
            } else {
                flash(__('New Patient Not Added'))->error();
                return redirect()->route('customers.index');
            }
        }
    }

    // check mail
    function check(Request $request)
    {
        if ($request->email) {
            $email = $request->email;
            $data = User::where('email', '=', $email)->count();
            if ($data > 0) {
                echo 'not_unique';
            } else {
                echo 'unique';
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return "controller show called";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $region = Division::all();
        $districts = District::all();
        $upazilas = Upazila::all();

        $customers = User::where('id', '=', decrypt($id))->first();
        // dd( $customers );
        return view('customers.edit', compact('customers', 'upazilas', 'districts', 'region'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return "controller called";
        // dd($id);
        // exit;
        $customer = User::findOrFail($id);
        $customer->medication = "No";
        $customer->med_status = "0";
        $customer->med_upcoming = "Null";
        $customer->preiod = "Null";

        if ($customer->save()) {
            flash(__('Deleted successfully'))->success();
            return redirect()->route('customers.medication');
        }

        flash(__('Something went wrong'))->error();
        return redirect()->route('customers.medication');
    }

    public function patientUpdate(Request $request, $id)
    {
        $patient = User::findOrFail($id);
        $patient->name = $request->name;
        $patient->email = $request->email;
        $patient->dob = $request->dob;
        $patient->medication = $request->medication;
        $patient->address = $request->address;
        $patient->city = $request->city;
        $patient->postal_code = $request->postal_code;
        $patient->region = $request->region;
        $patient->area = $request->area;
        $patient->postal_code = $request->postal_code;
        $patient->shipping_cost = $request->shipping_cost;
        $patient->phone = $request->phone;
        $patient->status = $request->status;

        if ($patient->save()) {
            if (ShippingAddess::where('user_id', $id)->first() !=null){
                //new code start
                $shipping = ShippingAddess::findOrFail(ShippingAddess::where('user_id', $id)->first()->id);
                $shipping->user_id = $patient->id;
                $shipping->name = $request->name;
                $shipping->email = $request->email;
                $shipping->address = $request->address;
                $shipping->phone = $request->phone;
                $shipping->city = $request->city;
                $shipping->region = $request->region;
                $shipping->area = $request->area;
                $shipping->post_code = $request->postal_code;
                $shipping->shipping_cost = $request->shipping_cost;

                if ($shipping->save()) {
                    $user = User::findOrFail($id);
                    $user->shipping_address = $shipping->id;
                    $user->save();
                }
                // new code end
                flash(__('Patient has been Updated successfully'))->success();
                return redirect()->route('customers.index');
            } else{
                flash(__('Patient has been Updated successfully'))->success();
                return redirect()->route('customers.index');
            }

        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function meddestroy($id)
    {
        // return "controller delete called";
        $customer = User::findOrFail($id);
        $customer->medication = "No";
        $customer->med_status = "0";
        $customer->med_upcoming = Null;
        $customer->preiod = Null;

        if ($customer->save()) {
            flash(__('Deleted successfully'))->success();
            return redirect()->route('customers.medication');
        }

        flash(__('Something went wrong'))->error();
        return redirect()->route('customers.medication');
    }

    public function UserUpdateStatus(Request $request)
    {
        // var_dump($request->customerId);exit;

        $customer = User::findOrFail($request->customerId);
        $customer->status = $request->status;
        $customer->save();
        return 1;
    }

    public function destroy($id)
    {
        // Order::where('user_id', Customer::findOrFail($id)->user->id)->delete();
        // User::destroy(Customer::findOrFail($id)->user->id);
        if (User::destroy($id)) {
            flash(__('Customer has been deleted successfully'))->success();
            return redirect()->route('customers.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }


    public function userprofile($id)
    {

        // dd(decrypt($id));
        $purchase = Order::where('user_id', decrypt($id))->count();
        $amount = Order::where('user_id', decrypt($id))->sum('grand_total');
        $orders = Order::where('user_id', decrypt($id))->orderBy('code', 'desc')->paginate(10);
        $user = User::where('id', '=', decrypt($id))->first();
        $phone = User::where('id', '=', decrypt($id))->first()->phone;
        // dd($phone );
        $pimg = PrescriptionImage::where('mobile', '=', $phone)->orwhere('user_id', '=', decrypt($id))->orderBy('created_at', 'DESC')->get();

        // dd($pimg );
        return view('customers.profile', compact('user', 'orders', 'purchase', 'amount', 'pimg'));
    }

    public function testData()
    {
        $customers = User::where('user_type', '=', 'customer')->get();
        // dd($customers);
        return response()->json($customers);
    }
}
