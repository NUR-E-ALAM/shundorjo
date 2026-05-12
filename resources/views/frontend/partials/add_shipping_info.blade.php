@extends('frontend.layouts.app')
@section('title')
    Checkout
@stop
@section('content')
    <div id="page-content">
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

        <section class="py-4 gry-bg">
            <div class="container">
                <div class="row cols-xs-space cols-sm-space cols-md-space">
                    <div class="col-lg-8">
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
                                            <label>{{__('Email')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="email" class="form-control mb-3" placeholder="Your Email Address" name="email" required>
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
                                            <label>{{__('Address')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea class="form-control textarea-autogrow mb-3" placeholder="Your Address" rows="1" name="address" required></textarea>
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
                                                <option>---Shipping Cost---</option>
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

                                </div>
                            </div>
                            <input type="text" name="checkout" value="checkout" hidden readonly>
                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-styled btn-base-1" id="save">{{__('Add Address')}}</button>
                            </div>
                        </form>
                </div>


                <div class="col-lg-4 ml-lg-auto">
                    @include('frontend.partials.cart_summary')
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')
    <script type="text/javascript">
    function getPaymentInfo(){
        var isValid = true;
        $('.card-body input').each(function() {
            if ( this.value == '' ){
                isValid = false;
            }
        });

        if(isValid){
             $.ajax({
                type:"POST",
                url:'{{ route('checkout.payment_info') }}',
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
