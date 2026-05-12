<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Master;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\MobileVerify;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required','regex:/^([0-9\s\-\+\(\)]*)$/','min:11'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function store(Request $data)
    {


 $existingUser = User::where('phone', $data['email'])->exists();
            if ($existingUser) {
            //  return 'The ' . $data['name'] . ' has already been taken.';
               flash(__('Opps!'.'The ' . $data['name'] . ' has already been taken.'))->error();
        return back();
            }
		      //  dd($existingUser);
    if($data['password']==$data['password_confirmation']){
        $phone = $data['email'];
        $codeverify = rand(1234, 4568);
        $user = User::create([
          'name' => $data['name'],
          'phone' => $data['email'],
          'password' => Hash::make($data['password']),
          'email_verified_at' => now(),
          'status' => 0,

        ]);
        $user_id = $user->id;

        $mobile_verify = new MobileVerify();
        $mobile_verify->user_id = $user_id;
        $mobile_verify->phone = $phone;
        $mobile_verify->code = $codeverify;

      if($mobile_verify->save()){

            $sms = "Your Shundorjo varification code is: $codeverify";
            Session::put('varificationOTP', $codeverify);
            $url = "http://103.177.125.106:7788/sendtext";

             $data= array(
        'apikey'=>"827a411ae89db070",
        'secretkey'=>"aeedeb97",
        'callerID'=>"shundorjo",
        'toUser'=>"$phone",
        'messageContent'=>"$sms"
        );
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("/",$smsresult);
        $sendstatus = $p[0];





      }

        return redirect()->route('varified',encrypt($user_id));
        // return redirect()->route('dashboard');
    }else{
        flash(__('Opps! Password Did not match'))->error();
        return back();
    }

    }

    public function varified($user_id){
        $user = User::where('id', decrypt($user_id))->first();
        return view('frontend.verify', compact('user'));
    }

    public function varifiedconfirm(Request $request)
    {
        $id = MobileVerify::where('user_id',$request->user_id)->first();
        if($id){
            $varify_code = MobileVerify::find($id->id);
            if($varify_code->code == $request->verification_code){
                $user = User::find($request->user_id);
                $user->status= 1;
                $user->save();
                $details=MobileVerify::where('user_id',$request->user_id)->delete();
                auth()->login($user, true);
                if(Session::has('cart')){
                    flash(__('Account create successfully. Please add your address first'))->success();
                    return redirect()->route('checkout.shipping_info');
                }else{
                    flash(__('Account Varified successfully!'))->success();
                    return redirect()->route('dashboard');
                }
            }else{
                flash(__('Sorry! wrong varified code'))->error();
            return back();
            }
        }else{
            flash(__('Sorry! wrong varified code'))->error();
            return back();
        }

    }

    public function resendotp(Request $request)
    {
        $detail = MobileVerify::where('user_id', $request->user_id)->first();
        if($detail){
            $details=MobileVerify::where('user_id',$request->user_id)->delete();
            $phone = $request->phone;
            $codeverify = rand(1234, 4568);
            $mobile_verify = new MobileVerify();
            $mobile_verify->user_id = $request->user_id;
            $mobile_verify->code = $codeverify;

        if($mobile_verify->save()){


            // sms.dinisoftbd.com/login sms provider
             $url = "http://103.177.125.106:7788/sendtext";
    $text="Your Shundorjo varification code is: $codeverify";
    $request->session()->put('varificationOTP', $codeverify);
        $data= array(
         'apikey'=>"827a411ae89db070",
        'secretkey'=>"aeedeb97",
        'callerID'=>"shundorjo",
        'toUser'=>"$phone",
        'messageContent'=>"$text"
        );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("/",$smsresult);
        $sendstatus = $p[0];
        // dd($sendstatus);


        }
        return redirect()->route('varified',encrypt($request->user_id));

    }else{
        $phone = $request->phone;
        $codeverify = rand(1234, 4568);
        $mobile_verify = new MobileVerify();
        $mobile_verify->user_id = $request->user_id;
        $mobile_verify->code = $codeverify;

    if($mobile_verify->save()){
        $sms = "Your Shundorjo varification code is: $codeverify";
       $request->session()->put('varificationOTP', $codeverify);

        $url = "http://103.177.125.106:7788/sendtext";
             $data= array(
         'apikey'=>"827a411ae89db070",
        'secretkey'=>"aeedeb97",
        'callerID'=>"shundorjo",
        'toUser'=>"$phone",
        'messageContent'=>"$sms"
        );
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("/",$smsresult);
        $sendstatus = $p[0];
    }
    return redirect()->route('varified',encrypt($request->user_id));
    }

    }

    public function resendsms(Request $request)
    {
        $detail = MobileVerify::where('user_id', $request->user_id)->first();
        if($detail){
            $details=MobileVerify::where('user_id',$request->user_id)->delete();
            $phone = $request->phone;
            $codeverify = rand(1234, 4568);
            $mobile_verify = new MobileVerify();
            $mobile_verify->user_id = $request->user_id;
            $mobile_verify->code = $codeverify;

        if($mobile_verify->save()){
            $sms = "Your Shundorjo varification code is: $codeverify";
            $request->session()->put('varificationOTP', $codeverify);


            $url = "http://103.177.125.106:7788/sendtext";
             $data= array(
         'apikey'=>"827a411ae89db070",
        'secretkey'=>"aeedeb97",
        'callerID'=>"shundorjo",
        'toUser'=>"$phone",
        'messageContent'=>"$sms"
        );
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("/",$smsresult);
        $sendstatus = $p[0];
        }
        flash(__('SMS Send succesfully'))->success();
        return "sms send";;

    }else{
        $phone = $request->phone;
        $codeverify = rand(1234, 4568);
        $mobile_verify = new MobileVerify();
        $mobile_verify->user_id = $request->user_id;
        $mobile_verify->code = $codeverify;

    if($mobile_verify->save()){
        $sms = "Your Shundorjo varification code is: $codeverify";
        $request->session()->put('varificationOTP', $codeverify);

        $url = "http://103.177.125.106:7788/sendtext";
             $data= array(
         'apikey'=>"827a411ae89db070",
        'secretkey'=>"aeedeb97",
        'callerID'=>"shundorjo",
        'toUser'=>"$phone",
        'messageContent'=>"$sms"
        );
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("/",$smsresult);
        $sendstatus = $p[0];
    }
    flash(__('SMS Send succesfully'))->success();
    return "sms send";
    }
    }

}
