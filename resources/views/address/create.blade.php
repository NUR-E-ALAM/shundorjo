@extends('layouts.app')

@section('content')
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Shipping Address')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('shippingaddress.store') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="panel-body">
                    {{-- <div class="form-group">
                        <label class="col-sm-3 control-label" for="title">{{__('Title')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{__('Title')}}" id="title" name="title" class="form-control" required>
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="city">{{__('City')}}</label>
                        <div class="col-sm-9">
                            <select id="city" name="city" class="form-control">
                                <option value="">---Select Region---</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" >{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="area">{{__('Area')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{__('Area')}}" id="area" name="area" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="shipping_cost">{{__('Shipping Cost')}}</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{__('Shipping Cost')}}" id="shipping_cost" name="shipping_cost" class="form-control" required>
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

@section('script')

@endsection

