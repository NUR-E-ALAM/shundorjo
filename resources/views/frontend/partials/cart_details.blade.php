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
               <div>
                @if(Auth::check())
                <a href="{{ route('checkout.shipping_info') }}" class="btn-theme text-white">Continue to Shipping</a></div>
            @else
                <a href="{{ route('cart.login') }}" class="btn-theme text-white">Continue to Shipping</a></div>
            @endif

            </div>
        </div>
        <div class="right">
            <div class="cartDetails mb-3">
                <div class="title py-2">
                    <div class="font-weight-bold pl-1"><span class="iconify" data-icon="bx:bxs-cart-download"></span> Cart Details </div>
                    <div class="badge badge-primary">Total: {{ count(Session::get('cart')) }} {{__('Items')}}</div>
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
                <div class="price">
                    <div>tax</div>
                    <div> {{ single_price($tax) }}</div>
                </div>
                <div class="price">
                    @if(Auth::check())
                        @php
                        if(Auth::user()->shipping_address){
                            $shippingcost = \App\Models\ShippingAddess::where('id', Auth::user()->shipping_address)->first()->shipping_cost;
                        }else{
                            $shippingcost = 50;
                        }
                        @endphp
                        <div>Delivery Charge</div>
                        <div> {{ single_price($shippingcost) }}</div>
                    @else
                    @php
                        $shippingcost = 50;
                    @endphp
                        <div>Delivery Charge</div>
                        <div> {{ single_price($shippingcost) }}</div>
                    @endif
                </div>
                <div class="price">
                    <div class=" font-weight-bold"> TOTAL</div>
                    <div class=" font-weight-bold"> {{ single_price($subtotal+$tax+$shippingcost) }}</div>
                </div>
            </div>
        </div>
</section>
@else
    <div class="dc-header">
        <h3 class="heading heading-6 strong-700">{{__('Your Cart is empty')}}</h3>
    </div>
    @endif
<script type="text/javascript">
    cartQuantityInitialize();
</script>
