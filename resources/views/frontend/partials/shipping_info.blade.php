@extends('frontend.layouts.app')
@section('title')
    Shundorjo Care BD Checkout
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

        <section class="py-4 gry-bg">
            <div class="container">
                <div class="row cols-xs-space cols-sm-space cols-md-space">
                    <div class="col-lg-8">
                        @if(Auth::check())
                        @if(Auth::user()->shipping_address)
                            <form class="form-default" data-toggle="validator" role="form" id="shipping_form" enctype="multipart/form-data">
                                @csrf
                                <div class="card">
                                    @php
                                    $user = \App\Models\ShippingAddess::where('id', Auth::user()->shipping_address)->first();
                                    @endphp
                                    <div class="col-md-12">
                                        <div class="m-1">
                                            <a class="float-right btn btn-sm btn-success" href="{{route('change.shipping.address')}}"><i class="fa fa-exchange"></i>  Change shipping address</a>
                                        </div><div class="m-1">
                                           <a class="float-right btn btn-sm btn-primary mr-2" href="{{route('add.new.shipping')}}"><i class="fa fa-plus"></i>  Add New Shipping address</a>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Name')}}</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Email')}} <small>(Optional)</small></label>
                                                    <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Phone')}}</label>
                                                    <input type="text" class="form-control" name="phone" id="phone" value="{{ $user->phone }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Address')}}</label>
                                         <textarea class="form-control textarea-autogrow mb-3" id="address" placeholder="Your Address" rows="4" name="address" required>{{ @$user->address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                       @php
                                            $region = \App\Models\Division::where('id', '=', $user->region)->first()->name;
                                            $city = \App\Models\District::where('id', '=', $user->city)->first()->name;
                                            $area = \App\Models\Upazila::where('id', '=', $user->area)->first()->name;
                                        @endphp
                                         <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('Region')}}</label>
                                                    <input type="text" class="form-control" value="{{$region}}" name="region" id="region" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('City')}}</label>
                                                    <input type="text" class="form-control" id="city" value="{{ $city }}" name="city" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('Area')}}</label>
                                                    <input type="text" class="form-control" id="area" value="{{ $area }}" name="area" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('Post Code')}}</label>
                                                    <input type="text" class="form-control" id="post_code" value="{{ $user->post_code }}" name="post_code" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <div class="col-md-12">
                                                <div class="ermsg">

                                                </div>
                                            </div>
                                        </div> --}}


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
                                        <input type="hidden" class="form-control" value="{{ $user->shipping_cost }}" name="shipping" id="shippingcost" readonly>
                                        <input type="hidden" name="checkout_type" value="logged">
                                <div class="row">
                                    <div class="col-5">
                                        <a href="{{ route('products') }}" class="link link--style-3">
                                            <i class="la la-mail-reply"></i>
                                            {{__('Return to home')}}
                                        </a>
                                    </div>
                                    <div class="col-7 text-right" style="margin-bottom: 8px;">
                                        @if(Auth::check())
                                        @if(Auth::user()->shipping_address)
                                            <button type="button" class="btn btn-styled btn-base-1" onclick="getPaymentInfo()" >{{__('Continue to Order')}}</button>

                                        @endif
                                        @else
                                        <button type="button" class="btn btn-styled btn-base-1"  >{{__('Continue to Order')}}</button>
                                        @endif
                                    </div>
                                </div>
                                    </div>



                            </form>
                        @else
                        <?php
                            $region = \App\Models\Division::all();
                            $districts = \App\Models\District::all();
                            $upazilas = \App\Models\Upazila::all();
                            $shippingAddressData = \App\Models\ShippingMethod::all();
                            ?>
                            <div class="card-body">
                                <form class="" action="{{ route('customer.shipping.address') }}" method="POST">
                                    @csrf
                                    <div class="form-box bg-white mt-4">
                                        <div class="form-box-title px-3 py-2">
                                            {{__('Shipping info')}}
                                        </div>
                                        <div class="form-box-content p-3">

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{__('Full Name')}}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control mb-3" placeholder="Your Name" name="name" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{__('Email')}} <small>(Optional)</small></label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="email" class="form-control mb-3" placeholder="Your Email Address" name="email">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{__('Phone Number')}}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control mb-3" placeholder="Your Phone Number" name="phone" required>
                                                </div>
                                            </div>

                                        <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{__('Region')}}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <select class="form-control mb-3" data-placeholder="Select your region" id="division" name="region" required>
                                                        <option value="">---select Region---</option>
                                                        @foreach ($region as $division)
                                                            <option value="{{ $division->id }}" >{{ $division->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{__('City')}}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <select class="form-control mb-3" data-placeholder="Select your City" id="district" name="city" required>
                                                        <option>---Select City---</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{__('Area')}}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <select class="form-control mb-3" data-placeholder="Select your Area" id="upazila" name="area" required>
                                                        <option>---Select Area---</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{__('Shipping Cost')}}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <select class="form-control mb-3" data-placeholder="Select shipping Cost " id="shipping" name="shipping_cost" required>
                                                        <option value="">Select Shipping cost</option>

                                                    </select>
                                                </div>
                                            </div>

                                         <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{__('Post Code')}}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control mb-3" placeholder="Post Code" name="post_code" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{__('Label')}}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <select class="form-control mb-3" data-placeholder="Select your region" name="label" required>
                                                            <option value="Office" >Office</option>
                                                            <option value="Home" >Home</option>
                                                    </select>
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
                                    </div>
                                    <input type="text" name="checkout" value="checkout" hidden readonly>
                                    <div class="text-right mt-4">
                                        <button type="submit" class="btn btn-styled btn-base-1" id="save">{{__('Add Address')}}</button>
                                    </div>
                                </form>
                            </div>

                        @endif
                        @else
                        @php
                        $gust = 1;
                        @endphp
                            @if($gust==1)

                            <form class="form-default" data-toggle="validator" role="form" id="shipping_form">
                                @csrf
                                <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">{{__('Name')}}</label>
                                            <input type="text" class="form-control" name="name" placeholder="{{__('Name')}}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">{{__('Email')}} <small>(Optional)</small></label>
                                            <input type="email" class="form-control" name="email" placeholder="{{__('Email')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">{{__('Phone')}}</label>
                                            <input type="text" class="form-control" placeholder="{{__('Phone')}}" name="phone" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">{{__('Shipping Method')}}</label>
                                            <select class="form-control custome-control" data-live-search="true" id="shipValue" name="shipping" required>
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
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">{{__('Address')}}</label>
                                              <textarea class="form-control textarea-autogrow mb-3" placeholder="Your Full Address" rows="4" name="address" required > </textarea>
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
                                    <button type="button" class="btn btn-styled btn-base-1" onclick="getPaymentInfo()">{{__('Continue to Order')}}</button>
                                </div>
                            </div>
                        </div>
                        </form>
                        @else
                        <h1>You Login First</h1>
                            @endif

                        @endif
                    </div>

                <div class="col-lg-4 ml-lg-auto" id="cart-view">
                    @include('frontend.partials.cart_summary')
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')

    <script>
    $("#shipValue").on('change',function(e){
    e.preventDefault();
    var value  = e.target.value;
    $.ajax({
          type: 'GET',
          url: "{{url('/gust-checkoutNew')}}",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: {value},
          success: function (response) {
              updateNavCart();
              $('#cart-view').html(response);
          },
        error: function(response) {
            alert("Address Field is Requerd for order");
        }
      });

  });
    </script>

    <script type="text/javascript">
        function getPaymentInfo(){
            // var isValid = true;
            // $('.card-body input').each(function() {
            //     if ( this.value == '' ){
            //         isValid = false;
            //     }
            // });

            // if(isValid){
                 $.ajax({
                    type:"POST",
                    url:'{{ route('checkout.payment_info') }}',
                    data: $('#shipping_form').serialize(),
                    success: function(data){
                        $('#page-content').html(data);
                    }
                });
            // }
            // else{
            //     alert('Please fill all the fileds');
            // }
        }

