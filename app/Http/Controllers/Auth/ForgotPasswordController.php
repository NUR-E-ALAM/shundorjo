<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\MobileVerify;
use Mail;
use Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return view('auth.forgetPassword');
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
        $user=DB::table('users')
            ->where('email', $request->email)->orWhere('phone', $request->email)
            ->first();
        if($user != null){
          if(is_numeric($request->get('email'))){
            // start phone
            $phone = $request->email;
            $codeverify = rand(1234, 4568);
            $details=MobileVerify::where('phone',$request->email)->delete();
            $mobile_verify = new MobileVerify();
            $mobile_verify->code = $codeverify;
            $mobile_verify->phone = $request->email;

          if($mobile_verify->save()){
            $sms = "Your Shundorjo varification code is: $codeverify";
            // $url = 'https://www.24bulksmsbd.com/api/smsSendApi';
            // $data = array(
            //     'customer_id' => 128,
            //     'api_key' => 172929182721250301911695556,
            //     'message' =>$sms,	
            //     'mobile_no' => $phone
            // );
    


            
            // $curl = curl_init($url);
            // curl_setopt($curl, CURLOPT_POST, true);
            // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
            // $output = curl_exec($curl);
            // curl_close($curl);
            
            //   sms.dinisoftbd.com/login sms provider
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
        return redirect()->route('varify_otp',encrypt($phone));
      // dd($request->email);
        // end
          }
          elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $request->validate([
              'email' => 'required|email|exists:users',
          ]);
          $token = Str::random(64);
          DB::table('password_resets')->insert([
              'email' => $request->email,
              'token' => $token,
              'created_at' => Carbon::now()
            ]);

          Mail::send('emails.forgetPassword', ['token' => $token], function($message) use($request){
            $message->from('info@shundorjo.com', 'shundorjo');
            $message->to($request->email);
            $message->subject('Reset Password');
          });

          return back()->with('message', 'We have e-mailed your password reset link!');
          }

        }else {
          flash(__('Opps! Credential Did not match'))->error();
          return back();
      }
      }
      // mobile otp varify

      public function varify_otp($phone)
      {
        $phone =decrypt($phone);
        return view('auth.otp_verify', compact('phone'));
      }

      public function varify_code(Request $request)
      {
        $phone =$request->phone;
        $verify = MobileVerify::where('phone', $request->phone)->first()->code;
        if($verify==$request->otp){
          return redirect()->route('otp.varified',encrypt($phone));
        }else{
          flash(__('Opps! OTP code Did not match'))->error();
          return back();
        }
      }

      public function shwotpfrom($phone)
      {
        $phone =decrypt($phone);
        return view('auth.verify_otp', compact('phone'));
      }

      public function varified(Request $request)
      {
        $request->validate([
          'password' => 'required|string|min:6|confirmed',
          'password_confirmation' => 'required'
      ]);

      $updatePassword = DB::table('mobile_verifies')
                          ->where([
                            'phone' => $request->phone,
                          ])
                          ->first();

      if(!$updatePassword){
          return back()->withInput()->with('error', 'Invalid token!');
      }

      $user = User::where('phone', $request->phone)
                  ->update(['password' => Hash::make($request->password), 'status'=>1]);

      DB::table('mobile_verifies')->where(['phone'=> $request->phone])->delete();

      flash(__('Your password has been changed!'))->success();
      return redirect()->route('user.login');
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) {
         return view('auth.forgetPasswordLink', ['token' => $token]);
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);

          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email,
                                'token' => $request->token
                              ])
                              ->first();

          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }

          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);

          DB::table('password_resets')->where(['email'=> $request->email])->delete();

          flash(__('Your password has been changed!'))->success();
          return redirect()->route('user.login');
        //   return redirect('/login')->with('message', 'Your password has been changed!');
      }
}
