<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\History;
use App\Models\RegularMedication;
use App\Models\ShippingAddess;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Hash;

class RegularMedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("frontend.userform");
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
        $data = new RegularMedication;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->mobile = $request->phone;
        $data->address = $request->address;
        $data->message = $request->message;
        if ($data->save()) {
            flash(__('Your form submitted successfully'))->success();
            return redirect()->route('regularmedication.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RegularMedication  $regularMedication
     * @return \Illuminate\Http\Response
     */
    public function show(RegularMedication $regularMedication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RegularMedication  $regularMedication
     * @return \Illuminate\Http\Response
     */
    public function edit(RegularMedication $regularMedication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RegularMedication  $regularMedication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RegularMedication $regularMedication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RegularMedication  $regularMedication
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegularMedication $regularMedication)
    {
        //
    }

    public function showregularmedication()
    {

        $rmed = RegularMedication::orderBy('id', 'desc')->get();
        return view("medication.regular", compact('rmed'));
    }




    public function newmedicationuser(Request $request)
    {
        $regularusername = RegularMedication::where('id', '=', $request->rmid)->first()->name;
        $regularusermobile = RegularMedication::where('id', '=', $request->rmid)->first()->mobile;
        $regularuseremail = RegularMedication::where('id', '=', $request->rmid)->first()->email;
        $regularusermessage = RegularMedication::where('id', '=', $request->rmid)->first()->message;
        $finduser = User::where('phone', '=', $request->rmmobile)->first();

        if ($finduser) {

            History::where('rm_id', '=', $request->rmid)->update(['user_id' => $finduser->id]);

            if (RegularMedication::destroy(RegularMedication::where('id', '=', $request->rmid)->first()->id)) {
                flash(__('This mobile number has an account'))->success();
                return redirect()->route('user-message.index');
            }
        } else {

            $newuser = new User();
            $newuser->name = $regularusername;
            $newuser->phone = $regularusermobile;
            $newuser->password = Hash::make('123456');
            $newuser->email_verified_at = now();
            $newuser->medication = 'No';
            $newuser->status = '1';
            if ($newuser->save()) {

                $history = new History;
                $history->user_id = $newuser->id;
                $history->discription = $regularusermessage;
                $history->source = "Customer Message";
                $history->save();

                //email send
                $mail['subject'] = "Apon Health Register Confirmation";
                $mail['msg'] = "123456";
                $mail['email'] = $regularuseremail;
                $mail['phone'] = $regularusermobile;
                $email_to = $regularuseremail;
                Mail::send('emails.doctor', compact('mail'), function ($message) use ($mail, $email_to) {
                    $message->from('support@shundorjo.com', 'Shundorjo Care');
                    $message->to($email_to)
                        ->subject($mail['subject']);
                });
                // sms send
                $phone = $regularusermobile;
                $sms = "Your account user phone: " . $phone . ", and password: 123456 Please visit https://aponhealth.com/users/login";
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.mobireach.com.bd/SendTextMessage?Username=lextlink&Password=Dhaka@5599&From=Apon%20Health&To=88" . $phone . "&Message=" . urlencode($sms) . "",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache"
                    ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                History::where('rm_id', '=', $request->rmid)->update(['user_id' => $newuser->id]);

                $shipadd = new ShippingAddess;
                $shipadd->user_id = $newuser->id;
                if ($shipadd->save()) {

                    if (RegularMedication::destroy(RegularMedication::where('id', '=', $request->rmid)->first()->id)) {
                        flash(__('Medication user Added successfully'))->success();
                        return redirect()->route('user-message.index');
                    }
                }
            }
            flash(__('Medication user not save'))->error();
            return back();
        }
    }
}
