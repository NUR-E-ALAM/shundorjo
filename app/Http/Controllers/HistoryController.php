<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Rmhistory;
use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $history = new History();
        $history->user_id = $request->id;
        $history->discription = $request->comment;
        $history->remark = $request->remark;
        $history->remark_date = $request->redate;
        $history->status = 1;
        if($history->save()){
            $userUpdate = User::find($request->id);
            $userUpdate->remark = $request->remark;
            $userUpdate->remark_date = $request->redate;
            if($userUpdate->history_count==NULL){
                $userUpdate->history_count = 1;
            }else{
                $userUpdate->history_count = $userUpdate->history_count+1;
            }
            $userUpdate->save();
            flash(__('History Added successfully'))->success();
            if($userUpdate->medication==NULL){
                return redirect()->route('medication.userneworder');
            }else{
                return redirect()->route('madication.newuser');
            }
        }flash(__('History not save'))->error();
        return back();
    }
    
    public function userMessageStore(Request $request)
    {
        $history = new History();
        $history->user_id = $request->id;
        $history->discription = $request->comment;
        $history->remark = $request->remark;
        $history->remark_date = $request->redate;
        $history->status = 1;
        if($history->save()){
            $userUpdate = User::find($request->id);
            $userUpdate->remark = $request->remark;
            $userUpdate->remark_date = $request->redate;
            if($userUpdate->history_count==NULL){
                $userUpdate->history_count = 1;
            }else{
                $userUpdate->history_count = $userUpdate->history_count+1;
            }
            $userUpdate->save();
            flash(__('History Added successfully'))->success();
            return redirect()->route('customers.index');

        }flash(__('History not save'))->error();
        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function show(History $history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function destroy(History $history)
    {
        //
    }
    public function regularMedicationhistory(Request $request)
    {
        $history = new History();
        $history->rm_id = $request->id;
        $history->discription = $request->comment;
        $history->remark = $request->remark;
        $history->remark_date = $request->redate;
        $history->status = 1;
        if($history->save()){
            flash(__('History Added successfully'))->success();
            return redirect()->route('user-message.index');
        }flash(__('History not save'))->error();
        return back();
    }
}
