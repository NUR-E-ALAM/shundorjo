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
            <div class="right-element">
                <div class="dropdown">
                    <a class="btn dropdown-toggle profile-manage" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(!empty(Auth::user()->avatar_original))
                        <img src="{{asset(Auth::user()->avatar_original)}}" alt="">
                        @else
                            <img src="{{asset('uploads/1.jpg')}}" alt="">
                        @endif
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('profile') }}"><span class="iconify"
                                data-icon="carbon:user-avatar"></span> Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"><span class="iconify"
                                data-icon="ion:log-out-outline"></span> Log Out</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-content">
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
                                <div class="form-box-title px-3 py-2">
                                    {{__('Change password')}}
                                </div>
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
    $(document).ready(function(){
        //header for csrf-token is must in laravel
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        //
        var url = "{{URL::to('/user/change-password/update')}}";
        //console.log(url);
        $(".pwdBtn").click(function(){
            //  alert('btn work');
            var password= $("#new_password").val();
            var confirmpassword= $("#confirm_password").val();
            var opassword= $("#current_password").val();
            var profileid= $("#profileid").val();

            // console.log(name +','+ email +','+ mobile+','+ address+','+ city+','+ postal_code+','+ profileid);

            $.ajax({
                    url:url,
                    method: "POST",
                    data:{
                        password:password,confirmpassword:confirmpassword,opassword:opassword
                    },
                    success: function(d){
                        if (d.status == 303) {
                            $(".ermsg").html(d.message);
                        }else if(d.status == 300){
                            $(".ermsg").html(d.message);
                                //   success("Data Updated Successfully!!");
                            window.setTimeout(function(){location.reload()},2000)
                        }
                    },
                    error:function(d){
                        console.log(d);
                    }
                });
        });



    });
  </script>
@endsection

