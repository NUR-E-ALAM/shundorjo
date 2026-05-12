<?php

namespace App\Http\Controllers;

use App\Models\Message;
use DB;
use PDF;
use Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    // ******************************** user part ****************************
    public function index()
    {
        $msg = Message::where('user_id', '=', Auth::user()->id)->orWhere('patient_id','=', Auth::user()->id)->orderBy('created_at', 'ASC')->get();
        return view('frontend.message.index', compact('msg'));
    }

    public function userMessage()
    {
        $usermsg = DB::table('messages')
                ->select('messages.*','users.*')
                ->join('users', 'messages.user_id', '=', 'users.id')
                ->where('messages.user_id', '=', Auth::user()->id)
                ->orderBy('messages.id', 'DESC')
                ->get();

       $messages=DB::table('messages')
            ->select('messages.*','users.*')
            ->join('users', 'messages.user_id', '=', 'users.id')
            ->groupBy('messages.user_id')
            ->orderBy('messages.id', 'DESC')
            ->get();
        // dd($messages);
        $msg = Message::orderBy('id', 'ASC')->get();
        return view('message.index', compact('msg','messages','usermsg'));
    }

    public function store(Request $request)
    {
        try{
            $data = new Message();
            $data->user_id= Auth::user()->id;
            $data->sms= $request->usermessage;
            $data->read= "0";
            $data->created_by= Auth::user()->id;
            $data->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);

        }catch (\Exception $e){
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);

        }
    }

    // ****************************** admin part *************************************
    public function userMessageShow($id)
    {
    $userid = decrypt($id);
    $usermsg = Message::where('user_id', '=', $userid)->orderBy('created_at', 'ASC')->get();
    // left
    $messages = DB::table('messages')
                ->groupBy('user_id')
                ->orderBy('created_at', 'ASC')
                ->get();
        DB::update('update messages set `read` = ? where user_id = ?',[1,$userid]);
        $msg = Message::orderBy('created_at', 'ASC')->get();
        return view('message.index', compact('msg','messages','usermsg'));
    }
    public function adminMsgStore(Request $request)
    {
        try{
            $data = new Message();
            $data->patient_id= Auth::user()->id;
            $data->user_id= $request->msguserid;
            $data->sms= $request->usermessage;
            $data->read= "0";
            $data->created_by= Auth::user()->id;
            $data->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);

        }catch (\Exception $e){
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);

        }
    }
}