// drop down select section
    $("#division").on('change',function(e){
      e.preventDefault();
      var ddlDistrict=$("#district");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{url('/district-by-division')}}",
        data:{_token:$('input[name=_token]').val(),division:$(this).val()},
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', ddlDistrict).remove();
            $('#district').append('<option value="">---Select City---</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.name
              }).appendTo('#district');
            });
          }

      });
    });

    $("#district").on('change',function(e){
      e.preventDefault();
      var ddlthana=$("#upazila");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{url('/thana-by-district')}}",
        data:{_token:$('input[name=_token]').val(),districts:$(this).val()},
        success:function(response){
            // var jsonData=JSON.parse(response);
            $('option', ddlthana).remove();
            $('#upazila').append('<option value="">---Select Area---</option>');
            $.each(response, function(){
              $('<option/>', {
                'value': this.id,
                'text': this.name
              }).appendTo('#upazila');
            });
          }
        });
    });

    $("#upazila").on('change',function(e){
      e.preventDefault();
      var ddlship=$("#shipping");
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type:'POST',
        url: "{{url('/ship-by-thana')}}",
        data:{_token:$('input[name=_token]').val(),upazilas:$(this).val()},
        success:function(response){
            $('option', ddlship).remove();
            $.each(response, function(){
              $('<option/>', {
                'value': this.shipping_cost,
                'text': this.shipping_cost
              }).appendTo('#shipping');
            });
          }
        });
    });

  </script>

@endsection
