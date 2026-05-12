<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use Auth;
use Illuminate\Routing\UrlGenerator;
use App\Models\Order;
use App\Models\BusinessSetting;
use App\Models\Seller;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\WalletController;
use App\Models\Wallet;
use App\Models\User;
session_start();

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {  if(Session::has('payment_type')){
        if(Session::get('payment_type') == 'cart_payment'){
        $order = Order::findOrFail($request->session()->get('order_id'));
        $post_data = array();
        $post_data['total_amount'] = $order->grand_total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $request->session()->get('order_id');

        # CUSTOMER INFORMATION
        $post_data['cus_email'] = $request->session()->get('shipping_info')['email'];
        $post_data['cus_name'] = $request->session()->get('shipping_info')['name'];
        $post_data['cus_add1'] = $request->session()->get('shipping_info')['address'];
        $post_data['cus_add2'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_fax'] = "";
        $post_data['cus_city'] = $request->session()->get('shipping_info')['city'];
        $post_data['cus_postcode'] = $request->session()->get('shipping_info')['post_code'];
        $post_data['cus_country'] = 'Bangladesh';
        $post_data['cus_phone'] = $request->session()->get('shipping_info')['phone'];

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Medicine";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $request->session()->get('payment_type');
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('id', $post_data['tran_id'])
            ->update([
                'payment_status' => 'unpaid',
            ]);
        }elseif (Session::get('payment_type') == 'wallet_payment') {

            // dd(Session::get('payment_type'));  exit();
            $post_data = array();
            $post_data['total_amount'] = $request->session()->get('payment_data')['amount']; # You cant not pay less than 10
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = Auth::user()->id; // tran_id must be unique

            # CUSTOMER INFORMATION
            $user = Auth::user();
            if($user->name){$name = $user->name;}else{flash(__('Update Name First!'))->error(); return redirect()->route('profile');};
            if($user->email){$email = $user->email;}else{flash(__('Update Email First!'))->error(); return redirect()->route('profile');};
            if($user->address){$address = $user->address;}else{flash(__('Update Address First!'))->error(); return redirect()->route('profile');};
            if($user->city){$city = $user->city;}else{flash(__('Update City First!'))->error(); return redirect()->route('profile');};
            if($user->postal_code){$postal_code = $user->postal_code;}else{flash(__('Update Post Code First!'))->success(); return redirect()->route('profile');};
            if($user->phone){$phone = $user->phone;}else{flash(__('Update Phone First!'))->error(); return redirect()->route('profile');};
            $post_data['cus_name'] = $name;
            $post_data['cus_email']= $email;
            $post_data['cus_add1'] = $address;
            $post_data['cus_add2'] = "";
            $post_data['cus_state'] = "";
            $post_data['cus_fax'] = "";
            $post_data['cus_city'] = $city;
            $post_data['cus_postcode'] = $postal_code;
            $post_data['cus_country'] = 'BD';
            $post_data['cus_phone'] = $phone;

             # SHIPMENT INFORMATION
            $post_data['ship_name'] = "Apon Health";
            $post_data['ship_add1'] = "House-24, Road-31, Section-12";
            $post_data['ship_add2'] = "Dhaka";
            $post_data['ship_city'] = "Dhaka";
            $post_data['ship_state'] = "Dhaka";
            $post_data['ship_postcode'] = "1216";
            $post_data['ship_phone'] = "";
            $post_data['ship_country'] = "Bangladesh";

            $post_data['shipping_method'] = "NO";
            $post_data['product_name'] = "Top Up";
            $post_data['product_category'] = "Top Up";
            $post_data['product_profile'] = "online";

            # OPTIONAL PARAMETERS
            $post_data['value_a'] = $request->session()->get('payment_type');
            $post_data['value_b'] = "ref002";
            $post_data['value_c'] = "ref003";
            $post_data['value_d'] = "ref004";

        }elseif (Session::get('payment_type') == 'medorder') {

            // dd(Session::get('payment_type'));  exit();
            $post_data = array();
            $post_data['total_amount'] = $request->session()->get('payment_data')['amount']; # You cant not pay less than 10
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = $request->session()->get('payment_data')['tran_id']; // tran_id must be unique
            # CUSTOMER INFORMATION
            $user = Auth::user();
            if($user->name){$name = $user->name;}else{flash(__('Update Name First!'))->error(); return redirect()->route('profile');};
            if($user->email){$email = $user->email;}else{flash(__('Update Email First!'))->error(); return redirect()->route('profile');};
            if($user->address){$address = $user->address;}else{flash(__('Update Address First!'))->error(); return redirect()->route('profile');};
            if($user->city){$city = $user->city;}else{flash(__('Update City First!'))->error(); return redirect()->route('profile');};
            if($user->postal_code){$postal_code = $user->postal_code;}else{flash(__('Update Post Code First!'))->success(); return redirect()->route('profile');};
            if($user->phone){$phone = $user->phone;}else{flash(__('Update Phone First!'))->error(); return redirect()->route('profile');};
            $post_data['cus_name'] = $name;
            $post_data['cus_email']= $email;
            $post_data['cus_add1'] = $address;
            $post_data['cus_add2'] = "";
            $post_data['cus_state'] = "";
            $post_data['cus_fax'] = "";
            $post_data['cus_city'] = $city;
            $post_data['cus_postcode'] = $postal_code;
            $post_data['cus_country'] = 'BD';
            $post_data['cus_phone'] = $phone;

             # SHIPMENT INFORMATION
            $post_data['ship_name'] = "Store Test";
            $post_data['ship_add1'] = "Dhaka";
            $post_data['ship_add2'] = "Dhaka";
            $post_data['ship_city'] = "Dhaka";
            $post_data['ship_state'] = "Dhaka";
            $post_data['ship_postcode'] = "1000";
            $post_data['ship_phone'] = "";
            $post_data['ship_country'] = "Bangladesh";

            $post_data['shipping_method'] = "NO";
            $post_data['product_name'] = "Top Up";
            $post_data['product_category'] = "Top Up";
            $post_data['product_profile'] = "online";

            # OPTIONAL PARAMETERS
            $post_data['value_a'] = $request->session()->get('payment_type');
            $post_data['value_b'] = "ref002";
            $post_data['value_c'] = "ref003";
            $post_data['value_d'] = "ref004";
// dd($post_data);


        }

    }
        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $order = Order::findOrFail($request->session()->get('order_id'));
        $post_data = array();
        $post_data['total_amount'] = $order->grand_total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $request->session()->get('order_id');

        # CUSTOMER INFORMATION
        $post_data['cus_email'] = $request->session()->get('shipping_info')['email'];
        $post_data['cus_add2'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_fax'] = "";
        $post_data['cus_name'] = $request->session()->get('shipping_info')['name'];
        $post_data['cus_add1'] = $request->session()->get('shipping_info')['address'];
        $post_data['cus_city'] = $request->session()->get('shipping_info')['city'];
        $post_data['cus_postcode'] = $request->session()->get('shipping_info')['postal_code'];
        $post_data['cus_country'] = $request->session()->get('shipping_info')['country'];
        $post_data['cus_phone'] = $request->session()->get('shipping_info')['phone'];

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        // $update_product = DB::table('orders')
        //     ->where('transaction_id', $post_data['tran_id'])
        //     ->updateOrInsert([
        //         'name' => $post_data['cus_name'],
        //         'email' => $post_data['cus_email'],
        //         'phone' => $post_data['cus_phone'],
        //         'amount' => $post_data['total_amount'],
        //         'status' => 'Pending',
        //         'address' => $post_data['cus_add1'],
        //         'transaction_id' => $post_data['tran_id'],
        //         'currency' => $post_data['currency']
        //     ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $payment = json_encode($request->all());
        $sslc = new SslCommerzNotification();

            if($request->input('value_a') == 'cart_payment'){
                #Check order status in order tabel against the transaction id or order id.
                $order_detials = DB::table('orders')
                ->where('id', $tran_id)
                ->select('payment_status')->first();

                if ($order_detials->payment_status == 'unpaid') {
                $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);
                // $validation = $sslc->orderValidate($tran_id, $order->grand_total, 'BDT', $request->all());

                if ($validation == TRUE) {
                    /*
                    That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successfull transaction to customer
                    */
                    $update_product = DB::table('orders')->where('id', $tran_id)
                    ->update([
                        'payment_status' => 'paid',
                        'delivery_status' => 'processing',
                    ]);
                    // echo "<br >Transaction is successfully Completed";
                    // flash(__('Transaction is successfully Completed'))->success();
                    // return redirect()->route('home');
                    $orderid= $tran_id;
                    flash("Your order has been placed successfully")->success();
                    return redirect()->route('order.complete.message', $orderid);
                } else {
                    /*
                    That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('id', $tran_id)
                        ->update(['payment_status' => 'unpaid']);
                    flash(__('validation Fail'))->error();
                    return redirect()->route('home');
                }
                } else if ($order_detials->payment_status == 'paid') {
                /*
                That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
                */
                flash(__('Transaction is successfully Completed vvvv'))->success();
                return redirect()->route('purchase_history.index');
                } else {
                #That means something wrong happened. You can redirect customer to your product page.
                flash(__('Payment not completed'))->error();
                return redirect()->route('purchase_history.index');
                }

            }elseif ($request->input('value_a') == 'wallet_payment') {
                $user = User::find($tran_id);
                // dd($user);
                $user->balance = $user->balance + $amount;
                $user->save();
                $wallet = new Wallet;
                $wallet->user_id = $user->id;
                $wallet->amount = $amount;
                $wallet->payment_method = 'SSLCommerz';
                $wallet->payment_details = 'SSL Top Up';
                $wallet->save();
                flash(__('Payment completed'))->success();
                return redirect()->route('wallet.index');

            }elseif ($request->input('value_a') == 'medorder') {
                $user = Order::find($tran_id);
                // dd($user);
                $user->payment_status = 'paid';
                $user->payment_type = 'sslcommerz';
                $user->delivery_status = 'processing';
                $user->save();
                flash(__('Payment completed'))->success();
                return redirect()->route('purchase_history.index');
            }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('id', $tran_id)
            ->select('payment_status')->first();

        if ($order_detials->payment_status == 'unpaid') {
            $update_product = DB::table('orders')
                ->where('id', $tran_id)
                ->update(['payment_status' => 'unpaid']);
            flash(__('Transaction is Falied'))->success();
            return redirect()->route('purchase_history.index');
        } else if ($order_detials->payment_status == 'paid') {
            flash(__('Transaction is already Successful'))->success();
            return redirect()->route('purchase_history.index');
        } else {
            flash(__('Payment not completed'))->error();
            return redirect()->route('purchase_history.index');
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $order_detials = DB::table('orders')
            ->where('id', $tran_id)
            ->select('payment_status')->first();

        if ($order_detials->payment_status == 'unpaid') {
            // $update_product = DB::table('orders')
            //     ->where('id', $tran_id)
            //     ->update(['payment_status' => 'Canceled']);
            flash(__('Your payment not completed'))->error();
            return redirect()->route('purchase_history.index');

        } else if ($order_detials->payment_status == 'paid') {
            flash(__('Transaction is already Successful'))->success();
            return redirect()->route('purchase_history.index');
        } else {
            flash(__('Payment not completed'))->error();
            return redirect()->route('purchase_history.index');
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('id', $tran_id)
                ->select('payment_status')->first();

            if ($order_details->payment_status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('id', $tran_id)
                        ->update(['payment_status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('id', $tran_id)
                        ->update(['payment_status' => 'Failed']);

                    echo "validation Fail";
                }

            } else if ($order_details->payment_status == 'Processing' || $order_details->payment_status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}
