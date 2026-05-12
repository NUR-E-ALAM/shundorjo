@extends('frontend.layouts.app')

@section('title')
    Shundorjo | Skin Care, Health & Beauty Shop in Bangladesh,Best Ecommerce Platfrom for Online Shopping in Bangladesh
@stop
@section('css')

@endsection
@section('content')

<div class="card">
  <div class="card-body">
        <form method="POST" action="{{route('smsvarified')}}">
            @csrf

            <div class="form-group row">
            <h3 style="text-align:center;width:100%">Verificaton Code has sent to your Mobile No: {{$user->phone}}.</h3>
            <div id="display" style="margin: 0 auto; width:30%">
            </div>
            </div>
            <div class="form-group row">
                <label for="verification_code" class="col-md-4 col-form-label text-md-right">{{ __('Enter Verificaton Code') }}</label>

                <div class="col-md-6">

                    <input id="verification_code" type="text" class="form-control"  name="verification_code"required autocomplete="verification_code" value="{{ session('varificationOTP') }}" autofocus maxlength="4">


                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    {{-- <input type="hidden" name="password" value="{{ $password }}"> --}}
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Verify') }}
                    </button>
                </div>
            </div>
        </form>
        <br>
        <form action="{{route('resend.otp')}}" method="post" id="sendSmsResend">
            @csrf
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <input type="hidden" name="phone" value="{{ $user->phone}}">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <button type="submit" class="btn btn-primary float-right" style="margin-top: -58px;">
                        {{ __('Resend Again') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@section('script')
<script>

   function CountDown(duration, display) {
        // var phone = <?php echo ($user->phone); ?>;
        // var userId = <?php echo ($user->id); ?>;

            if (!isNaN(duration)) {
                var timer = duration, minutes, seconds;
                var interVal=  setInterval(function () {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);
                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;
                    $(display).html("<b>" + minutes + "m : " + seconds + "s" + "</b>");
                    if (--timer < 0) {
                        timer = duration;
                       $('#display').empty();
                       clearInterval(interVal);
                       resendSms();
                    }
                    },1000);
            }
        }
         CountDown(100,$('#display'));

         function resendSms(){
		$.ajax({
		   type:"POST",
		   url:'{{ route('resend.sms') }}',
		   data:$('#sendSmsResend').serialize(),
		   success: function(data){
			   $('#smsNew').html(data);
               CountDown(100,$('#display'));
		   }
	   });
	}

</script>


@endsection
