@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Seller Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('newMedicationUser.update') }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name')}}</label>
                    <div class="col-sm-9">
                        {{-- <input type="text" placeholder="{{__('Name')}}" id="name" name="name" class="form-control" required> --}}
                        <select name="uid" id="" class="form-control select2">
                            <option value="">Select</option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}-{{$user->phone}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="text" name="status" value="Yes" hidden readonly>

                @if(Auth::user()->user_type=='admin')
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="email">{{__('Assign to Agent')}}</label>
                    <div class="col-sm-9">
                        <select name="provider_id" id="" class="form-control select2">
                            <option value="">Select</option>
                            @foreach ($agents as $agent)
                            <option value="{{$agent->id}}">{{$agent->name}} ({{$agent->user_type}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

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
