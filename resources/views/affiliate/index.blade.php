@extends('layouts.app')

@section('content')


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
                    <th>{{__('Date')}}</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email Address')}}</th>
                    <th>{{__('Phone')}}</th>
                    <th>{{__('Medication')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($affiliate as $key => $customer)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $customer->created_at }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->medication }}</td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection

@section('script')
@endsection
