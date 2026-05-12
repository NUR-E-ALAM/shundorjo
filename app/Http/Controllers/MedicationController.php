<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use App\Models\Medication;
use App\Models\MedicationUser;
use App\Models\PrescriptionImage;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\MedicationDetails;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Mail;
use App\Mail\InvoiceEmailManager;
use Illuminate\Support\Facades\Hash;
use Ramsey\Collection\Queue;
use App\Models\RequestOrder;
use ImageOptimizer;
use Image;
use Input;
use App\Http\Controllers\Controller;
use App\Models\ShippingAddess;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;

class MedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('medicationuser')->where('medication', '=', 'Yes')->whereNotNull('med_upcoming')->orderBy('med_upcoming', 'ASC')->get();
        return view('medication.index', compact('users'));
    }
    public function newuser()
    {
        $users = User::with('history')->where('medication', '=', 'Yes')->whereNull('med_upcoming')->orderBy('med_upcoming', 'ASC')->get();
        return view('medication.newuser', compact('users'));
    }
    public function medUsersPrescription($id)
    {
        $userid = decrypt($id);
        $prescriptions = PrescriptionImage::where('user_id', '=', $userid)->get();
        return view('medication.prescriptionimage', compact('userid', 'prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function show(Medication $medication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = [
            'id' => $id
        ];
        $info = Medication::where($where)->get()->first();
        return response()->json($info);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $master = Medication::find($id);
        if ($request->image != 'null') {
            $image_path = public_path('master') . '/' . $master->image;
            unlink($image_path);
            $master->softcode = $request->softcode;
            $master->hardcode = $request->hardcode;
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time() . $rand . '.' . $request->image->extension();
            $request->image->move(public_path('master'), $imageName);
            $master->image = $imageName;
            $master->details = $request->details;
            $master->sort_details = $request->sort_details;
        } else {
            $master->softcode = $request->softcode;
            $master->hardcode = $request->hardcode;
            $master->details = $request->details;
            $master->sort_details = $request->sort_details;
        }

        if ($master->save()) {
            $message = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Master Details Updated Successfully.</b></div>";

            return response()->json(['status' => 300, 'message' => $message]);
        } else {
            return response()->json(['status' => 303, 'message' => 'Server Error!!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (MedicationUser::destroy(MedicationUser::where('user_id', '=', $id)->first()->id)) {
            $update = User::find($id);
            $update->medication = NULL;
            $update->provider_id = NULL;
            $update->save();
            flash(__('Medication User Deactive successfully'))->success();
            return redirect()->route('medication.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function prescription()
    {
        $prescriptions = PrescriptionImage::where('user_id', Auth::user()->id)->orwhere('mobile', Auth::user()->phone)->orderBy('id', 'DESC')->get();
        return view('frontend.medication.index', compact('prescriptions'));
    }

    public function prescriptionUpload(Request $request)
    {

        // dd('ccc work');

        // new code
        if ($request->hasfile('image')) {
            foreach ($request->file('image') as $image) {
                $rand = mt_rand(100000, 999999);
                $name = time() . "_" . Auth::id() . "_" . $rand . "." . $image->getClientOriginalExtension();
                $image->move(public_path() . '/uploads/prescription/', $name);
                $data[] = $name;

                $pic = new PrescriptionImage();
                $pic->image = $name;
                $pic->mobile = Auth::user()->phone;
                $pic->patient_name = $request->message;
                $pic->save();
            }
        }
        // new code

        if ($pic->save()) {
            flash(__('Prescription Added successfully'))->success();
            return redirect()->route('prescription.index');
        } else {
            flash(__('Not Save'))->error();
            return redirect()->route('prescription.index');
        }
    }

    public function userPrescView($id)
    {
        // dd(decrypt($id));
        $pimg = PrescriptionImage::where('id', '=', decrypt($id))->get();
        return view('frontend.prescription.show', compact('pimg'));
    }

    public function prescriptionEdit($id)
    {
        $where = [
            'id' => $id
        ];
        $info = PrescriptionImage::where($where)->get()->first();
        return response()->json($info);
    }

    public function prescriptionDestroy($id)
    {

        if (PrescriptionImage::destroy($id)) {
            flash(__('Prescription Image has been deleted successfully'))->success();
            return back();
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function new_med_user()
    {
        $users = User::where('user_type', '=', 'customer')->where('medication', '=', NULL)->orWhere('medication', '=', 'No')->get();
        $agents = User::where('user_type', '=', 'staff')->get();
        return view('medication.newmadicationuser', compact('users', 'agents'));
    }

    public function new_med_update(Request $request)
    {
        $medUpdate = User::find($request->uid);
        $medUpdate->provider_id = $request->provider_id;
        $cid = User::whereRaw('cid = (select max(`cid`) from users)')->first('cid');
        $date = date('Y');

        if (empty($medUpdate->cid)) {
            if (!empty($cid)) {
                $medUpdate->cid = $cid->cid + 1;
            } else {
                $medUpdate->cid = $date . '00001';
            }
        }
        $medUpdate->medication = $request->status;
        $medUpdate->save();
        flash(__('New Medication User added successfully'))->success();
        return redirect()->route('madication.newuser');
    }

    // medication order section
    public function newOrder()
    {
        $users = User::where('medication', '=', 'Yes')->get();
        return view('medication.neworder', compact('users'));
    }

    public function createOrder($id)
    {
        $address = User::where('id', '=', decrypt($id))->first();
        $districts = District::where('division_id', '=', $address->region)->get();
        $upazilas = Upazila::where('district_id', '=', $address->city)->get();
        $region = Division::all();
        $users = User::where('medication', '=', 'Yes')->where('id', '=', decrypt($id))->first();
        // dd($shipping);
        $peoducts = Product::all();
        $order_id = date('Ymd-his');
        return view('medication.create', compact('users', 'peoducts', 'order_id', 'region', 'districts', 'upazilas'));
    }

    // unreginster user medication
    public function createOrderUnMedication($id)
    {
        $address = User::where('id', '=', decrypt($id))->first();
        $districts = District::where('division_id', '=', $address->region)->get();
        $upazilas = Upazila::where('district_id', '=', $address->city)->get();
        $region = Division::all();
        $users = User::where('medication', '=', 'No')->where('id', '=', decrypt($id))->first();
        // $users = ShippingAddess::where('user_id', '=',  decrypt($id))->first();
        $peoducts = Product::all();
        $order_id = date('Ymd-his');
        return view('medication.create', compact('users', 'peoducts', 'order_id', 'region', 'districts', 'upazilas'));
    }

    // request medication order
    public function createOrderReMedication($id)
    {
        dd('work');
        $users = User::where('medication', '=', NULL)->where('id', '=', decrypt($id))->first();
        $peoducts = Product::all();
        $order_id = date('Ymd-his');
        return view('medication.create', compact('users', 'peoducts', 'order_id'));
    }

    public function userMedicationOrder()
    {
        // $users = User::where('id', '=', Auth::user()->id)->first();
        $users = ShippingAddess::where('id', Auth::user()->shipping_address)->first();
        $peoducts = Product::all();
        $order_id = date('Ymd-his');
        if ($users) {
            return view('frontend.medication.usermedication', compact('users', 'peoducts', 'order_id'));
        } else {
            $redirect = 'medication';
            $region = Division::all();
            $districts = District::all();
            $upazilas = Upazila::all();
            return view('frontend.customer.add_address', compact('region', 'districts', 'upazilas', 'redirect'));
        }
    }

    // medication order placed order
    public function OrderConfirm(Request $request)
    {
        // create order
        $order = new Medication();
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;
        $region = $request->region;
        $city = $request->city;
        $area = $request->area;
        $post_code = $request->post_code;
        $order_id = $request->order_id;
        // ship
        $data['name'] = $name;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['address'] = $address;
        $data['region'] = $region;
        $data['city'] = $city;
        $data['area'] = $area;
        $data['post_code'] = $post_code;
        $shipping_info = $data;

        $order->user_id = $request->id;
        $order->shipping_address = json_encode($shipping_info);
        $order->payment_type = $request->payment_option;
        $order->payment_status = 'unpaid';
        $order->code = $order_id;
        $order->shipping_cost = $request->shipping_cost;
        // dd($order->shipping_cost);

        $order->date = strtotime(date('d-m-Y'));
        $order->viewed = 0;
        $order->upcoming_date = $request->date;
        $order->upcoming = 1;

        if ($order->save()) {
            $product_ids = $request->product_id;
            $price = $request->price;
            $qty = $request->qty;
            $auth = Auth::user()->id;
            foreach ($product_ids as $key => $product_id) {
                $input['product_id'] = $product_id;
                $input['medication_id'] = $order->id;
                $input['seller_id'] = $auth;
                $input['variation '] = '';
                $input['price'] = $price[$key] * $qty[$key];
                $input['tax '] = 0;
                $input['quantity'] = $qty[$key];
                MedicationDetails::create($input);
            }
            // med_status
            $medUupdate = User::find($request->id);
            $cid = User::whereRaw('cid = (select max(`cid`) from users)')->first('cid');
            $date = date('Ymd');
            if (empty($medUupdate->cid)) {
                if (!empty($cid)) {
                    $medUupdate->cid = $cid->cid + 1;
                } else {
                    $medUupdate->cid = $date . '001';
                }
            }
            $medUupdate->medication = 'Yes';
            $medUupdate->med_status = 1;
            $medUupdate->med_upcoming = $request->date;
            $medUupdate->preiod = $request->preiod;
            $medUupdate->save();
            $order->grand_total = $request->subtotal;
            // dd($order->grand_total);
            $order->save();
            // stores the pdf for invoice
            $pdf = PDF::loadView('invoices.medication', compact('order'));
            $output = $pdf->output();
            file_put_contents(public_path() . '/invoices/' . 'Order#' . $order->code . '.pdf', $output);

            $array['view'] = 'emails.invoice';
            $array['subject'] = 'Your Invoice - ' . $order->code;
            $array['from'] = 'support@shundorjo.com';
            $array['content'] = 'Hi. Your order has been placed';
            $array['file'] = public_path() . '/invoices/Order#' . $order->code . '.pdf';
            $array['file_name'] = 'Order#' . $order->code . '.pdf';
            $array['subjectsingle'] = 'Order Placed - ' . $order->code;

            // sends email to customer with the invoice pdf attached
            Mail::to($email)->queue(new InvoiceEmailManager($array));

            Mail::send('emails.medication_order', compact('order'), function ($message) use ($array, $email) {
                $message->from('support@shundorjo.com', 'Shundorjo Care');
                $message->to($email)
                    ->subject($array['subjectsingle']);
            });

            unlink($array['file']);

            $request->session()->put('order_id', $order->id);

            if ($request->medication == 'Yes') {
                flash(__('Medication Added successfully'))->success();
                return redirect()->route('madication.newuser');
            }
            if ($request->medication == 'No') {
                flash(__('Medication Added successfully'))->success();
                return redirect()->route('customers.index');
            }
            if ($request->medication == NULL) {
                flash(__('Medication Added successfully'))->success();
                return redirect()->route('medication.userneworder');
            }
        }
    }

    // admin part

    // user part start
    public function userOrderConfirm(Request $request)
    {
        // create order
        $order = new Medication();
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;
        $region = $request->region;
        $city = $request->city;
        $area = $request->area;
        $post_code = $request->post_code;
        $order_id = $request->order_id;
        // ship
        $data['name'] = $name;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['address'] = $address;
        $data['region'] = $region;
        $data['city'] = $city;
        $data['area'] = $area;
        $data['post_code'] = $post_code;
        $shipping_info = $data;

        $order->user_id = $request->user_id;
        $order->shipping_address = json_encode($shipping_info);
        $order->payment_type = $request->payment_option;
        $order->payment_status = 'unpaid';
        $order->code = $order_id;
        $order->shipping_cost = $request->shipping_cost;
        $order->grand_total = $request->subtotal;
        $order->date = strtotime(date('d-m-Y'));
        $order->viewed = 0;
        $order->upcoming_date = $request->date;
        $order->upcoming = 1;

        if ($order->save()) {
            $product_ids = $request->product_id;
            $price = $request->price;
            $qty = $request->qty;

            foreach ($product_ids as $key => $product_id) {
                $input['product_id'] = $product_id;
                $input['medication_id'] = $order->id;
                $input['seller_id'] = Auth::user()->id;
                $input['variation '] = '';
                $input['price'] = $price[$key] * $qty[$key];
                $input['tax '] = 0;
                $input['quantity'] = $qty[$key];
                $input['payment_status'] = 'unpaid';
                $input['delivery_status'] = 'pending';
                MedicationDetails::create($input);
            }
            // med_status
            $medUupdate = User::find(Auth::user()->id);
            // $cid= User::whereRaw('cid = (select max(`cid`) from users)')->first('cid');
            // $newid = $cid+1;
            // if(empty($medUupdate->cid)){
            //     if($cid) {
            //         $medUupdate->cid = $newid;
            //     }else{
            //         $medUupdate->cid = 10000001;
            //     }
            // }
            $medUupdate->medication = 'Yes';
            $medUupdate->med_status = 1;
            $medUupdate->med_upcoming = $request->date;
            $medUupdate->preiod = $request->preiod;
            $medUupdate->save();
        }
        // stores the pdf for invoice
        $pdf = PDF::loadView('invoices.medication', compact('order'));
        $output = $pdf->output();
        file_put_contents(public_path() . '/invoices/' . 'Order#' . $order->code . '.pdf', $output);

        $array['view'] = 'emails.invoice';
        $array['subject'] = 'Order Placed - ' . $order->code;
        $array['from'] = 'support@shundorjo.com';
        $array['content'] = 'Hi. Your order has been placed';
        $array['file'] = public_path() . '/invoices/Order#' . $order->code . '.pdf';
        $array['file_name'] = 'Order#' . $order->code . '.pdf';

        //sends email to customer with the invoice pdf attached

        Mail::to($email)->queue(new InvoiceEmailManager($array));

        unlink($array['file']);

        // $request->session()->put('order_id', $order->id);
        flash(__('New Custom Order added successfully'))->success();
        return redirect()->route('usermedication.view');
    }
    // user part
    public function userMedicationView(Request $request)
    {
        $medication = Medication::with('medicationDetails')->where('user_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->limit(1)->first();
        return view('frontend.medication.view', compact('medication'));
    }

    public function adminprescription()
    {
        // dd($customers);
        $prescriptions = PrescriptionImage::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('medication.prescription', compact('prescriptions'));
    }

    public function adminprescriptionUpload(Request $request)
    {


        try {
            $data = new PrescriptionImage();
            $data->user_id = $request->patientid;
            $request->validate([
                'prescription_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time() . $rand . '.' . $request->prescription_image->extension();
            $request->prescription_image->move(public_path('prescriptions'), $imageName);
            $data->image = $imageName;
            $data->created_by = Auth::user()->id;
            $data->save();

            $message = "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status' => 300, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['status' => 303, 'message' => 'Server Error!!']);
        }
    }

    public function medUserView(Request $request)
    {
        $medication = Medication::with('medicationDetails')->where('user_id', '=', decrypt($request->id))->first();
        return view('medication.view', compact('medication'));
    }

    public function medUserEdit(Request $request)
    {
        $medication = Medication::with('medicationDetails')->where('user_id', '=', decrypt($request->id))->first();
        $peoducts = Product::all();
        $user = User::where('id', '=', decrypt($request->id))->first('preiod');
        return view('medication.edit', compact('medication', 'peoducts', 'user'));
    }
    public function medUserUpdate(Request $request)
    {
        if (DB::delete('delete from medication_details where medication_id = ?', [$request->medication_id])) {
            if (empty($request->product_id)) {
                DB::delete('delete from medications where user_id = ?', [$request->user_id]);
                $medUupdate = User::find($request->user_id);
                $medUupdate->med_status = 0;
                $medUupdate->med_upcoming = NULL;
                $medUupdate->preiod = NULL;
                $medUupdate->save();
                flash(__('Medication List Empty'))->success();
                return redirect()->route('medication.index');
            } else {
                $mednewUpdate = Medication::find(Medication::where('user_id', '=', $request->user_id)->first()->id);
                $mednewUpdate->upcoming_date = $request->date;
                $mednewUpdate->save();

                $usernewUpdate = User::find($request->user_id);
                $usernewUpdate->med_upcoming = $request->date;
                $usernewUpdate->preiod = $request->preiod;
                $usernewUpdate->save();

                $product_ids = $request->product_id;
                $med_id = $request->medication_id;
                $city = $request->city;
                $price = $request->price;
                $qty = $request->qty;
                if ($city == 'Dhaka') {
                    $shipping = 60;
                } else {
                    $shipping = 120;
                }
                foreach ($product_ids as $key => $product_id) {
                    $input['product_id'] = $product_id;
                    $input['medication_id'] = $med_id;
                    $input['seller_id'] = Auth::user()->id;
                    $input['variation '] = '';
                    $input['price'] = $price[$key] * $qty[$key];
                    $input['tax '] = 0;
                    $input['shipping_cost'] = $shipping;
                    $input['quantity'] = $qty[$key];
                    $input['payment_status'] = 'unpaid';
                    $input['delivery_status'] = 'pending';
                    MedicationDetails::create($input);
                }

                flash(__('Medication List Update succesfully'))->success();
                return redirect()->route('medication.index');
            }
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }
    public function medUserOrder(Request $request)
    {
        $order = new Order;
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;
        $region = $request->region;
        $city = $request->city;
        $area = $request->area;
        $post_code = $request->post_code;
        $order_id = $request->order_id;
        $totalprice = $request->total_price;
        $shipping_cost = $request->shipping_cost;
        // ship
        $data['name'] = $name;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['address'] = $address;
        $data['region'] = $region;
        $data['city'] = $city;
        $data['area'] = $area;
        $data['post_code'] = $post_code;
        $shipping_info = $data;

        $order->user_id = $request->user_id;
        $order->shipping_address = json_encode($shipping_info);
        $order->payment_type = $request->payment_option;
        $order->code = $request->code;
        $order->shipping_cost = $request->shipping_cost;
        $order->grand_total = $totalprice;
        $order->meduserorder = 1;
        $order->delivery_status = $request->delivery_status;
        $order->date = strtotime(date('d-m-Y'));
        $order->upcoming_date = $request->date;
        $order->upcoming = 0;

        if ($order->save()) {
            $product_ids = $request->product_id;
            $price = $request->price;
            $qty = $request->qty;
            $auth = Auth::user()->id;
            if ($city == 'Dhaka') {
                $shipping = 60;
            } else {
                $shipping = 120;
            }
            foreach ($product_ids as $key => $product_id) {
                $input['product_id'] = $product_id;
                $input['order_id'] = $order->id;
                $input['seller_id'] = $auth;
                $input['variation '] = '';
                $input['price'] = $price[$key] * $qty[$key];
                $input['tax '] = 0;
                $input['shipping_cost'] = $shipping;
                $input['quantity'] = $qty[$key];
                OrderDetail::create($input);
            }
        }
        // stores the pdf for invoice
        $pdf = PDF::loadView('invoices.customer_invoice', compact('order'));
        $output = $pdf->output();
        file_put_contents(public_path() . '/invoices/' . 'Order#' . $order->code . '.pdf', $output);
        $array['view'] = 'emails.invoice';
        $array['subject'] = 'Order Placed - ' . $order->code;
        $array['from'] = 'support@shundorjo.com';
        $array['content'] = 'Hi. Your order has been placed';
        $array['file'] = public_path() . '/invoices/Order#' . $order->code . '.pdf';
        $array['file_name'] = 'Order#' . $order->code . '.pdf';
        Mail::to($request->email)->queue(new InvoiceEmailManager($array));
        unlink($array['file']);
        $request->session()->put('order_id', $order->id);

        //  user data update
        $preiodUpdate = User::find($request->user_id);
        $duedate = Carbon::createFromFormat('Y-m-d', $preiodUpdate->med_upcoming);
        $newdate = $duedate->addDays($preiodUpdate->preiod);
        //  meication data update
        $medupdates = Medication::find(Medication::where('user_id', $request->user_id)->first()->id);
        $medupdates->upcoming_date =  $newdate;
        $medupdates->save();
        //  user data update
        $preiodUpdate->med_upcoming = $newdate;
        $preiodUpdate->save();

        flash(__('Your Medication Created successfully'))->success();
        return redirect()->route('medication.index');
    }
    public function medDelete(Request $request)
    {
        $meUser = User::find($request->id);
        $meUser->medication = 'Yes';
        $meUser->med_status = 0;
        $meUser->med_upcoming = NULL;
        $meUser->preiod = NULL;
        $meUser->save();

        flash(__('Medication User Deactive successfully'))->success();
        return redirect()->route('medication.index');
    }
    // user part
    public function userMedicationEdit(Request $request)
    {
        // dd(decrypt($request->id));
        $medication = Medication::with('medicationDetails')->where('user_id', '=', decrypt($request->id))->first();
        $peoducts = Product::all();
        $user = User::where('id', '=', decrypt($request->id))->first('preiod');
        return view('frontend.medication.edit', compact('medication', 'peoducts', 'user'));
    }

    public function userMedicationUpdate(Request $request)
    {
        if (DB::delete('delete from medication_details where medication_id = ?', [$request->medication_id])) {
            if (empty($request->product_id)) {
                DB::delete('delete from medications where user_id = ?', [$request->user_id]);
                $medUupdate = User::find($request->user_id);
                $medUupdate->med_status = 0;
                $medUupdate->med_upcoming = NULL;
                $medUupdate->preiod = NULL;
                $medUupdate->save();
                // flash(__('Medication List Empty'))->error();
                return redirect()->route('usermedication.index');
            } else {
                $mednewUpdate = Medication::find(Medication::where('user_id', '=', $request->user_id)->first()->id);
                $mednewUpdate->upcoming_date = $request->date;
                $mednewUpdate->save();

                $usernewUpdate = User::find($request->user_id);
                $usernewUpdate->med_upcoming = $request->date;
                $usernewUpdate->preiod = $request->preiod;
                $usernewUpdate->save();

                $product_ids = $request->product_id;
                $med_id = $request->medication_id;
                $price = $request->price;
                $qty = $request->qty;
                foreach ($product_ids as $key => $product_id) {
                    $input['product_id'] = $product_id;
                    $input['medication_id'] = $med_id;
                    $input['seller_id'] = Auth::user()->id;
                    $input['variation '] = '';
                    $input['price'] = $price[$key] * $qty[$key];
                    $input['tax '] = 0;
                    $input['quantity'] = $qty[$key];
                    $input['payment_status'] = 'unpaid';
                    $input['delivery_status'] = 'pending';
                    MedicationDetails::create($input);
                }
                flash(__('Medication List Update succesfully'))->success();
                return back();
            }
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }


    // new code for order now

    public function ordernow()
    {
        if (Auth::check()) {
            return redirect()->route('usermedication.index');
        }
        return view('frontend.ordernow');
    }


    //  front end medication order
    // image tik kora lagbo
    protected function user_order_register(Request $request)
    {

        $data = new RequestOrder;
        $data->patient_name = $request->name;
        $data->phone = $request->phone;
        $data->medicine_details = $request->medicine_details;

        if (!empty($request->prescription_image)) {
            if ($request->hasFile('prescription_image')) {
                $data->image = $request->file('prescription_image')->store('uploads/request_image');
            }
        }
        $data->address = $request->address;
        $data->read = 1;
        $data->status = 1;
        if ($data->save()) {
            flash(__('Your form submitted successfully'))->success();
            return redirect()->route('home');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }



    // user requested order/prescription
    public function userneworder()
    {
        // dd('sfs');
        $users = RequestOrder::all();

        $histories = DB::table('prescription_images')
            ->join('users', 'users.id', '=', 'prescription_images.user_id')
            ->join('histories', 'histories.user_id', '=', 'users.id')
            ->where('users.medication', '=', NULL)
            ->groupBy('prescription_images.user_id')
            ->get();
        // $users = User::with('history','prescriptionimage')->whereNull('medication')->orderBy('med_upcoming', 'ASC')->get();
        // dd($users);

        return view('medication.newuserorder', compact('users', 'histories'));
    }

    // request order history add
    public function history_add(Request $request)
    {
        $remark = RequestOrder::find($request->id);
        // dd($remark);
        $remark->remark = $request->remark;
        $remark->comment = $request->comment;
        $remark->redate = $request->redate;
        if ($remark->save()) {
            flash(__('Remark Added successfully'))->success();
            return redirect()->route('medication.userneworder');
        }
    }


    // upload_prescription
    public function upload_prescription()
    {
        return view('frontend.prescription.index');
    }

    public function upload_prescription_done(Request $request)
    {

        // dd('controller called');

        // $prescription = new PrescriptionImage();
        // $image = array();
        // if($request->hasFile('image')){
        //     foreach ($request->image as $key => $photo) {
        //         $path = $photo->store('uploads/prescription');
        //         array_push($image, $path);
        //         ImageOptimizer::optimize(base_path('public/').$path);
        //     }
        //     $prescription->image = json_encode($image);
        // }

        // new code
        if ($request->hasfile('image')) {
            foreach ($request->file('image') as $image) {
                $rand = mt_rand(100000, 999999);
                $name = time() . "_" . Auth::id() . "_" . $rand . "." . $image->getClientOriginalExtension();
                $image->move(public_path() . '/uploads/prescription/', $name);
                $data[] = $name;

                $pic = new PrescriptionImage();
                $pic->image = $name;
                $pic->mobile = $request->mobile;
                $pic->save();
            }
        }
        // new code

        if ($pic->save()) {
            flash(__('Prescription Added successfully'))->success();
            return redirect()->route('upload-prescription');
        } else {
            flash(__('Not Save'))->error();
            return redirect()->route('upload-prescription');
        }
    }

    public function viewPrescription()
    {

        $pimg = PrescriptionImage::groupBy('mobile')->get();
        // $pimg = PrescriptionImage::all();
        return view('pimage.index', compact('pimg'));
    }

    public function destroyPrescription($id)
    {
        if (PrescriptionImage::destroy($id)) {
            flash(__('Prescription Image has been deleted successfully'))->success();
            return back();
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function viewAllPrescription($id)
    {
        $mobile = PrescriptionImage::where('id', '=', decrypt($id))->first()->mobile;

        $pimg = PrescriptionImage::where('mobile', '=', $mobile)->orderBy('created_at', 'DESC')->get();
        // dd($pimg);
        // $pimg = PrescriptionImage::all();
        return view('pimage.allimage', compact('pimg'));
    }
}
