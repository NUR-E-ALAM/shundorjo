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
            <h3 class="panel-title">{{__('Patient Information')}}</h3>
        </div>
        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('patient.store') }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Name')}}" id="name" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="email">{{__('Email Address')}}</label>
                    <div class="col-sm-9">
                        {{--  <input type="text" placeholder="{{__('Email Address')}}" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        <span id="error_email"></span>  --}}

                        <input type="text" name="email" id="email" class="form-control" placeholder="Email">
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
                {{-- <div class="form-group">
                    <label class="col-sm-3 control-label" for="password">{{__('Password')}}</label>
                    <div class="col-sm-9">
                        <input type="password" placeholder="{{__('Password')}}" id="password" name="password" class="form-control" required>
                    </div>
                </div> --}}
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="phone">{{__('Phone')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Phone No')}}" id="phone" name="phone" class="form-control" required>
                        
                    <span id="error_phone"></span>
                    </div>
                    @error('phone')
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('phone') }}</strong>
                            <strong>{{ $message }}</strong>
                            {{-- <strong>{{ $validator->messages() }}</strong> --}}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="dob">{{__('Date Of Birth')}}</label>
                    <div class="col-sm-9">
                        <input type="date" id="dob" name="dob" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="address">{{__('Address')}}</label>
                    <div class="col-sm-9">
                        <textarea name="address" id="address" cols="20" rows="20" placeholder="type full address"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="region">{{__('Region')}}</label>
                    <div class="col-sm-9">
                        <select class="form-control mb-3" data-placeholder="Select your region" id="division" name="region" required>
                            <option value="">---select Region---</option>
                            @foreach ($region as $division)
                                <option value="{{ $division->id }}" >{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="city">{{__('City')}}</label>
                    <div class="col-sm-9">
                        <select class="form-control mb-3" data-placeholder="Select your City" id="district" name="city" required>
                            <option>---Select City---</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="area">{{__('Area')}}</label>
                    <div class="col-sm-9">
                        <select class="form-control mb-3" data-placeholder="Select your Area" id="upazila" name="area" required>
                            <option>---Select Area---</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="shipping">{{__('Shipping Cost')}}</label>
                    <div class="col-sm-9">
                        <select class="form-control mb-3" data-placeholder="Select shipping Cost " id="shipping" name="shipping_cost" required>
                            <option>---Shipping Cost---</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="post_code">{{__('Post Code')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="postal code" maxlength="4" required>
                    </div>
                </div>
                <input type="text" name="medication" value="No" hidden readonly>
             
               
            </div>
            <div class="panel-footer text-right">
                {{--  <button class="btn btn-purple" id="register" type="submit">{{__('Save')}}</button>  --}}
                <button type="submit" name="register" id="register" class="btn btn-info btn-lg">{{__('Save Patient')}}</button>
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
        url: "{{url('/admin/district-by-division')}}",
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
        url: "{{url('/admin/thana-by-district')}}",
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
        url: "{{url('/admin/ship-by-thana')}}",
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
        url: "{{url('/admin/ship-by-thana')}}",
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