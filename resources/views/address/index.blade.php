@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('shippingaddress.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add Shipping Address')}}</a>
        </div>
    </div>

    <br>

    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Shipping Address')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th>{{__('City')}}</th>
                        <th>{{__('Area')}}</th>
                        <th>{{__('Price')}}</th>
                        <th width="10%">{{__('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($upazilas as $key => $link)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ \App\Models\District::where('id','=', $link->district_id)->first()->name }}</td>
                            <td>{{$link->name}}</td>
                            <td>{{$link->shipping_cost}}</td>
                            
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{route('shippingaddress.edit', encrypt($link->id))}}">{{__('Edit')}}</a></li>
                                        {{-- <li><a onclick="confirm_modal('{{route('shippingaddress.delete', $link->id)}}');">{{__('Delete')}}</a></li> --}}
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
    
@endsection
