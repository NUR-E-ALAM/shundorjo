@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('feature-brands.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Feature Brand')}}</a>
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Feature Brands')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Image')}}</th>
                    <th>{{__('Brand')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feature_brand as $key => $brand)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$brand->title}}</td>
                        <td><img class="img-md" src="{{ asset($brand->image) }}" alt="Logo"></td>
                        <td>{{ isset($brand->brand)?$brand->brand->name:'' }}</td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('feature-brands.edit', encrypt($brand->id))}}">{{__('Edit')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('feature.brands.destroy', $brand->id)}}');">{{__('Delete')}}</a></li>
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
