@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Department Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('department.update', $deps->id) }}" method="POST" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
        	@csrf
            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="dep_name">{{__('Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Name')}}" id="dep_name" name="dep_name" value="{{ $deps->dep_name }}" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="dep_code">{{__('Code')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Code')}}" id="dep_code" name="dep_code" value="{{ $deps->dep_code }}" class="form-control" required>
                    </div>
                </div>
                

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="dep_status">{{__('Status')}}</label>
                    <div class="col-sm-9">
                        <select name="dep_status" required class="form-control demo-select2-placeholder">
                            @if ($deps->dep_status == 1)
                            <option value="1" active>Active</option>
                            <option value="0">Deactive</option>
                            @else
                            <option value="0" active>Deactive</option>
                            <option value="1">Active</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
            </div>
        </form>
        <!--===================================================-->
        <!--End Horizontal Form-->

    </div>
</div>

@endsection
