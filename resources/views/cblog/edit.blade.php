@extends('layouts.app')
@section('css')
@section('content')
<div class="content-area">
    <div class="add-product-content1">
        <div class="row">
            <div class="col-lg-12">
                <div class="product-description">
                    <div class="body-area">
                    <form id="geniusformdata" action="{{route('admin-cblog-update',$catInfo->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="left-area">
                                        <h4 class="heading">{{ __('Name') }} *</h4>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="name" placeholder="{{ __('Name') }}" required="" value="{{$catInfo->name}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="left-area">
                                        <h4 class="heading">{{ __('Slug') }} <small>optional</small></h4>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" name="slug" placeholder="{{ __('slug') }}" value="{{$catInfo->slug}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="left-area">
                                        <h4 class="heading">{{ __('Banner') }} *</h4>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <input name="banner" type="file" accept="image/*" onchange="previewImage(event)">
                            </div>
                            <div class="col-lg-5">
                                <img id="preview" alt="Preview Image" src="{{ asset($catInfo->banner)}}" height="100px" width="200px">
                                <input type="hidden" name="previous_photo" value="{{ $catInfo->banner }}">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-12">
                                <h4 class="heading">{{ __('Description') }} *</h4>
                                <textarea name="description" rows="4" class="editor form-control"  placeholder="{{__('Description For Blog Category')}}">{!!@$catInfo->description!!}</textarea>
                            </div>

                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <div class="col-md-2">
                                    <label class="form-label">{{__('Status')}}</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="1" @if(1==$catInfo->status) @selected(true) @endif>Active</option>
                                        <option value="0"@if(0==$catInfo->status) @selected(true) @endif>Dactive</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="category_id">{{__('Products Category')}}</label>
                                    <div class="form-group" id="category">

                                        <select class="form-control demo-select2-placeholder" name="pcategory_id" id="category_id" required>
                                            <option>Select an option</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" <?php if($catInfo->pcategory_id == $category->id) echo "selected"; ?> >{{__($category->name)}}</option>
                                            @endforeach
                                        </select>

                                    </div>


                                </div>
                                <div class="col-md-3">
                                    <div  id="subcategory">
                                        <label class="form-label" for="subcategory_id">{{__('Subcategory')}}</label>
                                        <select class="form-control demo-select2-placeholder" name="subcategory_id" id="subcategory_id" required>
                                            <option>Select an option</option>

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
                            <div class="col-lg-4">
                                <div class="left-area">

                                </div>
                            </div>
                            <div class="col-lg-7">
                                <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
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
@endsection
