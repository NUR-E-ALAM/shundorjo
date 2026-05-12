<?php

namespace App\Http\Controllers;

use App\Models\AgentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
class AffiliateController extends Controller
{
    public function index()
    {
        $affiliate = User::where('ref_by', '=', Auth::user()->ref_id)->whereNotNull('ref_by')->get();
        return view('frontend.affiliate',compact('affiliate'));
    }

    public function userRequest(Request $request)
    {

       

        $aff = new AgentRequest();
        $aff->user_id= Auth::user()->id;
        $aff->save();
        if($aff->save()){
            flash(__('Request submited successfully'))->success();
        return redirect()->route('affiliate.index');
        }else{
            flash(__('Not Save'))->error();
        return redirect()->route('affiliate.index');
        }


    }

    public function userlist()
    {

        $affiliate =  DB::table('users')
            ->select('users.*','agent_requests.user_id','agent_requests.id as arid')
            ->join('agent_requests','agent_requests.user_id','=','users.id')
            ->get();


        // $affiliate = AgentRequest::where('ref_by', '=', Auth::user()->ref_id)->get();
        return view('affiliate.request', compact('affiliate'));
    }
    
    public function affiliateUserStore(Request $request)
    {
        $rand = mt_rand(10000000, 99999999);
        $ref_id = "AFF". $rand;
        $userid = User::where('id','=', $request->user_id)->first()->id;
        // dd( $userid);
        $aff = User::find($userid);
        $aff->ref_id= $ref_id;
        $aff->save();
        if($aff->save()){
            if(AgentRequest::destroy(AgentRequest::where('user_id', '=', $request->user_id)->first()->id)){
                flash(__('Affiliate user link created successfully'))->success();
                return redirect()->route('affiliate-user.index');
            }
        }else{
            flash(__('Not Save'))->error();
            return redirect()->route('affiliate-user.index');
        }
    }
    
    public function affiliateuser()
    {
        $affiliate = User::whereNotNull('ref_id')->get();

        return view('affiliate.index',compact('affiliate'));
    }




}
