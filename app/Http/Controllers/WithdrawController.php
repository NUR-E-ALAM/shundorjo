<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Withdraw;
use App\Models\User;
use App\Models\WithdrawMethod;
use DB;
use PDF;

class WithdrawController extends Controller
{
    public function admin_withdraw(Request $request)
    {

        $withdraws =  DB::table('withdraws')
                   ->leftjoin('users AS A', 'A.id', '=', 'withdraws.user_id')
                   ->leftjoin('users AS B', 'B.id', '=', 'withdraws.process_by')
                   ->select('withdraws.*','A.name as user_name','B.name as process_name')
                   ->get();

        // $withdraws = Withdraw::all();
        //dd($withdraws);
        return view('withdraw.index', compact('withdraws'));
    }

    public function show($id)
    {
        // $withdrawid = Withdraw::findOrFail(decrypt($id));
        // dd($withdrawid);
        $data = Withdraw::where('id', '=',(decrypt($id)))->get();
        //ss dd($data);
        $withdraws = Withdraw::findOrFail(decrypt($id));
        $withdraws->viewed = 1;
        $withdraws->save();
        return view('withdraw.show', compact('withdraws','data'));
    }

    public function destroy($id)
    {
        $order = Withdraw::findOrFail($id);
        if($order != null){
            $order->delete();
            flash('Order has been deleted successfully')->success();
        }
        else{
            flash('Something went wrong')->error();
        }
        return back();
    }

    public function update_delivery_status(Request $request)
    {
        $withdraws = Withdraw::findOrFail($request->withdraw_id);
        $withdraws->delivery_status = $request->status;
        $withdraws->process_by  = Auth::user()->id;
        $withdraws->save();
        return 1;
    }

    public function update_payment_status(Request $request)
    {
        $withdraws = Withdraw::findOrFail($request->withdraw_id);
        $withdraws->payment_status = $request->status;
        $withdraws->process_by  = Auth::user()->id;
        $withdraws->save();
        return 1;
    }

    public function index()
    {
        //$withdraws = Withdraw::where('user_id', Auth::user()->id)->paginate(9);
        $withdraws = Withdraw::where('user_id', Auth::user()->id)->get();
        return view('frontend.withdraw', compact('withdraws'));
    }

    public function cashout(Request $request)
    {
        if($request->amount > 499){
            
            if(Auth::user()->balance > $request->amount){
            
             $team = new Withdraw();
            $team->user_id= Auth::user()->id;
            $team->withdraw_type= "Bkash";
            $team->delivery_status= "Pending";
            $team->payment_status= "Unpaid";
            $team->amount= $request->amount;
            $team->viewed= "0";
            $team->created_by= Auth::user()->id;
            // $team->save();

            if($team->save()){
                
                $user = User::find(Auth::user()->id);
                $user->balance = $user->balance - $request->amount;
                $user->save();
                
                flash(__('Withdraw requested successfully'))->success();
                return redirect()->route('withdraw.index');
            }
            else{
                flash(__('Something went wrong'))->error();
                return back();
            }
            
        }
        else{
            flash(__('Insufficient Balance'))->error();
                return back();
        }
            
        }else{
            flash(__('You can not withdraw bellow 500 taka '))->error();
                return back();
        }
        
        
        
           
    }

    public function method()
    {
        $methods = WithdrawMethod::where('user_id', Auth::user()->id)->get();
        //dd($withdraws);
        return view('withdraw.method', compact('methods'));
    }

    public function methodInsert(Request $request)
    {
        
            $data = new WithdrawMethod();
            $data->user_id= Auth::user()->id;
            $data->bank_name= $request->bank_name;
            $data->acc_name= $request->acc_name;
            $data->acc_number= $request->acc_number;
            $data->branch= $request->branch;
            $data->mbanking_type= $request->mbanking_type;
            $data->remark= $request->remark;
            $data->created_by= Auth::user()->id;
            // $team->save();

            if($data->save()){
                flash(__('Withdraw Method Insert successfully'))->success();
                return redirect()->route('withdraw-method');
            }
            else{
                flash(__('Something went wrong'))->error();
                return back();
            }
    }

    public function methodUpdate(Request $request, $id)
    {
            $data = WithdrawMethod::findOrFail($id);
            $data->user_id= Auth::user()->id;
            $data->bank_name= $request->bank_name;
            $data->acc_name= $request->acc_name;
            $data->acc_number= $request->acc_number;
            $data->branch= $request->branch;
            $data->mbanking_type= $request->mbanking_type;
            $data->remark= $request->remark;
            $data->updated_by= Auth::user()->id;
            // $team->save();

            if ($data->save()) {
                $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Withdraw Method Updated Successfully.</b></div>";
                return response()->json(['status'=> 300,'message'=>$message]);
            }
            else{
                return response()->json(['status'=> 303,'message'=>'Something went wrong!!']);
            }

    }

    public function methodDelete($id)
    { 
        if(WithdrawMethod::where('id',$id)->first()->delete()){
            return response()->json(['success'=>true,'message'=>'Withdraw method deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
    }
}
