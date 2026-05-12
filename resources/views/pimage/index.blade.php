@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
     {{-- <a href="{{ route('patient.create') }}" class="btn btn-info pull-right">{{__('Add New Patient')}}</a> --}}
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Prescription')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('User Name')}}</th>
                    <th>{{__('Message')}}</th>
                    <th>{{__('Prescription')}}</th>
                    <th>{{__('Mobile')}}</th>
                    <th width="10%">{{__('Action')}}</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($pimg as $key => $customer)

                    <tr>
                        <td>{{$key+1}}</td>
                        <td> @if ($customer->user_id)
                            {{\App\Models\User::where('id', '=', $customer->user_id)->first()->name}}
                        @else
                            
                        @endif </td>
                        <td>{{ $customer->patient_name }}</td>
                        <td><img src="{{asset('uploads/prescription/'.$customer->image)}}" height="50px" width="50px" alt=""> </td>
                        <td>
                            @if ($customer->user_id)
                            {{\App\Models\User::where('id', '=', $customer->user_id)->first()->phone}}
                        @else
                        {{ $customer->mobile }}
                        @endif
                        
                        </td>
                        
                        <td>
                            <a href="{{ route('customer.prescription.view', encrypt($customer->id))}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a onclick="confirm_modal('{{route('customer.prescription.destroy', $customer->id)}}');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
