@extends('layouts.app')



@section('content')
        
        <div id="addThisFormContainer">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{__('Add Master Data')}}</h3>
                    </div>
            
                    <!--Horizontal Form-->
                    <!--===================================================-->
                    <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" id="createThisForm">
                        @csrf
                        <div class="panel-body">
                            <input type="hidden" id="codeid" name="codeid" value="">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="softcode">{{__('Softcode')}}</label>
                                <div class="col-sm-9">
                                    <select name="softcode" id="softcode" required class="form-control demo-select2-placeholder">
                                        @foreach($softcode as $item)
                                            <option value="{{$item->name}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="hardcode">{{__('Hardcode')}}</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="{{__('Hardcode')}}" id="hardcode" name="hardcode" class="form-control" required>
                                </div>
                            </div>

                            <!--<div class="form-group">-->
                            <!--    <label class="col-sm-3 control-label" for="image">{{__('Image')}}</label>-->
                            <!--    <div class="col-sm-9">-->
                            <!--        <input type="file" placeholder="{{__('Image')}}" id="image" name="image" class="form-control" required>-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!--<div class="form-group">-->
                            <!--    <label class="col-sm-3 control-label" for="details">{{__('Details')}}</label>-->
                            <!--    <div class="col-sm-9">-->
                            <!--        <textarea name="details" id="details" class="form-control" cols="30" rows="10" required></textarea>-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!--<div class="form-group">-->
                            <!--    <label class="col-sm-3 control-label" for="sort_details">{{__('Tag')}}</label>-->
                            <!--    <div class="col-sm-9">-->
                            <!--        <input type="text" placeholder="{{__('Tag')}}" id="sort_details" name="sort_details" class="form-control" required>-->
                            <!--    </div>-->
                            <!--</div>-->
                             
                        </div>
                        <div class="panel-footer text-right">
                            <input type="button" id="addBtn" value="Create" class="btn btn-primary">
                            <input type="button" id="FormCloseBtn" value="Close" class="btn btn-warning">
                        </div>
                    </form>
                    <!--===================================================-->
                    <!--End Horizontal Form-->
                </div>
            </div>
        </div>

        <!--<button id="newBtn" type="button" class="btn btn-info">Add New</button>-->
        <hr>

        <div id="contentContainer">

                        <!-- Basic Data Tables -->
            <!--===================================================-->
            <div class="card">
                {{-- <div class="panel-heading">
                    <h3>{{__('Master Details')}}</h3>
                </div> --}}
                <div class="card-body">
                    <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th>{{__('Sortcode')}}</th>
                                <th>{{__('Hardcode')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($masters as $key => $data)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$data->softcode}}</td>
                                    <td>{{$data->hardcode}}</td>
                                    <td>
                                        <a id="EditBtn" rid="{{$data->id}}"><i class="fa fa-edit" style="color: #2196f3;font-size:16px;"></i></a>
                                        <!--<a id="deleteBtn" rid="{{$data->id}}"><i class="fa fa-trash-o" style="color: red;font-size:16px;"></i></a>-->
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {

            $("#addThisFormContainer").hide();
            $("#newBtn").click(function(){
                clearform();
                $("#newBtn").hide(100);
                $("#addThisFormContainer").show(300);

            });
            $("#FormCloseBtn").click(function(){
                $("#addThisFormContainer").hide(200);
                $("#newBtn").show(100);
                clearform();
            });


            //header for csrf-token is must in laravel
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //

            var url = "{{URL::to('/admin/master')}}";
            // console.log(url);
            $("#addBtn").click(function(){
            //   alert("#addBtn");
                if($(this).val() == 'Create') {
                    // var file_data = $('#image').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append("softcode", $("#softcode").val());
                    form_data.append("hardcode", $("#hardcode").val());
                    // form_data.append('image', file_data);
                    // form_data.append("details", $("#details").val());
                    // form_data.append("sort_details", $("#sort_details").val());

                    $.ajax({
                      url: url,
                      method: "POST",
                      contentType: false,
                      processData: false,
                      data:form_data,
                      success: function (d) {
                          if (d.status == 303) {
                              $(".ermsg").html(d.message);
                          }else if(d.status == 300){
                            $(".ermsg").html(d.message);
                            //success("Master Data Insert Successfully!!");
                                window.setTimeout(function(){location.reload()},2000)
                          }
                      },
                      error: function (d) {
                          console.log(d);
                      }
                  });
                }
                //create  end
                //Update
                if($(this).val() == 'Update'){
                // alert('update btn work');
                //   var file_data = $('#image').prop('files')[0];
                //   if(typeof file_data === 'undefined'){
                //     file_data = 'null';
                //   }
                  var form_data = new FormData();
                  form_data.append("softcode", $("#softcode").val());
                  form_data.append("hardcode", $("#hardcode").val());
                //   form_data.append('image', file_data);
                //   form_data.append("details", $("#details").val());
                //   form_data.append("sort_details", $("#sort_details").val());
                  form_data.append('_method', 'put');

                    $.ajax({
                        url:url+'/'+$("#codeid").val(),
                        type: "POST",
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        data:form_data,
                        success: function(d){
                            console.log(d);
                            if (d.status == 303) {
                                $(".ermsg").html(d.message);
                                pagetop();
                            }else if(d.status == 300){
                                $(".ermsg").html(d.message);
                                //success("Master Data Update Successfully!!");
                                window.setTimeout(function(){location.reload()},2000)
                            }
                        },
                        error:function(d){
                            console.log(d);
                        }
                    });
                }
                //Update
            });
            //Edit
            $("#contentContainer").on('click','#EditBtn', function(){
                //alert("btn work");
                $codeid = $(this).attr('rid');
                //console.log($codeid);
                $info_url = url + '/'+$codeid+'/edit';
                //console.log($info_url);
                $.get($info_url,{},function(d){
                    populateForm(d);
                    //pagetop();
                });
            });
            //Edit  end

            //Delete
            $("#contentContainer").on('click','#deleteBtn', function(){
                if(!confirm('Sure?')) return;
                var masterid = $(this).attr('rid');
                var info_url = url + '/'+masterid;
                console.log(info_url);
                //alert(info_url);
                $.ajax({
                    url:info_url,
                    method: "DELETE",
                    type: "DELETE",
                    data:{
                    },
                    success: function(d){
                        if(d.success) {
                            alert(d.message);
                            location.reload();
                        }
                    },
                    error:function(d){
                        console.log(d);
                    }
                });
            });
            //Delete




            function populateForm(data){
                $("#softcode").val(data.softcode);
                $("#hardcode").val(data.hardcode);
                $("#details").val(data.details);
                $("#sort_details").val(data.sort_details);
                $("#codeid").val(data.id);
                $("#addBtn").val('Update');
                $("#addThisFormContainer").show(300);
                $("#newBtn").hide(100);
            }
            function clearform(){
                $('#createThisForm')[0].reset();
                $("#addBtn").val('Create');
            }
        });
        
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#codemaster").addClass('active');
            $("#codemaster").addClass('is-expanded');
            $("#master").addClass('active');
        });
    </script>
   <script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
   <script>
    // CKEDITOR.replace( 'details' );
    </script>
@endsection
