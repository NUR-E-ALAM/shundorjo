@extends('layouts.app')

@section('content')

   <div class="row">
    <div class="col-sm-12">
                            <a class="btn btn-info" href="{{route('admin-blog-create')}}">
                          <i class="fa fa-plus"></i> {{ __('Add New Post') }}
                          </a>

    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Brands')}}</h3>
    </div>
    <div class="panel-body">
        <table id="blogTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                                    <tr>
                                        <th>{{ __('SL NO') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th width="40%">{{ __('Post Title') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Product Category') }}</th>
                                        <th>{{ __('Images') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
            <tbody>
                                    @foreach ($data as $value)
<tr>
    <td>{{$value->id}}</td>
    <td>{{$value->category->name}}</td>
    <td>{{$value->title}}</td>
    <td>{!! '<p>' . Str::limit(strip_tags($value->details, '<p>'), 100) . '</p>' !!}</td>
    <td>{{$value->pcategory->name}}</td>
    <td><img class="img-md" src="{{ asset($value->photo)}}" alt="Image"></td>
    <td><a href="{{route('admin-blog-edit', encrypt($value->id))}}"><i class="fa fa-pencil-square-o" style="font-size:26px; color:blue;"></i></a> <a onclick="confirm_modal('{{route('admin-blog-delete', encrypt($value->id))}}');"><i class="fa fa-trash-o" style="font-size:26px; color:red;"></i></a></td>
</tr>
                                    @endforeach
                                </tbody>
        </table>
{{-- <div class="text-center">
                                {{ $data->links() }}
                            </div> --}}
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        // Destroy previous DataTable if exists
        if ($.fn.DataTable.isDataTable('#blogTable')) {
            $('#blogTable').DataTable().destroy();
        }

        // Initialize DataTable with descending order
        $('#blogTable').DataTable({
            "order": [[0, "desc"]],
            "pageLength": 10,
            "responsive": true,
            "autoWidth": false
        });
    });
</script>
@endsection

