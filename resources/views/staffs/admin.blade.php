@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
     <a href="{{ route('admin.create') }}" class="btn btn-info pull-right">{{__('Add New Admin')}}</a>
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
                    <th>{{__('Phone')}}</th>
                    <th width="10%">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $customer)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>
                            <a href="{{ route('admin.edit', encrypt($customer->id))}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a onclick="confirm_modal('{{route('admin.destroy', $customer->id)}}');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
