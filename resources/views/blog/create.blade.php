@extends('layouts.app')
@section('css')
<style>
    #preview {
       width: 180px;
       height: 80px;
    }
 </style>
@endsection
@section('content')
    <div class="content-area">


        <div class="add-product-content1">
            <div class="row">
                @include('admin.form-both')
                <form id="geniusform" action="{{ route('admin-blog-create') }}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Blog Category</label>
                            <select name="category_id" required="" class="form-control demo-select2-placeholder select2-hidden-accessible">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($cats as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                          </div>
                    </div>
                    <div class="col-md-3">
                        <label for="photo" class="form-label">{{ __('Upload Image') }}</label>


                                <input name="photo" type="file" accept="image/*" onchange="previewImage(event)">
                        <div class="mb-3">

                            <img id="preview" alt="Preview Image" src="https://picsum.photos/200/300">
                            </div>

                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">{{__('Description')}}</label>
                     <textarea name="details" rows="6" class="editor form-control"  placeholder="{{__('Description For Blog Post')}}"></textarea>
                        </div>
                    </div>
                    <hr>
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

                <hr>
                <div class="ml-auto">

                    <button class="btn btn-success"
                        type="submit">{{ __('Create Post') }}</button>
                </div>

                            </form>
                        </div>
                    </div>
                </div>


@endsection
@section('script')
<script src="{{asset('admin/js/jqueryui.min.js')}}"></script>
<script src="{{asset('admin/js/vendors/vue.js')}}"></script>
<script src="{{asset('admin/js/plugin.js')}}"></script>
<script src="{{asset('admin/js/tag-it.js')}}"></script>
<script src="{{asset('admin/js/load.js')}}"></script>
    <script>
        // {{-- TAGIT --}}

        $("#metatags").tagit({
            fieldName: "meta_tag[]",
            allowSpaces: true
        });

        $("#tags").tagit({
            fieldName: "tags[]",
            allowSpaces: true
        });
        // {{-- TAGIT ENDS --}}

    </script>
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
@endsection
