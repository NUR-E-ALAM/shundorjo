@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Email Templete')}}</h3>
        </div>
        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('emailtemplete.store') }}" method="POST">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="templete">{{__('Templete')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Templete')}}" id="templete" name="templete" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="description">{{__('Description')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="description" id="description" class="editor" placeholder="Type your Email templete">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="description">{{__('Footer')}}</label>
                    <div class="col-sm-9">
                        <input type="text" name="footer" id="footer" class="editor" placeholder="Type your Footer Note">
                    </div>
                </div>

            </div>
            <div class="panel-footer text-right">
                <button type="submit" name="register" id="register" class="btn btn-info btn-lg">{{__('Save Templete')}}</button>
            </div>
        </form>

        <!--===================================================-->
        <!--End Horizontal Form-->

    </div>
</div>

@endsection

@section('script')

@endsection
