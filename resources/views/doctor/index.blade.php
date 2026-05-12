@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('doctor.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Doctor')}}</a>
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Doctor')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($docs as $key => $doctor)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$doctor->name}}</td>
                        <td>{{$doctor->email}}</td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('doctor.edit', encrypt($doctor->id))}}">{{__('Edit')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('doctor.destroy', $doctor->id)}}');">{{__('Delete')}}</a></li>
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
