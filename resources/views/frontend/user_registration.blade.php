@extends('frontend.layouts.app')
@section('title')
    Registration - Shundorjo
@stop
@section('content')
    <style>
        #message {
            display: block;
            color: #000;
            margin-top: 0px;
            /*padding: 10px 0px;*/
            margin-bottom: 10px;
        }

        #message p {
            padding: 0 35px;
            font-size: 14px;
            line-height: 1rem;
        }

        /* Add a green text color and a checkmark when the requirements are right */
        .valid {
            color: green;
        }

        .valid:before {
            position: relative;
            left: -20px;
            content: "✔";
        }

        /* Add a red text color and an "x" when the requirements are wrong */
        .invalid {
            color: red;
        }

        .invalid:before {
            position: relative;
            left: -20px;
            content: "✖";
        }

    </style>
    <section class="gry-bg py-4">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1">
                        <div class="card">
                            <div class="text-center px-35 pt-5">
                                <h3 class="heading heading-4 strong-500">
                                    {{ __('Create an account.') }}
                                </h3>
                            </div>
                            <div class="px-5 py-3 py-lg-5">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mx-auto">
                                        <div class="ermsg"></div>
                                        <form class="form-default" role="form" action="{{ route('user.register') }}"
                                            method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <!-- <label>{{ __('name') }}</label> -->
                                                        <div class="input-group input-group--style-1">
                                                            <input type="text"
                                                                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                                value="{{ old('name') }}"
                                                                placeholder="{{ __('Name') }}" name="name" id="name"
                                                                required>
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
                                                        <!-- <label>{{ __('email') }}</label> -->
                                                        <div class="input-group input-group--style-1">
                                                            <input id="emailNew" type="number"
                                                                class="form-control @error('error') is-invalid @enderror"
                                                                value="{{ old('email') }}"
                                                                placeholder="{{ __('Phone') }}" name="email" required
                                                                autocomplete="number">
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-phone-square"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @error('email')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                            <strong>{{ $message }}</strong>
                                                            <strong>{{ $validator->messages() }}</strong>
                                                        </span>
                                                    @enderror
                                                    {{-- @if ($errors->any())
                                                        <h5 style="color: rgb(155, 37, 37)">This email has already been used!!</h5>
                                                        @endif --}}
                                                    <span id="error_emails"></span>
                                                </div>
                                            </div>

                                            {{-- email  --}}
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <!-- <label>{{ __('email') }}</label> -->
                                                        <div class="input-group input-group--style-1">
                                                            <input id="emailCheck" type="email"
                                                                class="form-control"
                                                                value="{{ old('emailAddress') }}"
                                                                placeholder="{{ __('Email optional') }}" name="emailAddress" required
                                                                autocomplete="email">
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-envelope"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <span id="error_emailAddress"></span>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <!-- <label>{{ __('password') }}</label> -->
                                                        <div class="input-group input-group--style-1">
