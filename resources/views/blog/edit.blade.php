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
                <form id="geniusform" action="{{route('admin-blog-update', $data->id)}}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Blog Category</label>
                            <select name="category_id" required="" class="form-control demo-select2-placeholder select2-hidden-accessible">
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($cats as $cat)
                                    <option value="{{ $cat->id }}" @if($cat->id==$data->category_id) @selected(true) @endif>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" value="{{$data->title}}" class="form-control" name="title" id="title" placeholder="Title">
                          </div>
                    </div>
                    <div class="col-md-3">
                        <label for="photo" class="form-label">{{ __('Upload Image') }}</label>


                                <input name="photo" type="file" accept="image/*" onchange="previewImage(event)">
                        <div class="mb-3">

                            <img id="preview" alt="Preview Image" src="{{ asset($data->photo)}}">
                            <input type="hidden" name="previous_photo" value="{{ $data->photo }}">
                            </div>

                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">{{__('Description')}}</label>
                     <textarea name="details" rows="6" class="editor form-control"  placeholder="{{__('Description For Blog Post')}}">{!!$data->details!!}</textarea>
                        </div>
                    </div>
                    <hr>
                   <div class="mb-3">
                    <div class="col-md-2">
                        <label class="form-label">{{__('Status')}}</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1" @if(1==$data->status) @selected(true) @endif>Active</option>
                            <option value="0"@if(0==$data->status) @selected(true) @endif>Dactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="category_id">{{__('Products Category')}}</label>
                        <div class="form-group" id="category">

                            <select class="form-control demo-select2-placeholder" name="pcategory_id" id="category_id" required>
                                <option>Select an option</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" <?php if($data->pcategory_id == $category->id) echo "selected"; ?> >{{__($category->name)}}</option>
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
 function get_subcategories_by_category(){
		var category_id = $('#category_id').val();
        // console.log(category_id);
		$.post('{{ route('subcategories.get_subcategories_by_category') }}',{_token:'{{ csrf_token() }}', category_id:category_id}, function(data){
		    $('#subcategory_id').html(null);
		    for (var i = 0; i < data.length; i++) {
		        $('#subcategory_id').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		    }
		    $("#subcategory_id > option").each(function() {
		        if(this.value == '{{$data->subcategory_id}}'){
		            $("#subcategory_id").val(this.value).change();
		        }
		    });
		    $('.demo-select2').select2();

		    get_subsubcategories_by_subcategory();
		});
	}

	function get_subsubcategories_by_subcategory(){
		var subcategory_id = $('#subcategory_id').val();
		$.post('{{ route('subsubcategories.get_subsubcategories_by_subcategory') }}',{_token:'{{ csrf_token() }}', subcategory_id:subcategory_id}, function(data){
		    $('#subsubcategory_id').html(null);
		    for (var i = 0; i < data.length; i++) {
		        $('#subsubcategory_id').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		    }
		    $("#subsubcategory_id > option").each(function() {
		        if(this.value == '{{$data->subsubcategory_id}}'){
		            $("#subsubcategory_id").val(this.value).change();
		        }
		    });

		    $('.demo-select2').select2();

		});
	}

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



    $('#category_id').on('change', function() {
	    get_subcategories_by_category();
	});

	$('#subcategory_id').on('change', function() {
	    get_subsubcategories_by_subcategory();
	});



     </script>
@endsection
