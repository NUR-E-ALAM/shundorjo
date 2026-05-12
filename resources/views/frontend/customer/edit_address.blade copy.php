@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if(Auth::user()->user_type == 'seller')
                        @include('frontend.inc.seller_side_nav')
                    @elseif(Auth::user()->user_type == 'customer')
                        @include('frontend.inc.customer_side_nav')
                    @endif
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('Manage Profile')}}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('profile') }}">{{__('Shipping Address')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="" action="{{ route('customer.shipping.update', $address->id) }}" method="POST">
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
                                            <input type="text" class="form-control mb-3" placeholder="Your Name" name="name" value="{{$address->name}}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Email')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="email" class="form-control mb-3" placeholder="Your Email Address" name="email" value="{{$address->email}}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Phone Number')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="Your Phone Number" name="phone" value="{{$address->phone}}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Address')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea class="form-control mb-3" placeholder="Your Address" rows="3" name="address" required> {{ $address->address }} </textarea>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Region')}}</label>
                                        </div>
                                        <div class="col-md-10">

                                            <select class="form-control mb-3" data-placeholder="Select your region" name="region" required>
                                                <option value="{{ $address->region }}" >{{ $address->region }}</option>
                                                @foreach ($region as $division)
                                                    <option value="{{ $division->name }}" >{{ $division->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('City')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control mb-3" data-placeholder="Select your region" name="city" required>
                                                <option value="{{ $address->city }}" >{{ $address->city }}</option>
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->name }}" >{{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Area')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control mb-3" data-placeholder="Select your region" name="area" required>
                                                <option value="{{ $address->area }}" >{{ $address->area }}</option>
                                                @foreach ($upazilas as $upazila)
                                                    <option value="{{ $upazila->name }}" >{{ $upazila->name }}</option>
                                                @endforeach
                                            </select>
                                         </div>
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Region')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control mb-3" data-placeholder="Select your region" id="division" name="region" required>
                                                <option value="">---select Region---</option>
                                                @foreach ($region as $division)
                                                    <option value="{{ $division->id }}" @if($division->id==$address->region) selected @endif>{{ $division->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('City')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control mb-3" data-placeholder="Select your City" id="district" name="city" required other="{{ $address->city }}">
                                                @foreach ($districts as $districts)
                                                <option value="{{ $districts->id }}" @if($districts->id==$address->city) selected @endif>{{ $districts->name }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Area')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control mb-3" data-placeholder="Select your Area" id="upazila" name="area" required>
                                                @foreach ($upazilas as $upazilas)
                                                <option value="{{ $upazilas->id }}" @if($upazilas->id==$address->area) selected @endif>{{ $upazilas->name }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Shipping Cost')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control mb-3" data-placeholder="Select shipping Cost " id="shipping" name="shipping_cost" required>
                                                <option value="{{ $address->shipping_cost }}">{{ $address->shipping_cost }}</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Post Code')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="Post Code" name="post_code" value="{{ $address->post_code }}" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Label')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control mb-3" data-placeholder="Select your region" name="label" required>

                                                    <option value="{{ $address->label }}" >{{ $address->label }}</option>
                                                    <option value="Office" >Office</option>
                                                    <option value="Home" >Home</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-styled btn-base-1" id="save">{{__('Update')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')



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
