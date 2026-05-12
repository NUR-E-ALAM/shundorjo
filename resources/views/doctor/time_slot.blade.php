@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('time.slot.form')}}" class="btn btn-rounded btn-info pull-right">{{__('Add Time Slot')}}</a>
    </div>
</div>
<br>
{{-- content here  --}}
{{-- index here  --}}

@if($fromshow == 'Create')
<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Time Slot Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('time.slot.add') }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="slot">{{__('Time')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('10:00')}}" id="slot" name="slot" class="form-control" required>
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
@endif

{{-- edite here --}}
@if($fromshow == 'Edit')
<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Time Slot Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('time.slot.update', encrypt($slot->id)) }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="slot">{{__('Time')}}</label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ $slot->slot }}" id="slot" name="slot" class="form-control" required>
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
@endif

{{-- data show  here --}}

@if($fromshow == 'Showdata')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Doctor Time Slot')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>{{__('Slot')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($slot as $key => $doctor)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$doctor->slot}}</td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('time.slot.edit', encrypt($doctor->id))}}">{{__('Edit')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('time.slot.delete', $doctor->id)}}');">{{__('Delete')}}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endif
@endsection
