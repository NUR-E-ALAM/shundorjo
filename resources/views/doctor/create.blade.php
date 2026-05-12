@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Doctor Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('doctor.store') }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Name')}}" id="name" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="email">{{__('Email')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Email')}}" id="email" name="email" class="form-control" required>
                        
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
                        <input type="text" placeholder="{{__('Phone')}}" id="phone" name="phone" class="form-control" required>
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
                    <label class="control-label col-md-3">Designation</label>
                    <div class="col-md-9">
                      <input class="form-control" type="text" name="designation" id="degsignation" placeholder="Enter degsignation">
                    </div>
                  </div>

                <div class="form-group">
                  <label class="control-label col-md-3">Department</label>
                  <div class="col-md-9">
                    <select class="form-control" name="department[]" id="department" multiple required>
                      @foreach($department as $key => $dep)
                        <option value="{{$dep->id}}">{{$dep->dep_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Gender</label>
                    <div class="col-md-9">
                      <select class="form-control" name="gender" id="gender">
                        <option value="">Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Date Of Birth</label>
                    <div class="col-md-9">
                      <input class="form-control" type="date" name="dob" id="dob" placeholder="Enter last name" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Education</label>
                    <div class="col-md-9">
                      <textarea class="form-control" rows="4" name="education" id="education" placeholder="Education"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Address</label>
                    <div class="col-md-9">
                      <textarea class="form-control" rows="2" cols="2" id="address" name="address" placeholder="address"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="city">{{__('City')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('City')}}" id="city" name="city" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="postal_code">{{__('Post Code')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Post Code')}}" id="postal_code" name="postal_code" class="form-control" required>
                    </div>
                </div>


            </div>
            <div class="panel-footer text-right">
                <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
            </div>
        </form>
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