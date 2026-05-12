@extends('frontend.layouts.app')

@section('title')
    Shundorjo Care Tips
@stop
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href=" {{ asset('frontend/blog/lib/slick/slick.css') }}" rel="stylesheet">
<link href=" {{ asset('frontend/blog/lib/slick/slick-theme.css') }}" rel="stylesheet">
<link href=" {{ asset('frontend/blog/css/style.css') }}" rel="stylesheet">
<style>
    .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 10px;
    padding-left: 10px;
}
</style>
@endpush



@section('content')

    <section class="gry-bg py-2">
   <!-- Top News Start-->
   <div class="top-news">
    <div class="container">
        <div class="row">
            <div class="col-md-6 tn-left">
                <div class="row tn-slider">
                    @foreach ($data['blogs'] as $value)
                    <div class="col-md-6">
                        <div class="tn-img">
                            <img src="{{ asset($value->photo)}}" style="width: 550px; height:380px" />
                            <div class="tn-title">
                                <a href="{{ route('health-and-bueaty-tips', $value->slug) }}">{{$value->title}}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>
            <div class="col-md-6 tn-right">
                <div class="row">
                    @foreach ($data['blogCategories'] as $value)
                    <div class="col-md-4 mb-3">
                        <div class="tn-img">
                            <img class="lazyload" data-src="{{ asset($value->banner)}}" style="width: 179px; height:122px;" alt="{{$value->name}}" />
                            <div class="tn-title">
                                <a href="{{ route('health-and-bueaty-tips.category', $value->slug) }}">{{@$value->name}}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach



                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top News End-->

<!-- Category News Start-->
<div class="cat-news">
    <div class="container">
        <div class="row">
            @foreach (\App\Models\BlogCategory::inRandomOrder()->get() as $value)
            <div class="col-md-6">

                <h2>{{$value->name}}</h2>
                <div class="row cn-slider">
                    @foreach (\App\Models\Blog::where('category_id',$value->id)->limit(5)->get() as $item)
                    <div class="col-md-6">
                        <div class="cn-img">
                            <img data-src="{{ asset($item->photo)}}" class="lazyload" style="width: 350px; height: 223px;" alt="{{$item->title}}" />
                            <div class="cn-title">
                                <a href="{{ route('health-and-bueaty-tips', $item->slug) }}">{{$item->title}}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
                @endforeach


        </div>
    </div>
</div>
<!-- Category News End-->



<!-- Main News Start-->
<div class="main-news">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">

                <section class="py-2">
                    <div class="container">

                        <div id="blog-list">
                            @include('frontend.blogs.load_more') <!-- Include the product list here -->
                        </div>

                        <!-- Load More Button -->
                        <div class="text-center my-4">
                            <button id="load-more-blog" class="btn" style="background-color: #ec21cd;
">Load More</button>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-lg-3">
                <div class="mn-list">
                    <h5 class="text-pink">Products Categories</h5>
                    <div class="accordion mt-n1" id="shop-categories">
                        @foreach (\App\Models\Category::all() as $key => $category)
                            <div class="card">
                                <div class="card-header p-1 text-pink">
                                    <label class="for-hover-lable" style="cursor: pointer"
                                        onclick="location.href='{{ route('products.category', $category->id) }}'">{{ __($category->name) }}</label>
                                    <strong class="pull-right for-brand-hover" style="cursor: pointer"
                                        onclick="$('#collapse-{{ $key }}').toggle(400)">
                                        +
                                    </strong>
                                </div>
                                <div class="card-body" id="collapse-{{ $key }}"
                                    style="display: none;">
                                    @foreach ($category->subcategories as $key2 => $subcategory)
                                        <div class=" for-hover-lable card-header p-1 text-pink">
                                            <label style="cursor: pointer"
                                                onclick="location.href='{{ route('products.subcategory', $subcategory->id) }}'">{{ __($subcategory->name) }}</label>
                                            <strong class="pull-right" style="cursor: pointer"
                                                onclick="$('#collapse-{{ $key }}-{{ $key2 }}').toggle(400)">
                                                +
                                            </strong>
                                        </div>
                                        <div class="card-body"
                                            id="collapse-{{ $key }}-{{ $key2 }}"
                                            style="display: none">
                                            @foreach ($subcategory->subsubcategories as $key3 => $subsubcategory)
                                                <div class=" for-hover-lable card-header p-1 text-pink">
                                                    <label style="cursor: pointer"
                                                        onclick="location.href='{{ route('products.subsubcategory', $subsubcategory->id) }}'">{{ __($subsubcategory->name) }}</label>

                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach


                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main News End-->
    </section>

@endsection
@push('script')
<script src="{{ asset('frontend/blog/lib/slick/slick.min.js') }}"></script>
<script src="{{ asset('frontend/blog/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('frontend/blog/js/main.js') }}"></script>
@endpush
