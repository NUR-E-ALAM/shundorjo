<section class="slice-xs sct-color-2 border-bottom">
    <div class="container container-sm">
        <div class="row cols-delimited">
            <div class="col-4">
                <div class="icon-block icon-block--style-1-v5 text-center">
                    <div class="block-icon mb-0">
                        <i class="icon-hotel-restaurant-105"></i>
                    </div>
                    <div class="block-content d-none d-md-block">
                        <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">1. {{__('My Cart')}}</h3>
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
                <div class="icon-block icon-block--style-1-v5 text-center active">
                    <div class="block-icon c-gray-light mb-0">
                        <i class="icon-finance-059"></i>
                    </div>
                    <div class="block-content d-none d-md-block active">
                        <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">3. {{__('Payment')}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4 gry-bg">
    <div class="container">
        <div class="row cols-xs-space cols-sm-space cols-md-space">
            <div class="col-lg-8">
                <form action="{{ route('payment.checkout') }}" class="form-default" data-toggle="validator" role="form" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-title px-4">
                            <h3 class="heading heading-5 strong-500">
                                {{__('Select a payment option')}}
                            </h3>
                        </div>
                        <div class="card-body text-center">
                            <ul class="inline-links">
                                @if (\App\Models\BusinessSetting::where('type', 'paypal_payment')->first()->value == 1)
                                    <li>
                                        <label class="payment_option">
                                            <input type="radio" id="" name="payment_option" value="paypal" checked>
                                            <span>
                                                <img src="{{ asset('frontend/images/icons/cards/paypal.png')}}" class="img-fluid">
                                            </span>
                                        </label>
                                    </li>
                                @endif
                                @if(\App\Models\BusinessSetting::where('type', 'stripe_payment')->first()->value == 1)
                                    <li>
                                        <label class="payment_option">
                                            <input type="radio" id="" name="payment_option" value="stripe" checked>
                                            <span>
                                                <img src="{{ asset('frontend/images/icons/cards/stripe.png')}}" class="img-fluid">
                                            </span>
                                        </label>
                                    </li>
                                @endif
                                @if(\App\Models\BusinessSetting::where('type', 'sslcommerz_payment')->first()->value == 1)
                                    <!--<li>-->
                                    <!--    <label class="payment_option">-->
                                    <!--        <input type="radio" id="" name="payment_option" value="sslcommerz" checked>-->
                                    <!--        <span>-->
                                    <!--            <img src="{{ asset('frontend/images/icons/cards/sslcommerz.png')}}" class="img-fluid">-->
                                    <!--        </span>-->
                                    <!--    </label>-->
                                    <!--</li>-->
                                @endif
                                @if(\App\Models\BusinessSetting::where('type', 'cash_payment')->first()->value == 1)
                                    <li>
                                        <label class="payment_option">
                                            <input type="radio" id="" name="payment_option" value="cash_on_delivery" checked>
                                            <span>
                                                <img src="{{ asset('frontend/images/icons/cards/cod.png')}}" class="img-fluid">
                                            </span>
                                        </label>
                                    </li>
                                @endif
                            </ul>

                            @if (Auth::check())
                                <div class="text-center mt-4">
                                    or
                                    <div class="h5">Your wallet balance : <strong>{{ single_price(Auth::user()->balance) }}</strong></div>
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
                                    $totalcost =$subtotal+$tax+$shipping;
                                    @endphp
                                    @endforeach
                                    @if (Auth::user()->balance>=$totalcost)

                                    <label class="payment_option" >
                                        <input type="radio" id="" name="payment_option" value="wallet" >
                                        <span>
                                            <img src="{{ asset('frontend/images/icons/cards/wallet.png')}}" class="img-fluid">
                                        </span>
                                    </label>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row align-items-center pt-4">
                        <div class="col-6">
                            <a href="{{ route('home') }}" class="link link--style-3">
                                <i class="la la-mail-reply"></i>
                                {{__('Return to home')}}
                            </a>
                        </div>
                        <div class="col-6 text-right">
                            <button type="submit"  id="orderBtn" class="btn btn-styled btn-base-1">{{__('Complete Order')}}</button>
                        </div>

                    </div>
                </form>
            </div>

            <div class="col-lg-4 ml-lg-auto">
                @include('frontend.partials.cart_summary')
            </div>
        </div>
    </div>
</section>

    <div style="width: 90%; margin: 0 auto;"><a target="_blank" href="https://www.sslcommerz.com/" title="SSLCommerz"><img style="width:100%;height:auto" src="https://securepay.sslcommerz.com/public/image/SSLCommerz-Pay-With-logo-All-Size-03.png"></a></div>


<script type="text/javascript">
    function use_wallet(){
        $('input[name=payment_option]').val('wallet');
        $('#checkout-form').submit();
    }
</script>
<script>
document.getElementById('orderBtn').addEventListener('click', function() {
    let btn = this;
    btn.disabled = true;
    btn.innerHTML = 'Processing...';
    btn.form.submit(); // Submit the form
});
</script>
