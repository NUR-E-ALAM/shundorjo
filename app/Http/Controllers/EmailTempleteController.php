<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplete;
use Illuminate\Http\Request;

class EmailTempleteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $email = EmailTemplete::where('status', '=', 1)->get();
        return view('email-templete.index', compact('email'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('email-templete.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email = new EmailTemplete();
        $email->templete = $request->templete;
        $email->description = $request->description;
        $email->footer = $request->footer;
        $email->status = 1;
        $email->save();
        flash(__('Education has been inserted successfully'))->success();
        return redirect()->route('emailtemplete.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmailTemplete  $emailTemplete
     * @return \Illuminate\Http\Response
     */
    public function show(EmailTemplete $emailTemplete)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmailTemplete  $emailTemplete
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd(decrypt($id));
        $email = EmailTemplete::where('id',decrypt($id))->first();
        // return view('email-templete.index', compact('email'));
        return view('email-templete.edit', compact('email'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailTemplete  $emailTemplete
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailTemplete $emailTemplete)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmailTemplete  $emailTemplete
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplete $emailTemplete)
    {
        //
    }


    public function sendsms(Request $request)
    {
    //     $phone = $request->mobile;
    //     $sms = "test sms";
    //     $From = "Apon Health";

    //     $curl = curl_init();
    //   curl_setopt_array($curl, array(
    //       CURLOPT_URL => "https://api.mobireach.com.bd/SendTextMessage?Username=lextlink&Password=Dhaka@5599&From=Apon%20Health&To=88".$phone."&Message=".urlencode("Your sms is smoothly done-> " . $sms )."",
          
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
    $client_mobile = $request->mobile;
    $sms = htmlspecialchars_decode('new sns test');
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.mobireach.com.bd/SendTextMessage?Username=lextlink&Password=Dhaka@5599&From=Apon%20Health&To=88".$client_mobile."&Message=".urlencode($sms )."",
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

      flash(__('sms send successfully'))->success();
            return redirect()->route('emailtemplete.index');

    }
    //         $sms= Smssetting::where('admin_id',Auth::user()->id)->first();
    //          if($sms->salesms==1){
    //             $customer=Customer::find($request->cus_name);
    //             $url = "http://66.45.237.70/api.php";
    //     $number=$customer->cus_phone;
    //     $text=("Dear ".$customer->cus_name .', '."your total invoice amount is ".$request->totalbill.' BDT. '. $sms->salesmstext);
    //     $data= array(
    //     'username'=>"mtshoejjs",
    //     'password'=>"76PCMA559D",
    //     'number'=>"$number",
    //     'message'=>"$text"
    //     );
    //     //dd($data); exit;
    //     $ch = curl_init(); // Initialize cURL
    //     curl_setopt($ch, CURLOPT_URL,$url);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $smsresult = curl_exec($ch);
    //     $p = explode("|",$smsresult);
    //     $sendstatus = $p[0];
    // }
}
