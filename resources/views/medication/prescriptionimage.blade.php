@extends('layouts.app')
@section('css')
<style>
    div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 250px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: 300px;
}

div.desc {
  padding: 15px;
  text-align: center;
}
</style>
@endsection
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="ermsg"></div>
        <a id="addpBtn" class="btn btn-info pull-right">{{__('Add New Prescription')}}</a>
    </div>
</div>

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
                                <input type="hidden" id="patientid" name="patientid" value="{{$userid}}" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer text-right">
                        <input type="button" id="pimageBtn" value="Save" class="btn btn-purple">
                        <input type="button" id="pimagecloseBtn" value="Close" class="btn btn-warning">
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
        <h3 class="panel-title">{{__('Users prescription image')}}</h3>
    </div>
    <div class="panel-body">

        {{-- <img src="{{asset('prescriptions/'.$item->image)}}" class="rounded float-left" alt=""> --}}



            @foreach ($prescriptions as $item)

                <div class="gallery">
                    <a target="_blank" href="{{asset('prescriptions/'.$item->image)}}">
                      <img src="{{asset('prescriptions/'.$item->image)}}" width="600" height="400" alt="Cinque Terre">
                    </a>
                    {{-- <div class="desc">Add a description of the image here</div> --}}
                  </div>

            @endforeach


    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {

        $("#addprescription").hide();

        $("#addpBtn").click(function(){
            $("#addprescription").show(300);
            // $("#patientid").val($(this).attr('pid'));

        });
        $("#pimagecloseBtn").click(function(){
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
