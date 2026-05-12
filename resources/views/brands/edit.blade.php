@extends('layouts.app')

@section('content')

<div class="col-lg-12 col-lg-offset-0">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Brand Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">{{__('Name')}}</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="{{__('Name')}}" id="name" name="name" class="form-control" required value="{{$brand->name}}">
                    </div>
                </div>
                    <div class="form-group">
                    <label class="col-lg-2 control-label">{{__('Description')}}(Optional)</label>
                    <div class="col-lg-10">
                        <textarea class="editor" name="description">{{@$brand->description}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="logo">{{__('Logo')}} <small>(120x80)</small></label>
                    <div class="col-sm-4">
                        <input type="file" id="logo" name="logo" class="form-control">
                    </div>
                     <label class="col-sm-2 control-label" for="logo">{{__('Banner')}}</label>
                    <div class="col-sm-4">
                        <input type="file" id="banner" name="banner" class="form-control">
                    </div>
                </div>
            

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="logo">{{__('Featured')}}</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="featured" id="">
                            <option value="">Select .....</option>
                            @if ($brand->featured == 1)
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                            @else
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
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
