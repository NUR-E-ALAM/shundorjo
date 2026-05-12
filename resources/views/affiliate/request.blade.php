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
                    <th width="10%">{{__('Action')}}</th>
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
                        <td>
                            <form action="{{route('affiliate.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="user_id"  name="user_id" value="{{ $customer->user_id }}" >
                                <button type="submit" class="btn btn-sm btn-purple">
                                    Make Link
                                </button>       
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection

@section('script')
@endsection
