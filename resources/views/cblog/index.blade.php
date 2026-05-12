@extends('layouts.app')

@section('content')
<input type="hidden" id="headerdata" value="{{ __('CATEGORY') }}">
<div class="content-area">

    <div class="product-area">
        <div class="row">
            <div class="col-lg-12">
                <div class="mr-table allproduct float-right">
                   <a class="btn btn-hover-success btn-primary" data-href="{{ route('admin-cblog-create') }}" id="add-data" data-toggle="modal" data-target="#modal1"><i class="fa fa-plus"></i> {{ __('Add New Category') }}</a>
                   <br><br>
                    <div class="table-responsiv">
                        <table id="example" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Slug') }}</th>
                                    <th>{{ __('Banner') }}</th>
                                    <th>{{ __('Options') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data as $value)
<tr>
    <td>
        {{$value->name}}
    </td>
    <td>
        {{$value->slug}}
    </td>
    <td><img class="img-md" src="{{ asset($value->banner)}}" alt="{{$value->slug}}"></td>
    <td><a href="{{route('admin-cblog-edit',$value->id)}}" class="edit btn btn-info" > <i class="fa fa-edit"></i></a>
        <a href="javascript::" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
</tr>
{{-- DELETE MODAL --}}

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header d-block text-center">
                <h4 class="modal-title d-inline-block">{{ __('Confirm Delete') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <p class="text-center">
                    {{ __('You are about to delete this Category. Everything will be deleted under this Category.') }}
                </p>
                <p class="text-center">{{ __('Do you want to proceed?') }}</p>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a href="{{route('admin-cblog-delete',$value->id)}}" class="btn btn-danger btn-ok">{{ __('Delete') }}</a>
            </div>

        </div>
    </div>
</div>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- ADD / EDIT MODAL --}}

<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="geniusformdata" action="{{ route('admin-cblog-create') }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-lg-3">
                        <div class="left-area">
                            <h4 class="heading">{{ __('Name') }} *</h4>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" name="name" placeholder="{{ __('Name') }}"
                            required value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="left-area">
                            <h4 class="heading">{{ __('Slug') }} <small>optional</small></h4>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" name="slug" placeholder="{{ __('Slug') }}" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="left-area">
                            <h4 class="heading">{{ __('Banner') }} *</h4>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <input type="file" class="form-control" name="banner"
                            required accept="image/*" onchange="previewImage(event)">
                    </div>
                    <div class="col-lg-5">
                        <img id="preview" alt="Preview Image" src="https://picsum.photos/200/300" width="200px;" height="100px;">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <div class="col-md-2">
                            <label class="form-label">{{__('Status')}}</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Dactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="category_id">{{__('Products Category')}}</label>
                            <div class="form-group" id="category">

                                    <select class="form-control demo-select2-placeholder" name="pcategory_id" id="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{__($category->name)}}</option>
                                        @endforeach
                                    </select>
                            </div>


                        </div>
                        <div class="col-md-3">
                            <div  id="subcategory">
                                <label class="form-label" for="subcategory_id">{{__('Subcategory')}}</label>
                                    <select class="form-control demo-select2-placeholder" name="subcategory_id" id="subcategory_id" required>

                                    </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{__('Sub Subcategory')}}</label>
                            <div class="form-group" id="subsubcategory">

                                    <select class="form-control demo-select2-placeholder" name="subsubcategory_id" id="subsubcategory_id">

                                    </select>
                            </div>
                        </div>
                       </div>
                </div>
                 <div class="row">

                    <div class="col-lg-12">
                        <h4 class="heading">{{ __('Description') }} *</h4>
                        <textarea name="description" rows="4" class="editor form-control"  placeholder="{{__('Description For Blog Category')}}"></textarea>
                    </div>

                </div>


                <div class="row">
                    <div class="col-lg-4">
                        <div class="left-area">

                        </div>
                    </div>
                    <div class="col-lg-7">
                        <button class="btn btn-info"
                            type="submit">{{ __('Create Category') }}</button>
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>

{{-- ADD / EDIT MODAL ENDS --}}

{{-- ADD / EDIT MODAL ENDS --}}
<script type="text/javascript">
    function previewImage(event) {
       var input = event.target;
       var image = document.getElementById('preview');
       if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
             image.src = e.target.result;
          }
          reader.readAsDataURL(input.files[0]);
       }
    }


 </script>


{{-- DELETE MODAL ENDS --}}
@endsection

