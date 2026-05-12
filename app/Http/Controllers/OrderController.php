<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Color;
use App\Models\OrderDetail;
use App\Models\ShippingMethod;
use App\Models\PrescriptionImage;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Master;
use App\Models\Upazila;
use App\Models\District;
use App\Models\Division;
use App\Models\MedicationCount;
use App\Http\ErrorTryCatch;
use Auth;
use Session;
use DB;
use PDF;
use Mail;
use App\Mail\InvoiceEmailManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('order_details.seller_id', Auth::user()->id)
            ->select('orders.id')
            ->distinct()
            ->paginate(9);

        return view('frontend.seller.orders', compact('orders'));
    }

    /**
     * Display a listing of the resource to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_orders(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            //->where('order_details.seller_id', Auth::user()->id)
            ->where('orders.meduserorder', 0)
            ->select('orders.id')
            ->distinct()
            ->get();


        return view('orders.index', compact('orders'));
    }
    // admin medication order

    public function admin_medorders(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            //->where('order_details.seller_id', Auth::user()->id)
            ->where('orders.meduserorder', 1)
            ->select('orders.id')
            ->distinct()
            ->get();

        return view('orders.medindex', compact('orders'));
    }

    // pending order
    public function admin_orders_pending(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.meduserorder', 0)
            ->where('orders.delivery_status', '=', 'pending')
            ->distinct()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // medication pending order
    public function admin_medorders_pending(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.delivery_status', '=', 'pending')
            ->where('orders.meduserorder', 1)
            ->distinct()
            ->get();

        return view('orders.medindex', compact('orders'));
    }

    // medication waiting order
    public function admin_medorders_wpayment(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.delivery_status', '=', 'wpayment')
            ->where('orders.meduserorder', 1)
            ->distinct()
            ->get();

        return view('orders.medindex', compact('orders'));
    }
    // medication pending order
    public function admin_orders_complain(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.delivery_status', '=', 'return')
            ->where('orders.meduserorder', 0)
            ->distinct()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // medication pending order
    public function admin_medorders_complain(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.delivery_status', '=', 'complain')
            ->where('orders.meduserorder', 1)
            ->distinct()
            ->get();

        return view('orders.medindex', compact('orders'));
    }

    // Processing
    public function admin_orders_processing(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.meduserorder', 0)
            ->where('orders.delivery_status', '=', 'processing')
            ->distinct()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // Medication Processing
    public function admin_medorders_processing(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.delivery_status', '=', 'processing')
            ->where('orders.meduserorder', 1)
            ->distinct()
            ->get();

        return view('orders.medindex', compact('orders'));
    }
    // on_delivery
    public function admin_orders_on_delivery(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.meduserorder', 0)
            ->where('orders.delivery_status', '=', 'on_delivery')
            ->distinct()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // medication  on_delivery
    public function admin_medorders_on_delivery(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.delivery_status', '=', 'on_delivery')
            ->where('orders.meduserorder', 1)
            ->distinct()
            ->get();

        return view('orders.medindex', compact('orders'));
    }

    // delivered
    public function admin_orders_delivered(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.meduserorder', 0)
            ->where('orders.delivery_status', '=', 'delivered')
            ->distinct()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // medication delivered
    public function admin_medorders_delivered(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.delivery_status', '=', 'delivered')
            ->where('orders.meduserorder', 1)
            ->distinct()
            ->get();

        return view('orders.medindex', compact('orders'));
    }
    // rejected
    public function admin_orders_rejected(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.meduserorder', 0)
            ->where('orders.delivery_status', '=', 'rejected')
            ->distinct()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // medication rejected
    public function admin_medorders_rejected(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.id')
            ->where('orders.delivery_status', '=', 'rejected')
            ->where('orders.meduserorder', 1)
            ->distinct()
            ->get();

        return view('orders.medindex', compact('orders'));
    }

    /**
     * Display a listing of the sales to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales(Request $request)
    {

        if (!empty($request->input('fromDate')) && !empty($request->input('toDate'))) {
            $fromDate = $request->input('fromDate');
            $toDate   = $request->input('toDate');
            $orders = Order::where([
                ['created_at', '>=', $fromDate],
                ['created_at', '<=', $toDate],
            ])->orderBy('code', 'desc')->get();
        } else {
            $orders = Order::orderBy('code', 'desc')->get();
        }

        return view('sales.index', compact('orders'));
    }

    /**
     * Display a single sale to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        return view('sales.show', compact('order'));
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
        // dd($request->all());
        try {
            DB::beginTransaction();
        $order = new Order;
        if (Auth::check()) {
            $order->user_id = Auth::user()->id;
        } else {
            $order->guest_id = mt_rand(100000, 999999);
        }
        $order->shipping_address = json_encode($request->session()->get('shipping_info'));
        $order->shipping_cost = (int)$request->session()->get('shipcost');
        $order->payment_type = $request->payment_option;
        if ($request->payment_option == 'wallet') {
            $order->payment_status = 'paid';
        }
        $order->code = date('Ymd-his');
        $order->date = strtotime(date('d-m-Y'));
        $order->upcoming = 0;

        if ($order->save()) {
            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            foreach (Session::get('cart') as $key => $cartItem) {
                $product = Product::find($cartItem['id']);
                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                $shipping += $cartItem['shipping'];
                // $shippingcost = $cartItem['shipping'];
                $product_variation = null;
                if (isset($cartItem['color'])) {
                    $product_variation .= Color::where('code', $cartItem['color'])->first()->name;
                }
                foreach (json_decode($product->choice_options) as $choice) {
                    $str = $choice->name; // example $str =  choice_0
                    if ($product_variation != null) {
                        $product_variation .= '-' . str_replace(' ', '', $cartItem[$str]);
                    } else {
                        $product_variation .= str_replace(' ', '', $cartItem[$str]);
                    }
                }

                if ($product_variation != null) {
                    $variations = json_decode($product->variations);
                    $variations->$product_variation->qty -= $cartItem['quantity'];
                    $product->variations = json_encode($variations);
                    $product->save();
                }

                $order_detail = new OrderDetail;
                $order_detail->order_id  = $order->id;
                $order_detail->seller_id = $product->user_id;
                $order_detail->product_id = $product->id;
                $order_detail->variation = $product_variation;
                $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                $order_detail->quantity = $cartItem['quantity'];
                $order_detail->save();
                $product->num_of_sale++;
                $product->save();
            }

            $drate = Master::where('softcode', '=', 'discount')->first()->hardcode / 100;
            $damount = $subtotal * $drate;

            $order->discount = $damount;
            $order->grand_total = $subtotal + $tax + $order->shipping_cost - $damount;
            if ($order->save()) {
                $order_id = $order->id;
                // DB::update('update prescription_images set order_id = ? , status = ? where user_id = ? and status = ?',[$order_id,1,Auth::user()->id,0]);
            }

            //stores the pdf for invoice

            // $pdf = PDF::loadView('invoices.customer_invoice', compact('order'));
            // $output = $pdf->output();
            // file_put_contents(public_path() . '/invoices/' . 'Order#' . $order->code . '.pdf', $output);
            // $array['view'] = 'emails.invoice';
            // $array['subject'] = 'Order Placed - ' . $order->code;
            // $array['from'] = 'info@shundorjo.com';
            // $array['content'] = 'Hi, Your order has been placed';
            // $array['file'] = public_path() . '/invoices/Order#' . $order->code . '.pdf';
            // $array['file_name'] = 'Order#' . $order->code . '.pdf';
            // $array['subjectsingle'] = 'Order Placed - ' . $order->code;
            // Mail::to($request->session()->get('shipping_info')['email'])->queue(new InvoiceEmailManager($array));
            // Mail::to('info@shundorjo.com')->queue(new InvoiceEmailManager($array));
            // unlink($array['file']);


             DB::commit();
            $request->session()->put('order_id', $order->id);

        }
        } catch (\Exception $e) {
            DB::rollBack();
            $response = ErrorTryCatch::createResponse(false, 500, 'Internal Server Error.', null);
            flash($response['message'])->error();
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function gustStore(Request $request)
    {

        try {
            DB::beginTransaction();
        $order = new Order;
        if (Auth::check()) {
            $order->user_id = Auth::user()->id;
        } else {
            $order->guest_id = mt_rand(100000, 999999);
        }
        $shippingInfo = array(
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'region'=>null,
            'city'=>null,
            'area'=>null,
            'post_code'=>null,
            'checkout_type'=>$request->checkout_type,
        );


        // dd(Session::get('cart'));

        $order->shipping_address = json_encode($shippingInfo);
        $order->shipping_cost = (int)$request->shipping;
        $order->payment_type = $request->payment_option;
        $order->note = $request->note;

        if ($request->payment_option == 'wallet') {
            $order->payment_status = 'paid';
        }
        $order->code = date('Ymd-his');
        $order->date = strtotime(date('d-m-Y'));
        $order->upcoming = 0;

        if ($order->save()) {
            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            foreach (Session::get('cart') as $key => $cartItem) {
                $product = Product::find($cartItem['id']);
                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                $shipping += $cartItem['shipping'];
                // $shippingcost = $cartItem['shipping'];
                $product_variation = null;
                if (isset($cartItem['color'])) {
                    $product_variation .= Color::where('code', $cartItem['color'])->first()->name;
                }
                foreach (json_decode($product->choice_options) as $choice) {
                    $str = $choice->name; // example $str =  choice_0
                    if ($product_variation != null) {
                        $product_variation .= '-' . str_replace(' ', '', $cartItem[$str]);
                    } else {
                        $product_variation .= str_replace(' ', '', $cartItem[$str]);
                    }
                }

                if ($product_variation != null) {
                    $variations = json_decode($product->variations);
                    $variations->$product_variation->qty -= $cartItem['quantity'];
                    $product->variations = json_encode($variations);
                    $product->save();
                }

                $order_detail = new OrderDetail;
                $order_detail->order_id  = $order->id;
                $order_detail->seller_id = $product->user_id;
                $order_detail->product_id = $product->id;
                $order_detail->variation = $product_variation;
                $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                $order_detail->quantity = $cartItem['quantity'];
                $order_detail->save();
                $product->num_of_sale++;
                $product->save();
            }

            $drate = Master::where('softcode', '=', 'discount')->first()->hardcode / 100;
            $damount = $subtotal * $drate;

            $order->discount = $damount;
            $order->grand_total = $subtotal + $tax + $order->shipping_cost - $damount;
            if ($order->save()) {
                $order_id = $order->id;
                // DB::update('update prescription_images set order_id = ? , status = ? where user_id = ? and status = ?',[$order_id,1,Auth::user()->id,0]);
            }

            //stores the pdf for invoice
            // dd($order);

            // $pdf = PDF::loadView('invoices.customer_invoice', compact('order'));
            // $output = $pdf->output();
            // file_put_contents(public_path() . '/invoices/' . 'Order#' . $order->code . '.pdf', $output);
            // $array['view'] = 'emails.invoice';
            // $array['subject'] = 'Order Placed - ' . $order->code;
            // $array['from'] = 'info@shundorjo.com';
            // $array['content'] = 'Hi, Your order has been placed';
            // $array['file'] = public_path() . '/invoices/Order#' . $order->code . '.pdf';
            // $array['file_name'] = 'Order#' . $order->code . '.pdf';
            // $array['subjectsingle'] = 'Order Placed - ' . $order->code;
            // if(!empty($request->email)){
            //     Mail::to($request->email)->queue(new InvoiceEmailManager($array));
            // }

            // Mail::to('info@shundorjo.com')->queue(new InvoiceEmailManager($array));
            // unlink($array['file']);


             DB::commit();
            $request->session()->put('order_id', $order->id);

        }
        } catch (\Exception $e) {
            DB::rollBack();
            $response = ErrorTryCatch::createResponse(false, 500, 'Internal Server Error.', null);
            flash($response['message'])->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd(decrypt($id));
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();
        return view('orders.show', compact('order'));
    }

    public function prescriptionshow($id)
    {
        // $order = Order::findOrFail(decrypt($id));
        $pimg = PrescriptionImage::where('order_id', '=', decrypt($id))->get();

        // dd($pimg);
        return view('orders.prescription', compact('pimg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $order = Order::findOrFail(decrypt($id));
        return view('orders.edit_custom_order', compact('order'));
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
         try {
        DB::beginTransaction();

        // === Find Existing Order ===
        $order = Order::findOrFail($id);

        // === Find user by phone number ===
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            $order->user_id = $user->id;
        } else {
            // নতুন user তৈরি করে auto link করা
            $newUser = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'ref_by' => 'custom_manual',
                'user_type' => 'customer',
                'password' => bcrypt(12345678),
            ]);
            $order->user_id = $newUser->id;
        }

        // === Update Shipping Info ===
        $shippingInfo = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => null,
            'region' => null,
            'city' => null,
            'area' => null,
            'post_code' => null,
            'checkout_type' => 'custom_manual',
        ];

        $order->shipping_address = json_encode($shippingInfo);
        $order->payment_type = $request->payment_option ?? 'Cash On Delivery';
        $order->code = $request->order_id ?? $order->code;
        $order->date = strtotime($request->date);
        $order->shipping_cost = $request->delivery_charge ?? 0;
        $order->discount = $request->discount ?? 0;
        $order->paid_amount = $request->paid ?? 0;
        $order->order_source = $request->order_source;
        $order->note = $request->note ?? null;

        // === Clear old order details ===
        OrderDetail::where('order_id', $order->id)->delete();

        // === Recalculate ===
        $subtotal = 0;

        if ($request->has('product_name')) {
            foreach ($request->product_name as $index => $name) {
                $qty = (float) ($request->quantity[$index] ?? 0);
                $price = (float) ($request->price[$index] ?? 0);
                $subtotal += $qty * $price;

                $orderDetail = new OrderDetail();
                $orderDetail->seller_id = 394;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = 0;
                $orderDetail->variation = null;
                $orderDetail->price = $price * $qty;
                $orderDetail->tax = 0;
                $orderDetail->quantity = $qty;
                $orderDetail->custom_product_name = $name;
                $orderDetail->save();
            }
        }

        $delivery = (float) $request->delivery_charge;
        $discount = (float) $request->discount;
        $paid = (float) $request->paid;

        $grand_total = $subtotal + $delivery - $discount;

        $order->grand_total = $grand_total;
        $order->payment_status = $paid >= $grand_total ? 'paid' : 'unpaid';
        $order->save();

        DB::commit();

        return redirect()->route('orders.pending')
            ->with('success', 'Custom Order updated successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if ($order != null) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->delete();
            }
            $order->delete();
            flash('Order has been deleted successfully')->success();
        } else {
            flash('Something went wrong')->error();
        }
        return back();
    }

    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        return view('frontend.partials.order_details_seller', compact('order'));
    }

    public function update_delivery_status(Request $request)
{
    $order = Order::find($request->order_id);

    $order->delivery_status = $request->status;
    $order->save();

    // JSON থেকে phone বের করা
    $shipping = json_decode($order->shipping_address, true);
    $phone = $shipping['phone'] ?? null;

    if (!$phone) {
        return 1;
    }

    //  Message তৈরি
    $message = '';

    if ($request->status == 'processing') {
        $message = "Shundorjo.com: প্রিয় গ্রাহক, আপনার অর্ডারটি নিশ্চিত করা হয়েছে এবং প্রসেসিং চলছে, ধন্যবাদ। বিস্তারিত জানতে WhatsApp করুন 01882542525";
    }

    if ($request->status == 'rejected') {
        $reason = $request->reject_reason ?? 'উল্লেখ নেই';
        $message = "Shundorjo.com: দুঃখিত! আপনার অর্ডারটি বাতিল করা হয়েছে। কারণ: " . $reason. " বিস্তারিত জানতে WhatsApp করুন 01882542525";
    }

    // =========================
    //  SMS SEND
    // =========================
    if (!empty($message)) {

        $sms_url = "http://103.177.125.106:7788/sendtext";

        $params = [
            'apikey' => 'c72ef99411c48671',
            'secretkey' => '9671baea',
            'callerID' => 'tanzimnur',
            'toUser' => $phone,
            'messageContent' => $message,
        ];

        file_get_contents($sms_url . '?' . http_build_query($params));
    }


    return 1;
}

    public function update_payment_status(Request $request)
    {

        $order = Order::findOrFail($request->order_id);
        $order->payment_status = $request->status;
        $order->save();
        // $status = 'paid';
        // if($order->payment_status == 'unpaid'){
        //     $status = 'unpaid';
        // }
        // $order->payment_status = $request->status;
        // $order->save();

        return 1;
    }

    //custom order
    public function admin_custom_orders(Request $request)
    {
        $order_id = date('Ymd');

        return view('orders.customorder', compact( 'order_id'));
    }

    public function custom_order_confirm(Request $request)
{
    // dd($request->all());
    try {
        DB::beginTransaction();

        // === Create Order ===
        $order = new Order;
        // === Find user by phone number ===
$user = User::where('phone', $request->phone)->first();
if ($user) {
    $order->user_id = $user->id;
} else {
    // নতুন user তৈরি করে auto link করা
    $newUser = User::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'address' => $request->address,
        'ref_by' => 'custom_manual',
        'user_type' => 'customer',
        'password' => bcrypt(12345678), // random password
    ]);
    $order->user_id = $newUser->id;
}

        $shippingInfo = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => null,
            'region' => null,
            'city' => null,
            'area' => null,
            'post_code' => null,
            'checkout_type' => 'custom_manual',
        ];

        $order->shipping_address = json_encode($shippingInfo);
        $order->payment_type = $request->payment_option ?? 'Cash On Delivery';
        $order->code = $request->order_id;
        $order->date = strtotime($request->date);
        $order->shipping_cost = $request->delivery_charge ?? 0;
        $order->discount = $request->discount ?? 0;
        $order->paid_amount = $request->paid ?? 0;
        $order->order_source = $request->order_source;
        $order->note = $request->note ?? null;

        $subtotal = 0;

        // === Save Order first ===
        $order->save();

        // === Loop through Product Rows ===
        if ($request->has('product_name')) {
            foreach ($request->product_name as $index => $name) {
                $qty = (float) ($request->quantity[$index] ?? 0);
                $price = (float) ($request->price[$index] ?? 0);
                $subtotal += $qty * $price;

                $orderDetail = new OrderDetail();
                $orderDetail->seller_id = 394;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = 0; // manual order, no fixed product id
                $orderDetail->variation = null;
                $orderDetail->price = $price * $qty;
                $orderDetail->tax = 0;
                $orderDetail->quantity = $qty;
                $orderDetail->custom_product_name = $name;
                $orderDetail->save();
            }
        }

        // === Total Calculation ===
        $delivery = (float) $request->delivery_charge;
        $discount = (float) $request->discount;
        $paid = (float) $request->paid;

        $grand_total = $subtotal + $delivery - $discount;

        // === Update order final amounts ===
        $order->grand_total = $grand_total;
        $order->payment_status = $paid >= $grand_total ? 'paid' : 'unpaid';
        $order->save();

        DB::commit();

        return redirect()->route('orders.pending')
            ->with('success', ' Custom Order created successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}



    public function shippingMethod()
    {
        $methods = ShippingMethod::all();
        return view("shipmethod.index", compact('methods'));
    }

    public function shippingMethodCreate()
    {
        return view('shipmethod.create');
    }

    public function shippingMethodStore(Request $request)
    {
        $link = new ShippingMethod;
        $link->title = $request->title;
        $link->price = $request->price;
        $link->status = "1";
        if ($link->save()) {
            flash('Shipping method has been inserted successfully')->success();
            return redirect()->route('shippingmethod.index');
        }
        flash('Something went wrong')->error();
        return back();
    }

    public function shippingMethodEdit($id)
    {
        $methods = ShippingMethod::findOrFail(decrypt($id));
        return view('shipmethod.edit', compact('methods'));
    }

    public function shippingMethodUpdate(Request $request, $id)
    {
        $link = ShippingMethod::findOrFail($id);
        $link->title = $request->title;
        $link->price = $request->price;
        if ($link->save()) {
            flash('Shipping method has been updated successfully')->success();
            return redirect()->route('shippingmethod.index');
        }
        flash('Something went wrong')->error();
        return back();
    }

    public function shippingMethodDelete($id)
    {
        $link = ShippingMethod::findOrFail($id);
        if (ShippingMethod::destroy($id)) {
            flash('Shipping method has been deleted successfully')->success();
            return redirect()->route('shippingmethod.index');
        }

        flash('Something went wrong')->error();
        return back();
    }

    public function updateFeatured(Request $request)
    {
        $category = ShippingMethod::findOrFail($request->id);
        $category->status = $request->status;
        if ($category->save()) {
            return 1;
        }
        return 0;
    }

    public function orderTracking()
    {
        return view('orders.tracking');
    }

    public function orderTrackingShow(Request $request)
    {
        // dd($request->code);
        $code   = $request->code;
        $order = Order::where('code', '=', $code)->first();
        if ($order) {
            return view('orders.trackingshow', compact('order'));
        } else {
            flash('Order not found')->success();
            return redirect()->route('order-tracking.index');
        }
    }

    public function orderComplainStore(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_status = 'return';
        $order->complain = $request->complain;
        if ($order->save()) {
            flash('Complain has been saved successfully')->success();
            return redirect()->route('order-tracking.index');
        }
        flash('Something went wrong')->error();
        return view('orders.tracking');
    }
}
