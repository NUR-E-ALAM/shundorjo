@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('department.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Department')}}</a>
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Department')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('code')}}</th>
                    <th>{{__('status')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deps as $key => $dep)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$dep->dep_name}}</td>
                        <td>{{$dep->dep_code}}</td>
                        <td> @if ($dep->dep_status == 1)
                            Active
                        @else
                            Deactive
                        @endif </td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('department.edit', encrypt($dep->id))}}">{{__('Edit')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('department.destroy', $dep->id)}}');">{{__('Delete')}}</a></li>
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
