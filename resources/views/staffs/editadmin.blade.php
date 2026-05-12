@extends('layouts.app')

@section('content')
<style type="text/css">
    .box{
     width:600px;
     margin:0 auto;
     border:1px solid #ccc;
    }
    .has-error
    {
     border-color:#cc0000;
     background-color:#ffff99;
    }
   </style>
<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Admin Information')}}</h3>
        </div>
        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('admin.update', $users->id) }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Name')}}" id="name" name="name" class="form-control" value="{{ $users->name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="email">{{__('Email Address')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="email" id="email" value="{{ $users->email }}" class="form-control" placeholder="Email">
                        <span id="error_email"></span>
                    </div>
                    @error('email')
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="phone">{{__('Phone')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Phone No')}}" id="phone" name="phone"  value="{{ $users->phone }}" class="form-control">
                        
                    <span id="error_phone"></span>
                    </div>
                    @error('phone')
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('phone') }}</strong>
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="password">{{__('Password')}}</label>
                    <div class="col-sm-9">
                        <input type="password" placeholder="{{__('Password')}}" id="password" name="password" class="form-control">
                    </div>
                </div>
                
            </div>
            <div class="panel-footer text-right">
                <button type="submit" name="register" id="register" class="btn btn-info btn-lg">{{__('Update')}}</button>
            </div>
        </form>
        {{ csrf_field() }}
        <!--===================================================-->
        <!--End Horizontal Form-->

    </div>
</div>

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
              $('#register').attr('disabled', false);
             }
             else
             {
              $('#error_email').html('<label class="text-danger">Already have a Account</label>');
              $('#email').addClass('has-error');
              $('#register').attr('disabled', 'disabled');
             }
            }
           });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#phone').keyup(function(){
          var error_phone = '';
          var phone = $('#phone').val();
          var _token = $('input[name="_token"]').val();
      var filter = /^([0-9\s\-\+\(\)]*)$/;
      if(!filter.test(phone))
      {
        $('#error_phone').html('<label class="text-danger">Invalid Phone Number</label>');
        $('#phone').addClass('has-error');
        $('#register').attr('disabled', 'disabled');
      } else if (phone.length > 11){
        $('#error_phone').html('<label class="text-danger">Invalid Phone Number</label>');
        $('#phone').addClass('has-error');
        $('#register').attr('disabled', 'disabled');
      } else {
           $.ajax({
            url:"{{ route('phone_available.check') }}",
            method:"POST",
            data:{phone:phone, _token:_token},
            success:function(result)
            {
             if(result == 'unique')
             {
              $('#error_phone').html('<label class="text-success">Phone Available</label>');
              $('#phone').removeClass('has-error');
              $('#register').attr('disabled', false);
             }
             else
             {
              $('#error_phone').html('<label class="text-danger">Already have a Account</label>');
              $('#phone').addClass('has-error');
              $('#register').attr('disabled', 'disabled');
             }
            }
           })
      }
         });
    
        });
        </script>
@endsection