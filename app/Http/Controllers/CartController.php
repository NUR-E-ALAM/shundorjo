<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SubSubCategory;
use App\Models\Category;
use Session;
use App\Models\Color;

class CartController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $categories = Category::all();
        return view('frontend.view_cart', compact('categories'));
    }

    public function showCartModal(Request $request)
    {
        $product = Product::find($request->id);
        return view('frontend.partials.addToCart', compact('product'));
    }
    public function showCartModalshop(Request $request)
    {
        $product = Product::find($request->id);
        return view('frontend.partials.addToCartShop', compact('product'));
    }

    public function updateNavCart(Request $request)
    {
        return view('frontend.partials.cart');
    }
    public function updateNavCartNumber(Request $request)
    {

        return view('frontend.partials.cart1');
    }
    public function updateTaka(Request $request)
    {

        return view('frontend.partials.carttaka');
    }


    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        // dd($product);
        // exit();

        $data = array();
        $data['id'] = $product->id;
        $str = '';
        $tax = 0;

        //check the color enabled or disabled for the product
        if ($request->has('color')) {
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
        foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
            $data[$choice->name] = $request[$choice->name];
            if ($str != null) {
                $str .= '-' . str_replace(' ', '', $request[$choice->name]);
            } else {
                $str .= str_replace(' ', '', $request[$choice->name]);
            }
        }

        //Check the string and decreases quantity for the stock
        if ($str != null) {
            $variations = json_decode($product->variations);
            $price = $variations->$str->price;
            if ($variations->$str->qty >= $request['quantity']) {
                // $variations->$str->qty -= $request['quantity'];
                // $product->variations = json_encode($variations);
                // $product->save();
            } else {
                return view('frontend.partials.outOfStockCart');
            }
        } else {
            $price = $product->unit_price;
        }

        //discount calculation based on flash deal and regular discount
        //calculation of taxes
        $flash_deal = \App\Models\FlashDeal::where('status', 1)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\Models\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
            $flash_deal_product = \App\Models\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
            if ($flash_deal_product->discount_type == 'percent') {
                $price -= ($price * $flash_deal_product->discount) / 100;
            } elseif ($flash_deal_product->discount_type == 'amount') {
                $price -= $flash_deal_product->discount;
            }
        } else {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }

        $data['prescribed'] = $request['prescribed'];
        $data['quantity'] = $request['quantity'];
        $data['price'] = $price;
        $data['tax'] = $tax;
        $data['shipping_type'] = $product->shipping_type;

        if ($product->shipping_type == 'free') {
            $data['shipping'] = 0;
        } else {
            $data['shipping'] = $product->shipping_cost;
        }

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart', collect([]));
            $cart->push($data);
        } else {
            $cart = collect([$data]);
            $request->session()->put('cart', $cart);
        }
        $request->session()->put('shipCost', 0);
        return view('frontend.partials.addedToCart', compact('product', 'data'));
    }


    public function buyNow(Request $request)
    {
        // return response($request->all());
        $product = Product::find($request->id);

        // dd($product);
        // exit();

        $data = array();
        $data['id'] = $product->id;
        $str = '';
        $tax = 0;

        //check the color enabled or disabled for the product
        if ($request->has('color')) {
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
        foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
            $data[$choice->name] = $request[$choice->name];
            if ($str != null) {
                $str .= '-' . str_replace(' ', '', $request[$choice->name]);
            } else {
                $str .= str_replace(' ', '', $request[$choice->name]);
            }
        }

        //Check the string and decreases quantity for the stock
        if ($str != null) {
            $variations = json_decode($product->variations);
            $price = $variations->$str->price;
            if ($variations->$str->qty >= $request['quantity']) {
                // $variations->$str->qty -= $request['quantity'];
                // $product->variations = json_encode($variations);
                // $product->save();
            } else {
                return view('frontend.partials.outOfStockCart');
            }
        } else {
            $price = $product->unit_price;
        }

        //discount calculation based on flash deal and regular discount
        //calculation of taxes
        $flash_deal = \App\Models\FlashDeal::where('status', 1)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\Models\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
            $flash_deal_product = \App\Models\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
            if ($flash_deal_product->discount_type == 'percent') {
                $price -= ($price * $flash_deal_product->discount) / 100;
            } elseif ($flash_deal_product->discount_type == 'amount') {
                $price -= $flash_deal_product->discount;
            }
        } else {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }

        $data['prescribed'] = $request['prescribed'];
        $data['quantity'] = 1;
        $data['price'] = $price;
        $data['tax'] = $tax;
        $data['shipping_type'] = $product->shipping_type;

        if ($product->shipping_type == 'free') {
            $data['shipping'] = 0;
        } else {
            $data['shipping'] = $product->shipping_cost;
        }

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart', collect([]));
            if ($cart->contains('id', $product->id)) {
                // Product exists
            } else {
               $cart->push($data);
            }

        } else {
            $cart = collect([$data]);
            $request->session()->put('cart', $cart);
        }
        // dd($cart);
        $request->session()->put('shipCost', 0);

        return view('frontend.buy_now_cart', compact('cart'));
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart', collect([]));
            $cart->forget($request->key);
            $request->session()->put('cart', $cart);
        }

        return view('frontend.partials.cart_details');;
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $cart = $request->session()->get('cart', collect([]));
        $cart = $cart->map(function ($object, $key) use ($request) {
            if ($key == $request->key) {
                $object['quantity'] = $request->quantity;
            }
            return $object;
        });
        $request->session()->put('cart', $cart);

        return view('frontend.partials.cart_details');
    }

    //updated the quantity for a cart item
    public function buyNowUpdateQuantity(Request $request)
    {
        $cart = $request->session()->get('cart', collect([]));
        $cart = $cart->map(function ($object, $key) use ($request) {
            if ($key == $request->key) {
                $object['quantity'] = $request->quantity;
            }
            return $object;
        });
        $request->session()->put('cart', $cart);

        return view('frontend.buy_now_cart');
    }
}
