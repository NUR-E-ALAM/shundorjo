<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Auth;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.purchase_history', compact('orders'));
    }

    public function orderpayment(Request $request)
    {
        $data['amount'] = $request->amount;
        $data['payment_method'] = $request->payment_option;
        $data['tran_id'] = $request->tran_id;

        // dd($data);

        $request->session()->put('payment_type', 'medorder');
        $request->session()->put('payment_data', $data);

        if ($request->payment_option == 'medorder') {
            $sslcommerz = new SslCommerzPaymentController;
            return $sslcommerz->index($request);
        }
    }

    public function purchase_history_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        return view('frontend.partials.order_details_customer', compact('order'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
