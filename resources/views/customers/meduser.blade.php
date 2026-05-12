@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
     <a href="{{ route('patient.create') }}" class="btn btn-info pull-right">{{__('Add New Patient')}}</a>
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Customers')}}</h3>
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
                @foreach($customers as $key => $customer)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    {{-- <li><a onclick="confirm_modal('{{route('customers.destroy', $customer->id)}}');">{{__('Delete')}}</a></li> --}}
                                    <li><a onclick="confirm_modal('{{ route('medcustomers.destroy', $customer->id) }}');">{{__('Delete')}}</a></li>
                                    {{-- <li><a id="deleteBtn" cid="{{ $customer->id }}">{{__('Delete')}}</a></li> --}}
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

    // $(document).ready(function(){
    //     //header for csrf-token is must in laravel
    //     $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    //     //
    //     var url = "{{URL::to('/customers/update')}}";
    //     //console.log(url);
    //     $("#deleteBtn").click(function(){
    //         //  alert('btn work');

    //         var cid= $(this).attr('cid');

    //         //console.log(cid);

    //         $.ajax({
    //                 url:url+'/'+$("#profileid").val(),
    //                 method: "PUT",
    //                 type: "PUT",
    //                 data:{
    //                     cid:cid
    //                 },
    //                 success: function(d){
    //                     if (d.status == 303) {
    //                         $(".ermsg").html(d.message);
    //                     }else if(d.status == 300){
    //                         $(".ermsg").html(d.message);
    //                         // window.setTimeout(function(){location.reload()},2000)
    //                     }
    //                 },
    //                 error:function(d){
    //                     console.log(d);
    //                 }
    //             });
    //     });
    // });
</script>

@endsection
