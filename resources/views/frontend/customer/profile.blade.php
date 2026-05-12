@extends('frontend.layouts.app')

@section('content')
<div class="dashbaord-main">
    @if(Auth::user()->user_type == 'seller')
        @include('frontend.inc.seller_side_nav')
    @elseif(Auth::user()->user_type == 'customer')
        @include('frontend.inc.customer_side_nav')
    @elseif(Auth::user()->user_type == 'doctor')
        @include('frontend.inc.doctor_side_nav')
    @endif
    <div class="rightSection">
        <div class="topbar">
            <div class="fold" onclick='foldSidebar();'>
                <span class="iconify" data-icon="eva:menu-fill"></span>
            </div>
            <!-- <img src="images/logo.png" class="mobile-menu-logo"> -->
            <!--<div class="right-element">-->
            <!--    <div class="dropdown">-->
            <!--        <a class="btn dropdown-toggle profile-manage" href="#" role="button" id="dropdownMenuLink"-->
            <!--            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
            <!--            @if(!empty(Auth::user()->avatar_original))-->
            <!--            <img src="{{asset(Auth::user()->avatar_original)}}" alt="">-->
            <!--            @else-->
            <!--                <img src="{{asset('uploads/1.jpg')}}" alt="">-->
            <!--            @endif-->
            <!--        </a>-->

            <!--        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">-->
            <!--            <a class="dropdown-item" href="{{ route('profile') }}"><span class="iconify"-->
            <!--                    data-icon="carbon:user-avatar"></span> Profile</a>-->
            <!--            <a class="dropdown-item" href="{{ route('logout') }}"><span class="iconify"-->
            <!--                    data-icon="ion:log-out-outline"></span> Log Out</a>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

        </div>
        <div class="dashboard-content">

            <section class="profile">
                <div class="title-section">
                    <span class="iconify mr-1" data-icon="icomoon-free:profile"></span> Profile
                </div>
                <div class="infoBox mt-3">
                    <div class="row col-lg-12 mx-auto">
                        <div class="col-lg-11 mx-auto">
                            <form class="form-custom mt-4" action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row shadow-sm">
                                    <div class="col-lg-4 col-md-6 bg-white border-right">
                                            <div class="form-container ">
                                                <div class="form-group addProfile ">
                                                    @if(!empty(Auth::user()->avatar_original))
                                                    <img src="{{asset(Auth::user()->avatar_original)}}" height="100px" alt="">
                                                    @else
                                                        <img src="{{asset('uploads/1.jpg')}}" alt="">
                                                    @endif
                                                    <input type="file" name="photo" id="file-3" class="profile-upload" accept="image/*" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Name </label>
                                                    <input type="text" class="form-control" placeholder="{{__('Enter Name here')}}" name="name" value="{{ Auth::user()->name }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" placeholder="{{__('Your Email')}}" name="email" id="email" value="{{ Auth::user()->email }}" @if(!empty(Auth::user()->email)) readonly @endif>
                                                    <span id="error_email"></span>
                                                    @error('email')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                            <strong>{{ $message }}</strong>
                                                            {{-- <strong>{{ $validator->messages() }}</strong> --}}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-lg-8 col-md-6 bg-white">
                                        <div class="form-container">
                                            <div class="form-group">
                                                <label>Phone </label>
                                                <input type="text" class="form-control" placeholder="Enter Phone" name="phone" value="{{ Auth::user()->phone }}" @if(!empty(Auth::user()->phone)) readonly @endif>
                                            </div>
                                            <div class="form-group">
                                                <label>Address </label>
                                                <input type="text" class="form-control" placeholder="Enter Address" name="address" value="{{ Auth::user()->address }}">
                                            </div>
                                      
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Region</label>
                                                {{-- <input type="text" class="form-control" placeholder="Region" name="country" value="{{ Auth::user()->region }}"> --}}
                                                <select class="form-control" data-placeholder="Select your region" id="division" name="region" required>
                                                    <option value="">---select Region---</option>
                                                    @foreach ($region as $division)
                                                        <option value="{{ $division->id }}" @if(Auth::user()->region==$division->id) selected @endif >{{ $division->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>City</label>
                                                {{-- <input type="text" class="form-control" placeholder="Your City" name="city" value="{{ Auth::user()->city }}"> --}}
                                                <select class="form-control" data-placeholder="Select your City" id="district" name="city" required>
                                                    @foreach ($districts as $districts)
                                                        <option value="{{ $districts->id }}" @if($districts->id==Auth::user()->city) selected @endif>{{ $districts->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                            <div class="form-row">
                                                <div class="form-group">
                                                    <label>Area</label>
                                                    {{-- <input type="text" class="form-control" placeholder="Your Postal Code" name="postal_code" value="{{ Auth::user()->postal_code }}"> --}}
                                                    <select class="form-control" data-placeholder="Select your Area" id="upazila" name="area" required>
                                                        @foreach ($upazilas as $upazilas)
                                                        <option value="{{ $upazilas->id }}" @if($upazilas->id==Auth::user()->area) selected @endif>{{ $upazilas->name }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Post Code</label>
                                                    <input type="text" class="form-control" placeholder="Your Post code" name="postal_code" maxlength="4" value="{{ Auth::user()->postal_code }}">
                                                </div>
                                            </div>

                                            <select class="form-control" data-placeholder="Select shipping Cost " id="paid" name="shipping_cost" hidden readonly >
                                                <option value="{{ Auth::user()->shipping_cost }}">{{ Auth::user()->shipping_cost }}</option>
                                            </select>

                                            <button type="submit" class="text-white btn-theme float-right mb-3">Update Profile
                                        </button>

                                        </div>
                                    </div>
                                    
                                </div>
                            </form>
                            
                        </div>
                        
                    </div>
                </div>

            </section>
            
            <section class="profile">
                <div class="title-section">
                    <span class="iconify mr-1" data-icon="icomoon-free:profile"></span> Change Password
                </div>

                <div class="infoBox mt-3">
                    <div class="row col-lg-12 mx-auto">
                        <div class="col-lg-11 mx-auto">
                            <form class="form-custom mt-4"  action="{{ route('changepassword.update') }}" method="POST">
                                @csrf
                            <div class="row shadow-sm">
                                <div class="col-lg-4 col-md-6 bg-white border-right">
                                        <div class="form-container text-center ">
                                          <img class="img-fluid img25" src="{{asset('frontend/images/images/password.svg')}}" alt="">
                                        </div>
                                </div>
                                <div class="col-lg-8 col-md-6 bg-white">
                                {{-- new  --}}
                               
                                <div class="ermsg" id="ermsg"></div>
                                {{-- new  --}}
                                       <div class="form-container pt-5">
                                        <div class="form-group">
                                            <label>Current Password </label>
                                            <input type="password" class="form-control" placeholder="Current Password " name="current_password" id="current_password">
                                            <input type="hidden" name="profileid" id="profileid" value="{{Auth::user()->id}}">
                                        </div>
                                       <div class="form-row">
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" class="form-control" placeholder="New Password " name="new_password" id="new_password">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" class="form-control" placeholder="Confirm Password " name="confirm_password" id="confirm_password">
                                        </div>
                                       </div>
                                        <button type="submit" class="text-white btn-theme float-right mb-3">Update Password
                                    </button>

                                       </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

            </section>
        </div>
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
    $("body").delegate("#upazila","change",function(e){
    // $("#upazila").on('change',function(e){
      e.preventDefault();
      var ddlship=$("#paid");
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
              }).appendTo('#paid');
              
            });           
          }
  
        });
    });
  
  </script>
  
@endsection
