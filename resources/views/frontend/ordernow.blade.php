@extends('frontend.layouts.app')
@section('title')
    Order Medicine
@stop
@section('content')
    <section class="gry-bg py-4">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-xl-2">
                    </div>

                    <div class="col-xl-8">
                        <div class="card">
                            <div class="text-center px-35 pt-5">
                                <h3 class="heading heading-4 strong-500">
                                    {{__('আপনি কি রেগুলার ঔষধ সেবন করেন? আপনার প্রয়োজনীয় যেকোনো ঔষধ শেষ হবার পূর্বেই আমরা পৌঁছে দিবো  আপনার বাসায়। আপনার দরকারি ঔষদের নাম অথবা আপনার প্রেসক্রিপশন দিয়ে ফর্মটি সাবমিট করুন। ')}}
                                </h3>
                            </div>
                            <div class="px-5 py-3">
                                <div class="row align-items-center">

                                    <div class="col-12 col-lg">

                                        <form class="form-default" action="{{ route('user.order.register') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="text" class="form-control" value="{{ old('name') }}" placeholder="{{ __('Name') }}" name="name">
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-user"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="text" class="form-control" value="{{ old('phone') }}" placeholder="{{ __('Mobile') }}" name="phone" required>
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-user"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ __('Email') }}" name="email">
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-envelope"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group--style-1">

                                                            <textarea class="form-control" value="{{ old('address') }}" placeholder="{{ __('Address') }}" name="address"></textarea>
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-user"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group--style-1">
                                                            <textarea rows="7" class="form-control" placeholder="{{ __('Medicine Name & Required Quentity') }}" name="medicine_details"></textarea>
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-user"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="file" class="form-control" placeholder="{{ __('Upload Prescription') }}" name="prescription_image">
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-user"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="row">
                                                <div class="col-12">
                                                    <div class="checkbox pad-btm text-left">
                                                        <input class="magic-checkbox" type="checkbox" name="status" id="checkboxExample_1a" value="1" required>
                                                        <label for="checkboxExample_1a" class="text-sm">{{__('By signing up you agree to our terms and conditions.')}}</label>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="row align-items-center">
                                                <div class="col-12 text-right  mt-3">
                                                    <button type="submit" class="btn btn-styled btn-base-1 w-100 btn-md">{{ __('Submit') }}</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>


                                </div>
                            </div>
                            <div class="text-center px-35 pb-3">
                                <p class="text-md">
                                    {{__('Already have an account?')}}<a href="{{ route('user.login') }}" class="strong-600">{{__('Log In')}}</a>
                                </p>
                            </div>
                        </div>
                    </div>



                    <div class="col-xl-2">
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        function autoFillSeller(){
            $('#email').val('seller@example.com');
            $('#password').val('123456');
        }
        function autoFillCustomer(){
            $('#email').val('customer@example.com');
            $('#password').val('123456');
        }
    </script>
@endsection
