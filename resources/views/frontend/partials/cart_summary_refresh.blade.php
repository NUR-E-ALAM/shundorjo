<div class="card sticky-top">
    <div class="card-title">
        <div class="row align-items-center">
            <div class="col-6">
                <h3 class="heading heading-3 strong-400 mb-0">
                    <span>{{__('Summary')}}</span>
                </h3>
            </div>

            <div class="col-6 text-right">
                <span class="badge badge-md badge-success">{{ count(Session::get('cart')) }} {{__('Items')}}</span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table-cart table-cart-review">
            <thead>
                <tr>
                    <th class="product-name">{{__('Product')}}</th>
                    <th class="product-total text-right">{{__('Total')}}</th>
                </tr>
            </thead>
            <tbody>
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
                    <tr class="cart_item">
                        <td class="product-name">
                            {{ $product_name_with_choice }}
                            <strong class="">× {{ $cartItem['quantity'] }}</strong>
                        </td>
                        <td class="product-total text-right">
                            <span class="pl-4">{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
<hr>
        {{-- <table class="table-cart table-cart-review my-4">
            <thead>
                <tr>
                    <th class="product-name">{{__('Product Shipping charge')}}</th>
                    <th class="product-total text-right">{{__('Amount')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach (Session::get('cart') as $key => $cartItem)
                    <tr class="cart_item">
                        <td class="product-name">
                            {{ \App\Models\Product::find($cartItem['id'])->name }}
                            <strong class="product-quantity">× {{ $cartItem['quantity'] }}</strong>
                        </td>
                        <td class="product-total text-right">
                            <span class="pl-4">{{ single_price($cartItem['shipping']*$cartItem['quantity']) }} ({{ ucfirst(str_replace('_', ' ', $cartItem['shipping_type'])) }})</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}

        <table class="table-cart table-cart-review">

            <tfoot>
                <tr class="cart-subtotal">
                    <th>{{__('Subtotal')}}</th>
                    <td class="text-right">
                        <span class="strong-600">{{ single_price($subtotal) }}</span>
                    </td>
                </tr>

                <!--<tr class="cart-shipping">-->
                <!--    <th>{{__('Tax')}}</th>-->
                <!--    <td class="text-right">-->
                <!--        <span class="text-italic">{{ single_price($tax) }}</span>-->
                <!--    </td>-->
                <!--</tr>-->

                 @if(Auth::check())
                    @php
                    if(Auth::user()->shipping_address){
                        $shippingcost = \App\Models\ShippingAddess::where('id', Auth::user()->shipping_address)->first()->shipping_cost;
                    }else{
                        $shippingcost = 0;
                    }
                    @endphp
                     <tr class="cart-shipping">
                        <th>{{__('Delivery Charge')}}</th>
                        <td class="text-right">
                            <span class="text-italic">{{ single_price($shippingcost) }}</span>
                            {{-- <span class="text-italic">{{ single_price($shippingcost) }}</span> --}}
                        </td>
                    </tr>
                @else
                @php
                    $shippingcost = 0;
                @endphp
                 <tr class="cart-shipping">
                    <th>{{__('Delivery Charge')}}</th>
                    <td class="text-right">
                        <span class="text-italic">{{ single_price($shippingcost) }}</span>
                        {{-- <span class="text-italic">{{ single_price($shippingcost) }}</span> --}}
                    </td>
                </tr>
                @endif


                <tr class="cart-total">
                    <th><span>{{__('Discount')}}</span></th>
                    <td class="text-right">
                        <strong><span>{{ single_price($damount) }}</span></strong>
                    </td>
                </tr>
                
                <tr class="cart-total">
                    <th><span class="strong-600">{{__('Total')}}</span></th>
                    <td class="text-right">
                        <strong><span>{{ single_price($subtotal+$tax+$shippingcost-$damount) }}</span></strong>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
