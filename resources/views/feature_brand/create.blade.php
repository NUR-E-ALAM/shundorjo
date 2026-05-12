@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Feature Brand Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('feature-brands.store') }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">{{__('Title')}}</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="{{__('Title')}}" id="title" name="title" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="logo">{{__('Image')}}</label>
                    <div class="col-sm-10">
                        <input type="file" id="image" name="image" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="logo">{{__('Description')}}</label>
                    <div class="col-sm-10">
                        <textarea id="description" name="description" rows="10" cols="10" class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="logo">{{__('Feature Brand')}}</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="brand_id" id="brand_id">
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
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
