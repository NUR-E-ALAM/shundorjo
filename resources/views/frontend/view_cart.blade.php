@extends('frontend.layouts.app')
@section('title')
    Cart
@stop
@section('content')

    <section class="slice-xs sct-color-2 border-bottom">
        <div class="container container-sm">
            <div class="row cols-delimited">
                <div class="col-4">
                    <div class="icon-block icon-block--style-1-v5 text-center active">
                        <div class="block-icon mb-0">
                            <i class="icon-hotel-restaurant-105"></i>
                        </div>
                        <div class="block-content d-none d-md-block">
                            <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize" style="color: black !important; font-weight: 700 !important;">1. {{__('My Cart')}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon mb-0">
                            <i class="icon-finance-067"></i>
                        </div>
                        <div class="block-content d-none d-md-block">
                            <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">2. {{__('Shipping info')}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon c-gray-light mb-0">
                            <i class="icon-finance-059"></i>
                        </div>
                        <div class="block-content d-none d-md-block">
                            <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">3. {{__('Payment')}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<div id="cart-summary">
    @if(Session::has('cart'))
    <section class="cart">
        <div class="inner">
            <div class="left">
                <div class="overflow">
                    <table class="table table-custom shadow-sm">
                        <thead>
                            <tr>
                                <th> </th>
                                <th width="200px">Product Name</th>
                                <th>Price</th>
                                <th>quantity</th>
                                <th>Total</th>
                                <th class="text-center">Cancel</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total = 0;
                            
                            @endphp
                            @foreach (Session::get('cart') as $key => $cartItem)
                            @php
                            $product = \App\Models\Product::find($cartItem['id']);
                            $total = $total + $cartItem['price']*$cartItem['quantity'];
                            $product_name_with_choice = $product->name;
                            if(isset($cartItem['color'])){
                                $product_name_with_choice .= ' - '.\App\Models\Color::where('code', $cartItem['color'])->first()->name;
                            }
                            foreach (json_decode($product->choice_options) as $choice){
                                $str = $choice->name; // example $str =  choice_0
                                $product_name_with_choice .= ' - '.$cartItem[$str];
                            }
                            @endphp
                            <tr>
                                <td><img src="{{ asset($product->thumbnail_img) }}" height="30px"></td>
                                <td width="200px">{{ $product_name_with_choice }}</td>
                                <td class="product-price"><span style="border:0; outline:0;">{{ single_price($cartItem['price']) }}</span></td>
                                <td>
                                    <div class="product-quantity">
                                        <button class="btn btn-number" type="button" data-type="minus" data-field="quantity[{{ $key }}]">-</button>
                                        <input type="number" name="quantity[{{ $key }}]" placeholder="1" value="{{ $cartItem['quantity'] }}" min="1" max="100" onchange="updateQuantity({{ $key }}, this)">
                                        <button class="btn btn-number" type="button" data-type="plus" data-field="quantity[{{ $key }}]">+</button>
                                    </div>
                                </td>
                                <td class="product-total">
                                    <span>{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                                </td>
                                <td class="text-center"><span title="Remove this product" onclick="removeFromCartView(event, {{ $key }})" class="iconify curp" data-icon="emojione:cross-mark-button"></span></td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="well align-items-center mt-3 d-flex flex-wrap justify-content-between">
                   <div><a href="{{ route('home') }}">Back to Home </a></div>
                    @if(!Session::get('cart')->isEmpty())
                   <div>
                    @if(Auth::check())
                    <a href="{{ route('checkout.shipping_info') }}" class="btn-theme text-white">Continue to Shipping</a></div>
                @else
                    <a href="{{ route('cart.login') }}" class="btn-theme text-white">Continue to Shipping</a></div>
                @endif
                @else
                <div class="dc-header" style="widows: 80%; margin: 0 auto;">
        <h3 class="heading heading-6 strong-700">{{__('Your Cart is empty')}}</h3>
    </div>
                @endif

                </div>
            </div>
            <div class="right">
                <div class="cartDetails mb-3">
                    <div class="title py-2">
                        <div class="font-weight-bold pl-1"><span class="iconify" data-icon="bx:bxs-cart-download"></span> Cart Details </div>
                        <div class="badge badge-primary">Total: {{ count(Session::get('cart')) }} {{__('Items')}} </div>
                    </div>
                    <div class="heading">
                        <span>Product Name</span>
                        <span>Price</span>
                    </div>
                    <div class="product-list">
                        @php
                    $subtotal = 0;
                    $tax = 0;
                    $shipping = 0;
                @endphp
                @foreach (Session::get('cart') as $key => $cartItem)
                    @php
                    $product = \App\Models\Product::find($cartItem['id']);
                    $subtotal += $cartItem['price']*$cartItem['quantity'];
                    $drate = \App\Models\Master::where('softcode','=','discount')->first()->hardcode/100;
                    $damount = $subtotal*$drate;
                    $tax += $cartItem['tax']*$cartItem['quantity'];
                    $shipping += $cartItem['shipping']*$cartItem['quantity'];
                    // $shippingcost = $cartItem['shipping'];
                    $product_name_with_choice = $product->name;
                    if(isset($cartItem['color'])){
                        $product_name_with_choice .= ' - '.\App\Models\Color::where('code', $cartItem['color'])->first()->name;
                    }
                    foreach (json_decode($product->choice_options) as $choice){
                        $str = $choice->name; // example $str =  choice_0
                        $product_name_with_choice .= ' - '.$cartItem[$str];
                    }
                    @endphp

                        <div class="product font-weight-bold">
                            <div class="name">{{ $product_name_with_choice }}
                                <strong>× {{ $cartItem['quantity'] }}</strong></div>
                            <div class="price"><span class="pl-4">{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span></div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="price">
                        <div> SUBTOTAL</div>
                        <div> {{ single_price($subtotal) }}</div>
                    </div>
                    <!--<div class="price">-->
                    <!--    <div>tax</div>-->
                    <!--    <div> {{ single_price($tax) }}</div>-->
                    <!--</div>-->
                    <div class="price">
                        @if(Auth::check())
                            @php
                            if(Auth::user()->shipping_address){
                                $shippingcost = \App\Models\ShippingAddess::where('id', Auth::user()->shipping_address)->first()->shipping_cost;
                            }else{
                                $shippingcost = 120;
                            }
                            @endphp
                            <div>Delivery Charge</div>
                            <div> {{ single_price($shippingcost) }}</div>
                        @else
                        @php
                            $shippingcost = Session::get('shipCost');
                        @endphp
                            <div>Delivery Charge</div>
                            <div> {{ single_price($shippingcost) }}</div>
                        @endif
                    </div>
                   <div class="price">
                        <div> Discount</div>
                        <div> {{ single_price(@$damount) }}</div>
                    </div>
                    <div class="price">
                        <div class=" font-weight-bold"> TOTAL</div>
                        <div class=" font-weight-bold"> {{ single_price($subtotal+$tax+$shippingcost-@$damount) }}</div>
                    </div>
                </div>
            </div>
    </section>
    @else
    <div class="dc-header" style="widows: 80%; margin: 0 auto;">
        <h3 class="heading heading-6 strong-700">{{__('Your Cart is empty')}}</h3>
    </div>
    @endif
</div>

@endsection

@section('script')
    <script type="text/javascript">
    function removeFromCartView(e, key){
        e.preventDefault();
        removeFromCart(key);
        location.reload();
    }

    function updateQuantity(key, element){
        $.post('{{ route('cart.updateQuantity') }}', { _token:'{{ csrf_token() }}', key:key, quantity: element.value}, function(data){
            updateNavCart();
            $('#cart-summary').html(data);
        });
    }

    function showCheckoutModal(){
        $('#GuestCheckout').modal();
    }
    </script>

    <script>
        function shipping_cost() {
          $shippingcost = document.getElementById("shipping").value;
        //   document.getElementById("shippingcost").innerHTML = $shippingcost;
          document.getElementById("shippingcost").innerHTML = "৳"+$shippingcost+".00";
        }
        </script>
@endsection
