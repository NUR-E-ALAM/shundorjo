@extends('frontend.layouts.app')

@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Reset Password</div>
                    <h4 class="col-md-12 col-form-label ml-5">Your Phone no:{{$phone}} </h4>
                    <div class="card-body">
                      @if (Session::has('message'))
                           <div class="alert alert-success" role="alert">
                              {{ Session::get('message') }}
                          </div>
                      @endif                        
                        <form action="{{ route('otp.verify') }}" method="POST">
                            @csrf
                            <div class="form-group row">                 
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">Enter your OTP code</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="otp" maxlength="4" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <input type="text" class="form-control" value="{{$phone}}" name="phone" hidden readonly>

                            </div>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Verify
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
  </main>

@endsection
