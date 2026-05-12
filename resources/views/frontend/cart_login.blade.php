@extends('frontend.layouts.app')
@section('title')
    Login - Shundorjo Care
@stop
@section('content')
    <section class="gry-bg py-5">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1">
                        <div class="card">
                            <div class="px-5 py-3 py-lg-5">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg">
                                        <div class="text-center">
                                            {{-- <h3 class="heading heading-4 strong-500">
                                                {{ __('Do you already have Account?') }}
                                            </h3> --}}
                                            <h3 class="heading heading-4 strong-500">
                                                {{ __('Login') }}
                                            </h3>
                                        </div>
                                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}"
                                            method="POST">
                                            @csrf
                                            <div class="col-lg-12">
                                                @if ($errors->has('email'))
                                                    <p style="color: rgb(155, 37, 37)">These credentials do not match our
                                                        records.</p>
                                                @elseif($errors->has('password'))
                                                    <p style="color: rgb(155, 37, 37)">These credentials do not match our
                                                        records.</p>
                                                @elseif($errors->has('account'))
                                                    <p style="color: rgb(155, 37, 37)">Sorry! Account Not Found</p>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="number"
                                                                class="form-control form-control-sm {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                                placeholder="{{ __('Phone') }}" name="email"
                                                                id="email" required>
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-mobile"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                         <label>{{ __('password') }}</label>
                                                        <div class="input-group input-group--style-1">
                                                            <input type="password"
                                                                class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                                placeholder="{{ __('Password') }}" name="password"
                                                                id="password" required>
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-lock"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    {{-- <div class="form-group">
                                                        <div class="checkbox pad-btm text-left">
                                                            <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox" name="remember" id="remember" checked>
                                                            <label for="demo-form-checkbox" class="text-sm">
                                                                {{ __('Remember Me') }}
                                                            </label>
                                                        </div>
                                                    </div> --}}
                                                    <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox"
                                                        name="remember" id="remember" checked hidden readonly>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <a href="{{ route('forget.password.get') }}"
                                                        class="link link-xs link--style-3">{{ __('Forgot password?') }}</a>
                                                    {{-- <a href="{{ route('password.request') }}" class="link link-xs link--style-3">{{__('Forgot password?')}}</a> --}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col text-center">
                                                    <button type="submit"
                                                        class="btn btn-styled btn-base-1 btn-md w-100">{{ __('Login') }}</button>
                                                </div>
                                            </div>
                                            </form>



                                    </div>
                                    <div class="col-lg-1 text-center align-self-stretch">
                                        <div class="border-right h-50 mx-auto"></div>
                                        <div class="mb-5">Or</div>
                                        <div class="border-right h-50 mx-auto"></div>
                                    </div>
                                    <div class="col-12 col-lg">
                                        <div class="text-center">
                                            <h3 class="heading heading-4 strong-500">
                                                {{ __('Without Login') }}
                                            </h3>

                                        </div>
                                          {{-- /////////////////////////////////////// --}}
                                          <a href="{{ route('checkout.gustshipping_info') }}"
                                          class="btn btn-styled btn-base-1 btn-md w-100">{{ __('Quick Checkout') }}</a>

                                      {{-- /////////////////////////////////////// --}}
                                    </div>

                                    <div class="col-lg-1 text-center align-self-stretch">
                                        <div class="border-right h-50 mx-auto"></div>
                                        <div class="mb-5">Or</div>
                                        <div class="border-right h-50 mx-auto"></div>
                                    </div>
                                    <div class="col-12 col-lg">
                                        <div class="text-center">
                                            <h3 class="heading heading-4 strong-500">
                                                {{ __('Registration') }}
                                            </h3>

                                        </div>
                                        {{-- register from --}}
                                        {{-- <div class="col-12 col-lg"> --}}

                                        <div class="ermsg"></div>
                                        {{-- <form class="form-default" action=""> --}}
                                        <form class="form-default" role="form" action="{{ route('user.register') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="cart" value="cart" readonly>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="text"
                                                                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                                value="{{ old('name') }}"
                                                                placeholder="{{ __('Name') }}" name="name"
                                                                id="name" required>
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-user"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @error('name')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group--style-1">
                                                            <input id="phone" type="number"
                                                                class="form-control @error('error') is-invalid @enderror"
                                                                placeholder="{{ __('Phone') }}" name="email" required>
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-mobile"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @error('email')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <span id="error_email"></span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="password" id="password2" class="form-control"
                                                                placeholder="{{ __('Password') }}" name="password"
                                                                title="Must contain at least one number and one uppercase and lowercase letter, and at least 6 or more characters"
                                                                required>
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-lock"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="clear"></div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="password" class="form-control"
                                                                placeholder="{{ __('Confirm Password') }}"
                                                                name="password_confirmation" id="password_confirmation"
                                                                required>
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-lock"></i>
                                                            </span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- password validation --}}
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="message">
                                                        <p><span id='messagev'></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- password validation --}}

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="pad-btm text-left">
                                                        <input class="magic-checkbox"
                                                            style="position: relative; top: 3px;" type="checkbox"
                                                            name="checkbox_example_1" id="checkboxExample_1a" required>
                                                        <label for="checkboxExample_1a" class="text-sm">By signing up you
                                                            agree to our <a href="{{ route('terms') }}">terms and
                                                                conditions</a></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row align-items-center">
                                                <div class="col-12 text-right  mt-3">
                                                    <button type="submit" name="register" id="register"
                                                        class="btn btn-styled btn-base-1 w-100 btn-md">{{ __('Create Account') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                        {{-- </div> --}}
                                        {{ csrf_field() }}
                                        {{-- register end --}}
                                        @if (\App\Models\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                            <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                                class="btn btn-styled btn-block btn-google btn-icon--2 btn-icon-left px-4 my-4">
                                                <i class="icon fa fa-google"></i> {{ __('Login with Google') }}
                                            </a>
                                        @endif
                                        @if (\App\Models\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                                class="btn btn-styled btn-block btn-facebook btn-icon--2 btn-icon-left px-4 my-4">
                                                <i class="icon fa fa-facebook"></i> {{ __('Login with Facebook') }}
                                            </a>
                                        @endif
                                        @if (\App\Models\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                            <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
                                                class="btn btn-styled btn-block btn-twitter btn-icon--2 btn-icon-left px-4 my-4">
                                                <i class="icon fa fa-twitter"></i> {{ __('Login with Twitter') }}
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            {{-- <div class="text-center px-35 pb-3">
                                <p class="text-md">
                                    {{__('Need an account?')}} <a href="{{ route('user.registration') }}" class="strong-600">{{__('Register Now')}}</a>
                                </p>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#phone').keyup(function() {
                var error_email = '';
                var email = $('#phone').val();
                var _token = $('input[name="_token"]').val();
                var filter = /(^(01){1}[3456789]{1}(\d){8})$/;

                if (!filter.test(email)) {
                    $('#error_email').html('<label class="text-danger">Invalid Phone Number</label>');
                    $('#phone').addClass('has-error');
                    $('#register').attr('disabled', 'disabled');
                } else if (email.length > 11) {
                    $('#error_email').html('<label class="text-danger">Invalid Phone Number</label>');
                    $('#phone').addClass('has-error');
                    $('#register').attr('disabled', 'disabled');
                } else {
                    $.ajax({
                        url: "{{ route('email_available.check') }}",
                        method: "POST",
                        data: {
                            email: email,
                            _token: _token
                        },
                        success: function(result) {
                            if (result == 'unique') {
                                $('#error_email').html(
                                    '<label class="text-success">Phone Number Available</label>'
                                );
                                $('#phone').removeClass('has-error');
                                $('#register').attr('disabled', false);
                            } else {
                                $('#error_email').html(
                                    '<label class="text-danger">Already have a Account</label>'
                                );
                                $('#phone').addClass('has-error');
                                $('#register').attr('disabled', 'disabled');
                            }
                        }
                    })
                }
            });

        });
    </script>
    <script>
        $('#password_confirmation').on('keyup', function() {
            if ($('#password2').val() == $('#password_confirmation').val()) {
                $('#messagev').html('Password Match').css('color', 'green');
                $('#messagev').addClass('valid');
                $('#messagev').removeClass('invalid');
                $('#register').attr('disabled', false);
            } else {
                $('#messagev').html('Password doesn\'t Match').css('color', 'red');
                $('#messagev').addClass('invalid');
                $('#messagev').removeClass('valid')
                $('#register').attr('disabled', 'disabled');
            }
        });
    </script>
@endsection
