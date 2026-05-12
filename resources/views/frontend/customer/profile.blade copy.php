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
                                            <li class="active"><a href="{{ route('profile') }}">{{__('Manage Profile')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="" action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Basic info')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Your Name')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="{{__('Your Name')}}" name="name" value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Your Email')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="email" class="form-control mb-3" placeholder="{{__('Your Email')}}" name="email" id="email" value="{{ Auth::user()->email }}" @if(!empty(Auth::user()->email)) readonly @endif>
                                            <span id="error_email"></span>
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                                <strong>{{ $message }}</strong>
                                                {{-- <strong>{{ $validator->messages() }}</strong> --}}
                                            </span>
                                        @enderror


                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Photo')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" name="photo" id="file-3" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                            <label for="file-3" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{__('Choose image')}}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Shipping info')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Address')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea class="form-control textarea-autogrow mb-3" placeholder="Your Address" rows="1" name="address">{{ Auth::user()->address }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Country')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <select class="form-control mb-3 selectpicker" data-placeholder="Select your country" name="country">
                                                    @foreach (\App\Models\Country::all() as $key => $country)
                                                        <option value="{{ $country->code }}" <?php if(Auth::user()->country == $country->code) echo "selected";?> <?php if($country->code == 'BD') echo "selected"; ?> >{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('City')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="Your City" name="city" value="{{ Auth::user()->city }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Postal Code')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="Your Postal Code" name="postal_code" value="{{ Auth::user()->postal_code }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Phone')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="Your Phone Number" name="phone" value="{{ Auth::user()->phone }}" @if(!empty(Auth::user()->phone)) readonly @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-styled btn-base-1" id="save">{{__('Update Profile')}}</button>
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
    $(document).ready(function() {
        $('#email').keyup(function(){
            // alert('test');
          var email = $('#email').val();
          var error_email = '';
          var email = $('#email').val();
          var _token = $('input[name="_token"]').val();
           $.ajax({
            url:"{{ route('email.check') }}",
            method:"POST",
            data:{email:email, _token:_token},

            success:function(result)
            {
             if(result == 'unique')
             {
              $('#error_email').html('<label class="text-success">Email Available</label>');
              $('#email').removeClass('has-error');
              $('#save').attr('disabled', false);
             }
             else
             {
              $('#error_email').html('<label class="text-danger">Already have a Account</label>');
              $('#email').addClass('has-error');
              $('#save').attr('disabled', 'disabled');
             }
            }
           });
        });
    });
</script>
@endsection
