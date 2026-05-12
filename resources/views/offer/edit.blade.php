@extends('layouts.app')

@section('content')
<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Special Offer')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('special-offer.update',$link->id) }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <input type="hidden" name="_method" value="PATCH">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="title">{{__('Title')}}</label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ $link->title }}" id="title" name="title" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="tamount">{{__('Title Amount')}}</label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ $link->tamount }}" id="tamount" name="tamount" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="upto">{{__('Upto')}}</label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ $link->upto }}" id="upto" name="upto" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="uamount">{{__('Upto Amount')}}</label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ $link->uamount }}" id="uamount" name="uamount" class="form-control" required>
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
