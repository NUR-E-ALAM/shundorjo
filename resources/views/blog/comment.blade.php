@extends('layouts.app')

@section('content')

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Comment')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Comments')}}</th>
                    <th width="10%">{{__('Status')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comment as $key => $comments)
                    <tr>
                        <td>{{$comments->name}}</td>
                        <td>{{$comments->email}}</td>
                        <td>
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                  <div class="">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" data-parent="#accordion" href="#{{$comments->id}}">
                                        @php
                                        $string = strip_tags($comments->comments);
                                        if (strlen($string) > 50) {
                                            // truncate string
                                            $stringCut = substr($string, 0, 50);
                                            $endPoint = strrpos($stringCut, ' ');
                                            //if the string doesn't contain any space then it will cut without word basis.
                                            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                            $string .= '... Read More';
                                        }
                                        echo $string;
                                        @endphp
                                      </a>
                                    </h4>
                                  </div>
                                  <div id="{{$comments->id}}" class="panel-collapse collapse out">
                                    <div class="panel-body">{{$comments->comments}}</div>
                                  </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="toggle-flip">
                            <label>
                                <input type="checkbox" class="toggle-class" data-id="{{$comments->id}}" {{ $comments->status ? 'checked' : '' }}><span class="flip-indecator" data-toggle-on="Active" data-toggle-off="Inactive"></span>
                            </label>
                            </div>
                        </td>
                        <td>
                            <a onclick="confirm_modal('{{route('comment.delete', $comments->id)}}');"><i class="fa fa-trash" style="color: red;font-size:16px;" aria-hidden="true"></i></a>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection

@section('name')
    
<script>
    $(function() {
      $('.toggle-class').change(function() {
          alert("toggle class work");
        var url = "{{URL::to('/admin/comment-status')}}";
          var status = $(this).prop('checked') == true ? 1 : 0;
          var id = $(this).data('id');
           console.log(status);
          $.ajax({
              type: "GET",
              dataType: "json",
              url: url,
              data: {'status': status, 'id': id},
              success: function(d){
                // console.log(data.success)
                if (d.status == 303) {
                                $(".ermsg").html(d.message);
                            }else if(d.status == 300){
                                $(".ermsg").html(d.message);
                                // window.setTimeout(function(){location.reload()},2000)
                            }
                        },
                        error: function (d) {
                            console.log(d);
                        }
          });
      })
    })
  </script>
 <script type="text/javascript" src="{{asset('js/bootstrap-notify.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('js/sweetalert.min.js')}}"></script>
@endsection
