@extends('layouts.app')
@section('css')
<link rel='stylesheet' type='text/css' href="{{ asset('frontend/css/message.css')}}" />
@section('content')

<div class="container">
    {{-- <h3 class=" text-center">Messaging</h3> --}}
    <div class="messaging">
          <div class="inbox_msg">
            <div class="inbox_people">
              <div class="headind_srch">
                {{-- <div class="recent_heading">
                  <h4>Recent</h4>
                </div> --}}
                {{-- <div class="srch_bar">
                  <div class="stylish-input-group">
                    <input type="text" class="search-bar"  placeholder="Search" >
                    <span class="input-group-addon">
                    <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                    </span> </div>
                </div> --}}
              </div>
              <div class="inbox_chat">
                @foreach ($messages as $item)
                  <a href="{{route('admin.usermessage.show', encrypt(@$item->user_id))}}">
                    <div id="mssg">
                      <div class="chat_list">
                        <div class="chat_people">
                          <div class="chat_img"> <img src="{{ asset(optional(\App\Models\User::find($item->user_id))->avatar_original ?? 'uploads/default.png') }}" alt="image"> </div>
                          <div class="chat_ib">
                            <h5>{{ \App\Models\User::where('id', $item->user_id)->first()?->name ?? 'Guest User' }}<span class="chat_date">{{ Carbon\Carbon::parse(\App\Models\Message::where('user_id', $item->user_id)->orderBy('id', 'DESC')->limit(1)->first()->created_at)->diffForHumans()}}</span></h5>
                            <p>
                              @php
                               $msgby = \App\Models\Message::where('user_id', $item->user_id)->orderBy('id', 'DESC')->limit(1)->first()->patient_id;
                               if($msgby == null){
                                echo"User :";
                               }else{
                                echo"Admin :";
                               }
                              @endphp
                              {{\App\Models\Message::where('user_id', $item->user_id)->orderBy('id', 'DESC')->limit(1)->first()->sms}}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                </a>

                @endforeach
              </div>
            </div>

            <div id="msgdetails">
              <div class="mesgs">
                <div class="msg_history">

                  @foreach ($usermsg as $data)
                  @if($data->patient_id===Auth::user()->id)
                  <div class="outgoing_msg">
                    <div class="sent_msg">
                      <p>{{$data->sms}}</p>
                      <span class="time_date">{{ Carbon\Carbon::parse($data->created_at)->diffForHumans()}}</span> </div>
                  </div>
                  @endif

                  @if($data->patient_id==NULL)
                    <div class="incoming_msg">
                      <div class="incoming_msg_img"> <img src="{{ asset(optional(\App\Models\User::find($item->user_id))->avatar_original ?? 'uploads/default.png') }}" alt="image"> </div>
                      <div class="received_msg">
                        <div class="received_withd_msg">
                          <input type="hidden" id="msguserid" name="msguserid" value="{{$data->user_id}}" />
                          <p>{{$data->sms}}</p>
                          <span class="time_date"> {{ Carbon\Carbon::parse($data->created_at)->diffForHumans()}}</span></div>
                      </div>
                    </div>
                    @endif
                  @endforeach

                </div>
                <div class="type_msg">
                  <div class="input_msg_write">
                    <input type="text" class="write_msg" id="usermessage" placeholder="Type a message" />
                    <button class="msg_send_btn send_btn" id="send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                  </div>
                </div>
              </div>

            </div>


          </div>


        </div></div>

@endsection


@section('script')
<script>
  $(document).ready(function () {

      //header for csrf-token is must in laravel
      $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
          //

          var url = "{{URL::to('/admin/message/store')}}";
          // console.log(url);
          $(".send_btn").click(function(){
              // alert("btn work");
                  var form_data = new FormData();
                  form_data.append("usermessage", $("#usermessage").val());
                  form_data.append("msguserid", $("#msguserid").val());
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
