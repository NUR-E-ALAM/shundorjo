<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Category;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\PayumoneyController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PublicSslCommerzPaymentController;
use App\Http\Controllers\OrderController;
use App\Models\Order;
use App\Models\BusinessSetting;
use Session;
use App\Models\PrescriptionImage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Response;
class CheckoutController extends Controller
{

    public function __construct()
    {
        //
    }

    //check the selected payment gateway and redirect to that controller accordingly
    public function checkout(Request $request)
    {

          $crt = Session :: get ('cart');
        if($crt->isNotEmpty() || $crt->isNotEmpty()==false){
        if(count($crt) == 0){
            flash(__('Sorry ! Your Shopping Cart is Empty.Firstly Item add to your cart!'))->error();
            return back();
        }
        }

        $orderController = new OrderController;
        $orderController->store($request);
        $request->session()->put('payment_type', 'cart_payment');

        if($request->session()->get('order_id') != null){
            if($request->payment_option == 'paypal'){
                $paypal = new PaypalController;
                return $paypal->getCheckout();
            }
            elseif ($request->payment_option == 'sslcommerz') {
                $request->session()->put('cart', collect([]));
                $sslcommerz = new SslCommerzPaymentController;
                return $sslcommerz->index($request);
            }

            elseif ($request->payment_option == 'cash_on_delivery') {

                $request->session()->put('cart', collect([]));
                // $request->session()->forget('order_id');
                $orderid = $request->session()->get('order_id');
                // dd($request->all());
                // flash("Your order has been placed successfully")->success();
            	return redirect()->route('order.complete.message', $orderid);
            }
            elseif ($request->payment_option == 'wallet') {
                $user = Auth::user();
                $user->balance -= Order::findOrFail($request->session()->get('order_id'))->grand_total;
                $user->save();
                // return $this->checkout_done($request->session()->get('order_id'), null);
                $request->session()->put('cart', collect([]));
                $orderid = $request->session()->get('order_id');
                // flash("Your order has been placed successfully")->success();
            	return redirect()->route('order.complete.message', $orderid);
            }
        }else{
            // abort(404);
            return redirect()->route('home');
        }
    }

     public function guestCheckout(Request $request){
        $crt = Session :: get ('cart');
        if($crt->isNotEmpty() || $crt->isNotEmpty()==false){
        if(count($crt) == 0){
            flash(__('Sorry ! Your Shopping Cart is Empty.Firstly Item add to your cart!'))->error();
            return back();
        }
        }
        $request->validate([
            'phone' => 'required|regex:/^(?:\+88)?01[3-9]\d{8}$/',
        ], [
            'phone.regex' => 'সঠিক ফোন নম্বর দিন (যেমনঃ 01XXXXXXXXX)!',
        ]);


        $orderController = new OrderController;
        $orderController->gustStore($request);
        $request->session()->put('cart', collect([]));
                // $request->session()->forget('order_id');
                $orderid = $request->session()->get('order_id');
                //  dd($orderid);
                // flash("Your order has been placed successfully")->success();
            	return redirect()->route('order.complete.message', $orderid);

    }

    public function orderCompleteMessage($id)
    {
        // dd($id);
        $order = Order::findOrFail($id);
        return view('frontend.partials.success', compact('order'));
    }

    //redirects to this method after a successfull checkout
    public function checkout_done($order_id, $payment)
    {
        $order = Order::findOrFail($order_id);
        $order->payment_status = 'paid';
        $order->payment_details = $payment;
        $order->save();

        $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
        foreach ($order->orderDetails as $key => $orderDetail) {
            if($orderDetail->product->user->user_type == 'seller'){
                $seller = $orderDetail->product->user->seller;
                $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price*(100-$commission_percentage))/100;
                $seller->save();
            }
        }

        Session::put('cart', collect([]));
        Session::forget('order_id');
        Session::forget('payment_type');

        flash(__('Payment completed'))->success();
        return redirect()->route('home');
    }

    public function get_shipping_info(Request $request)
    {
        // if(count(Session :: get ('cart')) === 0){
        //     flash(__('Your Shopping Cart is Empty.'))->error();
        //     return back();
        // }
        // dd(session('cart'));
        $categories = Category::all();
        return view('frontend.partials.shipping_info', compact('categories'));
    }
    public function gustshipping_info(Request $request)
    {
        $categories = Category::all();

        $gust = 1;

        return view('frontend.partials.guest_checkout', compact('categories','gust'));
    }

    public function gustshipping_infoNew(Request $request)
    {
            $request->session()->put('shipCost', $request->value);
            return view('frontend.partials.cart_summary');
    }

    public function get_payment_info(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'chk' => 'required',
        ]);
        // dd($request->all());

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['region'] = $request->region;
        $data['city'] = $request->city;
        $data['area'] = $request->area;
        $data['post_code'] = $request->post_code;
        $data['checkout_type'] = $request->checkout_type;
        $shipping_info = $data;

        // image
        if ($request->hasfile('photos')) {
            foreach ($request->file('photos') as $image) {
                $rand = mt_rand(100000, 999999);
                $name = time() . "_" . Auth::id() . "_" . $rand . "." . $image->getClientOriginalExtension();
                $image->move(public_path() . '/uploads/prescription/', $name);
                $data[] = $name;

                $pic = new PrescriptionImage();
            if(Auth::user()->id){
                $pic->user_id = Auth::user()->id;
            }
                $pic->image = $name;
                $pic->patient_name = $request->name;
                $pic->mobile = $request->phone;
                $pic->medicine_details = 'order';
                $pic->status = 0;
                $pic->save();
            }
        }

        $request->session()->put('shipping_info', $shipping_info);
        $shipcost= $request->shipping;
        $request->session()->put('shipcost', $shipcost);
        return view('frontend.partials.payment_select');
    }
}
