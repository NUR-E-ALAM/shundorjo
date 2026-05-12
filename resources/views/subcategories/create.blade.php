@extends('layouts.app')

@section('content')

<div class="col-lg-12">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Subcategory Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label" for="name">{{__('Name')}}</label>
                    <div class="col-sm-9 col-lg-10">
                        <input type="text" placeholder="{{__('Name')}}" id="name" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label" for="name">{{__('Category')}}</label>
                    <div class="col-sm-9 col-lg-10">
                        <select name="category_id" required class="form-control demo-select2-placeholder">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{__($category->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{__('Description')}}(Optional)</label>
                    <div class="col-lg-10">
                        <textarea class="editor" name="description"></textarea>
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
