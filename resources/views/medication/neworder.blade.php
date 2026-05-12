@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="ermsg"></div>
        <a href="{{ route('medicationuser.create')}}" class="btn btn-info pull-right">{{__('add_new')}}</a>
    </div>
</div>

<br>
{{-- add prescription --}}

<div id="addprescription">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">{{__('Prescription Image')}}</h3>
                    <input type="text" name="pname" class="form-control">
                </div>

                <!--Horizontal Form-->
                <!--===================================================-->
                <form>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="logo">{{__('Image')}}</label>
                            <div class="col-sm-10">
                                <input type="file" id="prescription_image" name="prescription_image" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer text-right">
                        <input type="button" id="pimageBtn" value="Save" class="btn btn-purple">
                        {{-- <button class="btn btn-purple" id="pimageBtn" type="submit">{{__('Save')}}</button> --}}
                        {{-- <button class="btn btn-purple" id="pimageBtnClose">{{__('Close')}}</button> --}}
                    </div>
                </form>
                <!--===================================================-->
                <!--End Horizontal Form-->

            </div>
        </div>
    </div>

</div>

{{-- add prescription --}}
<br>
<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Users')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email Address')}}</th>
                    <th width="10%">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $userdata)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ ($userdata->name) }}</td>
                        <td>{{ ($userdata->email) }}</td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{ URL('admin/medication/createorder', encrypt($userdata->id))}}">{{__('Create order')}}</a></li>
                                    <li><a pid="{{$userdata->id}}" class="pformshow" id="pformshowBtn">{{__('Add Prescription')}}</a></li>
                                    <li><a id="showDetails">{{__('Show')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('customers.destroy', $userdata->id)}}');">{{__('Delete')}}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {

        $("#addprescription").hide();

        $(".pformshow").click(function(){
            $("#addprescription").show(300);
            $("#patientid").val($(this).attr('pid'));

        });
        $("#pimageBtnClose").click(function(){
            $("#addprescription").hide(300);

        });

        //header for csrf-token is must in laravel
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            //

            var url = "{{URL::to('/admin/medication/prescription/store')}}";
            // console.log(url);
            $("#pimageBtn").click(function(){
                    var file_data = $('#prescription_image').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('prescription_image', file_data);
                    form_data.append("patientid", $("#patientid").val());

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
                            // success("Data Insert Successfully!!");
                            window.setTimeout(function(){location.reload()},2000)
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