<input type="password" id="passwords" class="form-control"
                                                                placeholder="{{ __('Password') }}" name="password"
                                                                pattern="{6,}"
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
                                                        <!-- <label>{{ __('confirm_password') }}</label> -->
                                                        <div class="input-group input-group--style-1">
                                                            <input type="password" class="form-control"
                                                                placeholder="{{ __('Confirm Password') }}"
                                                                name="password_confirmation" id="password_confirmations"
                                                                required>
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-lock"></i>
                                                            </span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}">
                                                            @if ($errors->has('g-recaptcha-response'))
                                                                <span class="invalid-feedback" style="display:block">
                                                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            {{-- password validation --}}
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="message">
                                                        <p><span id='messagevn'></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- password validation --}}

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-check form-switch text-left">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="checkbox_example_1" id="mySwitch" required
                                                            >
                                                        <label for="mySwitch" class="form-check-label">By signing up
                                                            you agree to our <a href="{{ route('terms') }}">terms and
                                                                conditions</a></label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row align-items-center">
                                                <div class="col-12 text-right  mt-3">
                                                    <button type="submit" name="register" id="registers"
                                                        class="btn btn-styled btn-base-1 w-100 btn-md">{{ __('Create Account') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    {{ csrf_field() }}

                                  {{--  <div class="col-lg-1 text-center align-self-stretch">
                                        <div class="border-right h-100 mx-auto" style="width:1px;"></div>
                                    </div>
                                    <div class="col-12 col-lg">

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
                                    </div>--}}
                                </div>
                            </div>
                            <div class="text-center px-35 pb-3">
                                <p class="text-md">
                                    {{ __('Already have an account?') }}<a href="{{ route('user.login') }}"
                                        class="strong-600">{{ __('Log In') }}</a>
                                </p>
                            </div>
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
            $('#emailNew').keyup(function() {
                var error_email = '';
                var email = $('#emailNew').val();
                console.log('email', email)
                var _token = $('input[name="_token"]').val();
                var filter = /(^(01){1}[3456789]{1}(\d){8})$/;
                if (!filter.test(email)) {
                    $('#error_emails').html('<label class="text-danger">Invalid Phone Number</label>');
                    $('#emailNew').addClass('has-error');
                    $('#registers').attr('disabled', 'disabled');
                } else if (email.length > 11) {
                    $('#error_emails').html('<label class="text-danger">Invalid Phone Number</label>');
                    $('#emailNew').addClass('has-error');
                    $('#registers').attr('disabled', 'disabled');
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
                                $('#error_emails').html(
                                    '<label class="text-success">Phone Available</label>');
                                $('#emailNew').removeClass('has-error');
                                $('#registers').attr('disabled', false);
                            } else {
                                $('#error_emails').html(
                                    '<label class="text-danger">Already have a Account</label>'
                                );
                                $('#emailNew').addClass('has-error');
                                $('#registers').attr('disabled', 'disabled');
                            }
                        }
                    })
                }
            });
            $('#emailCheck').keyup(function() {
                var error_email = '';
                var email = $('#emailCheck').val();
                console.log('emailCheck', email)
                var _token = $('input[name="_token"]').val();
                // var filter = /(^(01){1}[3456789]{1}(\d){8})$/;
                // if (!filter.test(email)) {
                //     $('#error_emails').html('<label class="text-danger">Invalid Phone Number</label>');
                //     $('#emailNew').addClass('has-error');
                //     $('#registers').attr('disabled', 'disabled');
                // } else if (email.length > 11) {
                //     $('#error_emails').html('<label class="text-danger">Invalid Phone Number</label>');
                //     $('#emailNew').addClass('has-error');
                //     $('#registers').attr('disabled', 'disabled');
                // } else {
                    $.ajax({
                        url: "{{ route('email.emailCheck') }}",
                        method: "POST",
                        data: {
                            emailCheck: email,
                            _token: _token
                        },
                        success: function(result) {
                            if (result == 'unique') {
                                $('#error_emailAddress').html(
                                    '<label class="text-success">Email Available</label>');
                                $('#emailCheck').removeClass('has-error');
                                // $('#registers').attr('disabled', false);
                            } else {
                                $('#error_emailAddress').html(
                                    '<label class="text-danger">Already have a Account</label>'
                                );
                                $('#emailCheck').addClass('has-error');
                                // $('#registers').attr('disabled', 'disabled');
                            }
                        }
                    })
                // }
            });
        $('#password_confirmations').on('keyup', function() {

        if ($('#passwords').val() == $('#password_confirmations').val()) {
            $('#messagevn').html('Password Match').css('color', 'green');
            $('#messagevn').addClass('valid');
            $('#messagevn').removeClass('invalid');
            $('#registers').attr('disabled', false);
        } else {
            $('#messagevn').html('Password doesn\'t Match').css('color', 'red');
            $('#messagevn').addClass('invalid');
            $('#messagevn').removeClass('valid')
            $('#registers').attr('disabled', 'disabled');
        }
        });
        });
    </script>
@endsection
