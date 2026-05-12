@extends('frontend.layouts.app')
@section('title')
    Guest Checkout - Shundorjo Care
@stop
@section('content')


    <div id="page-content">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
                        <div class="icon-block icon-block--style-1-v5 text-center active">
                            <div class="block-icon mb-0">
                                <i class="icon-finance-067"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize"><b style="color: rgb(4, 4, 54)">2. {{__('Shipping info')}}</b></h3>
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

                        @php
                        $gust = 1;
                        @endphp
                            @if($gust==1)

                            <form class="form-default"  role="form" action="{{ route('checkout.guest_checkout') }}" method="POST">
                                @csrf
                                <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">{{__('Name')}} <small class="text-danger">*</small> </label>
                                            <input type="text" class="form-control" name="name" placeholder="{{__('Name')}}" required value="{{old('name')}}">
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">{{__('Phone')}} <small class="text-danger">*</small> </label>
                                            <input type="text" class="form-control" placeholder="{{__('Phone')}}" name="phone" required value="{{old('phone')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">{{__('Email')}} <small>(Optional)</small></label>
                                            <input type="email" class="form-control" name="email" placeholder="{{__('Email')}}" value="{{old('email')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">{{__('Delivery Area')}} <small class="text-danger">*</small> </label>
                                            <select class="form-control custome-control" data-live-search="true" id="shipValue" name="shipping" required onchange="updateShippingCost()">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">{{__('Payment Method')}} <small class="text-danger">*</small> </label>
                                            <select class="form-control custome-control" data-live-search="true" id="payment_option" name="payment_option" required>
                                                <option>Select Payment Method</option>
                                                <option value="Cash On Delivery" selected>Cash On Delivery</option>
                                            </select>

                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">{{__('Address')}} <small class="text-danger">*</small> </label>
                                              <textarea class="form-control textarea-autogrow mb-3" placeholder="Address" rows="4" name="address" required value="{{old('address')}}" > </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">{{__('Note')}} <small>(Optional)</small></label>
                                              <textarea class="form-control textarea-autogrow mb-3" placeholder="Note" rows="2" name="note" required value="{{old('note')}}" > </textarea>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group chk">
                                                    <label class="control-label" for="chk">
                                                    <input required type="checkbox" value="1" name="chk" id="chk"> I agree with <a target="__blank" href="{{ route('privacypolicy') }}">terms</a> the  and <a target="__blank" href="{{ route('returnpolicy') }}"> conditions </a>
                                               </label>

                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <input type="hidden" name="checkout_type" value="guest">
                            <div class="row align-items-center pt-4 shophide">
                                <div class="col-5">
                                    <a href="{{ route('products') }}" class="link link--style-3">
                                        <i class="ion-android-arrow-back"></i>
                                        {{__('Return to shop')}}
                                    </a>
                                </div>
                                <div class="col-7 text-right" style="margin-bottom: 8px;">
                                                  <button class="btn btn-styled btn-base-1" id="orderNowBtn" type="submit" disabled>
    <span id="btnText">{{__('Submit')}}</span>
    <span id="btnLoader" style="display:none;"><i class="fas fa-spinner fa-spin"></i> Processing...</span>
</button>
                                </div>

                            </div>
                        </div>
                        </form>
                        @else
                        <h1>You Login First</h1>
                            @endif


                    </div>

                <div class="col-lg-4 ml-lg-auto" id="cart-view">
                    <div class="card sticky-top">
                        <div class="card-title">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h3 class="heading heading-3 strong-400 mb-0">
                                        <span>{{__('Summary')}}</span>
                                    </h3>
                                </div>

                                <div class="col-6 text-right">
                                    <span class="badge badge-md badge-success">
                                        @if(Session::get('cart'))
                                        {{ count(Session::get('cart')) }}
                                        @endif
                                        {{__('Items')}}</span>
                                </div>
                            </div>
                        </div>
                        @if(Session::get('cart'))
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


                            <table class="table-cart table-cart-review">

                                <tfoot>
                                    <tr class="cart-subtotal">
                                        <th>{{__('Subtotal')}}</th>
                                        <td class="text-right">
                                            <span class="strong-600">{{ single_price($subtotal) }}</span>
                                        </td>
                                    </tr>

                                     <tr class="cart-shipping">
                                        <th>{{__('Delivery Charge')}}</th>
                                        <td class="text-right" id="shippingCostDisplay">

                                        </td>
                                    </tr>


                                 <tr class="cart-total">
                                        <th><span>{{__('Discount')}}</span></th>
                                        <td class="text-right">
                                            <strong><span>{{ single_price(@$damount) }}</span></strong>
                                        </td>
                                    </tr>

                                    <tr class="cart-total">
                                        <th><span class="strong-600">{{__('Total')}}</span></th>
                                        <td class="text-right" id="totalCostDisplay">

                                            <strong><span>{{ single_price($subtotal+$tax-@$damount) }}</span></strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @endif
                    </div>



                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')

<script type="text/javascript">
    cartQuantityInitialize();
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

    <script type="text/javascript">
        function guest_checkout(){
            var isValid = true;
            $('.card-body input').each(function() {
                if ( this.value == '' ){
                    isValid = false;
                }
            });

            if(isValid){
                 $.ajax({
                    type:"POST",
                    url:'{{ route('checkout.guest_checkout') }}',
                    data: $('#shipping_form').serialize(),
                    success: function(data){
                        $('#page-content').html(data);
                    }
                });
            }
            else{
                alert('Please fill all the fileds');
            }
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
