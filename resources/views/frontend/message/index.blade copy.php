@extends('frontend.layouts.app')
@section('css')
<link type="text/css" href="{{ asset('frontend/css/chat.css') }}" rel="stylesheet">
@endsection
@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if(Auth::user()->user_type == 'seller')
                        @include('frontend.inc.seller_side_nav')
                    @elseif(Auth::user()->user_type == 'customer')
                        @include('frontend.inc.customer_side_nav')
                    @elseif(Auth::user()->user_type == 'doctor')
                        @include('frontend.inc.doctor_side_nav')
                    @endif
                </div>
                <div class="col-lg-9">

                    {{-- new section  --}}
                    <div class="container-fluid h-100">
                        <div class="row justify-content-center h-100">

                            <div class="col-md-12 col-xl-12 chat">
                                <div class="card">
                                    <div class="card-header msg_head">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="{{asset(Auth::user()->avatar_original)}}" class="rounded-circle user_img">
                                                <span class="online_icon"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>{{Auth::user()->name}}</span>
                                                <p>{{\App\Models\Message::where('user_id', '=', Auth::user()->id)->orWhere('patient_id','=', Auth::user()->id)->count('id')}} Messages</p>
                                            </div>
                                            {{-- <div class="video_cam">
                                                <span><i class="fa fa-video"></i></span>
                                                <span><i class="fa fa-phone"></i></span>
                                            </div> --}}
                                        </div>
                                        {{-- <span id="action_menu_btn"><i class="fa fa-ellipsis-v"></i></span> --}}
                                        {{-- <div class="action_menu">
                                            <ul>
                                                <li><i class="fa fa-user-circle"></i> View profile</li>
                                                <li><i class="fa fa-users"></i> Add to close friends</li>
                                                <li><i class="fa fa-plus"></i> Add to group</li>
                                                <li><i class="fa fa-ban"></i> Block</li>
                                            </ul>
                                        </div> --}}
                                    </div>




                                    <div class="card-body msg_card_body">
                                        @foreach ($msg as $data)

                                      @if ($data->user_id===Auth::user()->id && $data->patient_id===NULL)
                                      <div class="d-flex justify-content-end mb-4">
                                        <div class="msg_cotainer_send">
                                            {{ $data->sms }}
                                        <span class="msg_time_send">{{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }}</span>
                                        </div>
                                        <div class="img_cont_msg">
                                            <img src="{{asset(Auth::user()->avatar_original)}}" class="rounded-circle user_img_msg">
                                        </div>
                                    </div>
                                    @else
                                    <div class="d-flex justify-content-start mb-4">
                                        <div class="img_cont_msg">
                                            <img src="{{asset('images/'.\App\Models\User::where('id', $data->patient_id)->first()->avatar_original)}}" class="rounded-circle user_img_msg">
                                        </div>
                                        <div class="msg_cotainer">

                                            {{ $data->sms }}
                                            <span class="msg_time">{{ Carbon\Carbon::parse($data->created_at)->diffForHumans()}}</span>
                                        </div>
                                    </div>
                                      @endif
                                        @endforeach
                                    </div>



                                    <div class="card-footer">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text attach_btn"><i class="fa fa-paperclip"></i></span>
                                            </div>
                                            <textarea name="usermessage" class="form-control type_msg" id="usermessage" placeholder="Type your message..."></textarea>
                                            <div class="input-group-append">
                                                <span class="input-group-text send_btn"><i class="fa fa-location-arrow"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- new section  --}}

                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')


<script>
    $(document).ready(function(){
    $('#action_menu_btn').click(function(){
        $('.action_menu').toggle();
    });
        });

</script>

<script>
    $(document).ready(function () {

        // header for csrf-token is must in laravel
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //

            var url = "{{URL::to('/message/store')}}";
            // console.log(url);
            $(".send_btn").click(function(){
                //alert("btn work");
                    var form_data = new FormData();
                    form_data.append("usermessage", $("#usermessage").val());
                    // console.log(usermessage);
                    $.ajax({
                      url: url,
                      method: "POST",
                      contentType: false,
                      processData: false,
                      data:form_data,
                      success: function (d) {
                          if (d.status == 303) {
                            //   $(".ermsg").html(d.message);
                          }else if(d.status == 300){
                            // $(".ermsg").html(d.message);
                            // success("Data Insert Successfully!!");
                                window.setTimeout(function(){location.reload()},50)
                          }
                      },
                      error: function (d) {
                          console.log(d);
                      }
                  });
                //create  end
            });
});
</script>

@endsection
