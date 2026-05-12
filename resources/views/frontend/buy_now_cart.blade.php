@extends('frontend.layouts.app')
@section('title')
    Cart
@stop
@section('content')

    <section class="slice-xs sct-color-2 border-bottom">
        <div class="container container-sm">
            <div class="row cols-delimited">



            </div>
        </div>
    </section>
    <div id="cart-summary">
        @if (Session::has('cart'))
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
                                            $total = $total + $cartItem['price'] * $cartItem['quantity'];
                                            $product_name_with_choice = $product->name;
                                            if (isset($cartItem['color'])) {
                                                $product_name_with_choice .=
                                                    ' - ' .
                                                    \App\Models\Color::where('code', $cartItem['color'])->first()->name;
                                            }
                                            foreach (json_decode($product->choice_options) as $choice) {
                                                $str = $choice->name; // example $str =  choice_0
                                                $product_name_with_choice .= ' - ' . $cartItem[$str];
                                            }
                                        @endphp
                                        <tr>
                                            <td><img src="{{ asset($product->thumbnail_img) }}" height="30px"></td>
                                            <td width="200px">{{ $product_name_with_choice }}</td>
                                            <td class="product-price"><span
                                                    style="border:0; outline:0;">{{ single_price($cartItem['price']) }}</span>
                                            </td>
                                            <td>
                                                <div class="product-quantity">
                                                    <button class="btn btn-number" type="button" data-type="minus"
                                                        data-field="quantity[{{ $key }}]">-</button>
                                                    <input type="number" name="quantity[{{ $key }}]"
                                                        placeholder="1" value="{{ $cartItem['quantity'] }}" min="1"
                                                        max="100" onchange="updateQuantity({{ $key }}, this)">
                                                    <button class="btn btn-number" type="button" data-type="plus"
                                                        data-field="quantity[{{ $key }}]">+</button>
                                                </div>
                                            </td>
                                            <td class="product-total">
                                                <span>{{ single_price($cartItem['price'] * $cartItem['quantity']) }}</span>
                                            </td>
                                            <td class="text-center"><span title="Remove this product"
                                                    onclick="removeFromCartView(event, {{ $key }})"
                                                    class="iconify curp" data-icon="emojione:cross-mark-button"></span></td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="well align-items-center mt-3 d-flex flex-wrap justify-content-between">
                            @if (!Session::get('cart')->isEmpty())
                            @else
                                <div class="dc-header" style="widows: 80%; margin: 0 auto;">
                                    <h3 class="heading heading-6 strong-700">{{ __('Your Cart is empty') }}</h3>
                                </div>
                            @endif

                        </div>
                        <div>
                            <form action="{{ route('checkout.guest_checkout') }}" method="POST">
                                @csrf

                                <div class="card">
                                    <div class="card-header">
                                        <h6>অর্ডার কনফার্ম করতে আপনার নাম, ঠিকানা, মোবাইল নাম্বার লিখে <span
                                                style="color:#fe5200;">"Order Now"</span> বাটনে ক্লিক করুন অথবা <a
                                                href="https://api.whatsapp.com/send/?phone=88001882542525&text=Buy Now Page&type=phone_number&app_absent=0">01882542525</a>
                                            সরাসরি Whatsapp করুন </h6>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="name"> Your Full Name *</label>
                                                    <input type="text" id="name" class="form-control "
                                                        name="name" value="{{old('name')}}" placeholder="Full Name"
                                                        required="required">
                                                </div>
                                            </div>
                                            <!-- col-end -->
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="phone">Phone No *</label>
                                                    <input type="number" minlength="11" id="number" maxlength="11"
                                                        pattern="0[0-9]+"
                                                        title="please enter number only and 0 must first character"
                                                        placeholder="01XXXXXXXXX" class="form-control " name="phone"
                                                        value="{{old('phone')}}" required>
                                                        @error('phone')
    <small class="text-danger">{{ $message }}</small>
@enderror
                                                </div>
                                            </div>
                                            <!-- col-end -->
                                            <div class="col-sm-12 col-md-8 col-lg-8">
                                                <div class="form-group mb-3">
                                                    <label for="address">Full Address <small>Village,Thana,District</small>
                                                        * </label>
                                                    <input type="address" id="address" placeholder="Full Address"
                                                        class="form-control " name="address" value="{{old('address')}}" required>
                                                </div>
                                            </div>
                                               <!-- col-end -->
                                            <div class="col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group mb-3">
                                                    <label for="phone">Email <small>Optional</small></label>
                                                    <input type="email" id="email"
                                                        title="please enter Your Valid Email"
                                                        placeholder="Valid Email (Optional)" class="form-control " name="email"
                                                        value="{{old('email')}}">
                                                        @error('email')
    <small class="text-danger">{{ $message }}</small>
@enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="area">Delivery Area *</label>
                                                    <select class="form-control custome-control" id="shipValue" name="shipping" onchange="updateShippingCost()" required>
                                                        <option value="">Select Shipping cost</option>
                                                        <?php
                                                        $shippingAddressData = \App\Models\ShippingMethod::all();
                                                        ?>
                                                        @foreach ($shippingAddressData as $data)
                                                            <option value="{{ $data->price }}" >{{ $data->title }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <!-- col-end -->

                                            <!-------------------->
                                            <!-- col-end -->
                                            <div class="col-sm-12 col-md-6 col-lg-6">

                                                <div class="radio_payment">
                                                    <label id="payment_method">Payment Method</label>
                                                    <div class="payment_option">

                                                    </div>
                                                </div>
                                                <div class="payment-methods">

                                                    <div class="form-check p_cash">
                                                        <input class="form-check-input" type="radio"
                                                            name="payment_option" id="payment_option"
                                                            value="Cash on Delivery" checked="" required=""
                                                            data-parsley-multiple="payment_method">
                                                        <label class="form-check-label" for="inlineRadio1">
                                                            Cash On Delivery
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group mb-3">
                                                   <label class="control-label">{{__('Note')}} <small>(Optional)</small></label>

                                                   <textarea class="form-control textarea-autogrow mb-3" placeholder="Note" rows="2" name="note" value="{{old('note')}}" > </textarea>
                                                </div>
                                            </div>

                                            <input type="hidden" name="checkout_type" value="buy_now">
                                            <!-------------------->
                                            <div class="col-sm-12">
                                                <label class="control-label" for="chk">
                                                    <input required type="checkbox" value="1" name="chk" id="chk"> I agree with <a target="__blank" href="{{ route('privacypolicy') }}">terms</a> the  and <a target="__blank" href="{{ route('returnpolicy') }}"> conditions </a>
                                               </label>
                                                <div class="form-group text-center">
                                                  <button class="btn" style="background-color:#fe5200;color:#fff" id="orderNowBtn" type="submit" disabled>
    <span id="btnText">Order Now</span>
    <span id="btnLoader" style="display:none;"><i class="fas fa-spinner fa-spin"></i> Processing...</span>
</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- card end -->




                            </form>
                        </div>
                    </div>
                    <div class="right">
                        <div class="cartDetails mb-3">
                            <div class="title py-2">
                                <div class="font-weight-bold pl-1"><span class="iconify"
                                        data-icon="bx:bxs-cart-download"></span> Cart Details </div>
                                <div class="badge badge-primary">Total: {{ count(Session::get('cart')) }}
                                    {{ __('Items') }} </div>
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
                                        $subtotal += $cartItem['price'] * $cartItem['quantity'];
                                        $drate =
                                            \App\Models\Master::where('softcode', '=', 'discount')->first()->hardcode /
                                            100;
                                        $damount = $subtotal * $drate;
                                        $tax += $cartItem['tax'] * $cartItem['quantity'];
                                        $shipping += $cartItem['shipping'] * $cartItem['quantity'];
                                        // $shippingcost = $cartItem['shipping'];
                                        $product_name_with_choice = $product->name;
                                        if (isset($cartItem['color'])) {
                                            $product_name_with_choice .=
                                                ' - ' .
                                                \App\Models\Color::where('code', $cartItem['color'])->first()->name;
                                        }
                                        foreach (json_decode($product->choice_options) as $choice) {
                                            $str = $choice->name; // example $str =  choice_0
                                            $product_name_with_choice .= ' - ' . $cartItem[$str];
                                        }
                                    @endphp

                                    <div class="product font-weight-bold">
                                        <div class="name">{{ $product_name_with_choice }}
                                            <strong>× {{ $cartItem['quantity'] }}</strong>
                                        </div>
                                        <div class="price"><span
                                                class="pl-4">{{ single_price($cartItem['price'] * $cartItem['quantity']) }}</span>
                                        </div>
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

                                    <div>Delivery Charge</div>
                                    <div id="shippingCostDisplay">0 </div>

                            </div>
                            <div class="price">
                                <div> Discount</div>
                                <div> {{ single_price(@$damount) }}</div>
                            </div>
                            <div class="price">
                                <div class=" font-weight-bold"> TOTAL</div>
                                <div class=" font-weight-bold" id="totalCostDisplay"> {{ single_price($subtotal + $tax - @$damount) }}
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        @else
            <div class="dc-header" style="widows: 80%; margin: 0 auto;">
                <h3 class="heading heading-6 strong-700">{{ __('Your Cart is empty') }}</h3>
            </div>
        @endif
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function removeFromCartView(e, key) {
            e.preventDefault();
            removeFromCart(key);
            location.reload();
        }

        function updateQuantity(key, element) {
            $.post('{{ route('cart.buyNowUpdateQuantity') }}', {
                _token: '{{ csrf_token() }}',
                key: key,
                quantity: element.value
            }, function(data) {
                updateNavCart();
                $('#cart-summary').html(data);
            });
        }

        function showCheckoutModal() {
            $('#GuestCheckout').modal();
        }
    </script>



    <!-- JavaScript -->
<script>
    const baseCost = <?php echo $subtotal+$tax-@$damount; ?>;
   function updateShippingCost() {

       const selectElement = document.getElementById('shipValue');
       const selectedValue = parseFloat(selectElement.value);
       const displayElement = document.getElementById('shippingCostDisplay');


       // Update the <th> element with the selected value
       displayElement.textContent = selectedValue
           ? `৳ ${parseFloat(selectedValue).toFixed(2)}`
           : '৳ 0.00';

            // Display the result
            const totalCost = baseCost + (parseFloat(selectedValue) || 0);
             // Update the total cost display
       document.getElementById('totalCostDisplay').textContent =
           `৳ ${totalCost.toFixed(2)}`;
   }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form[action="{{ route('checkout.guest_checkout') }}"]');
        const submitButton = document.getElementById('orderNowBtn');
        const btnText = document.getElementById('btnText');
        const btnLoader = document.getElementById('btnLoader');

        submitButton.disabled = false; // Enable on page load

        form.addEventListener('submit', function () {
            submitButton.disabled = true;
            btnText.style.display = 'none';
            btnLoader.style.display = 'inline-block';
        });
    });
</script>
@endsection
