@extends('frontend.layouts.app')

@section('title')
    {{ $data['blog']->title }}
@stop
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href=" {{ asset('frontend/blog/lib/slick/slick.css') }}" rel="stylesheet">
    <link href=" {{ asset('frontend/blog/lib/slick/slick-theme.css') }}" rel="stylesheet">
    <link href=" {{ asset('frontend/blog/css/style.css') }}" rel="stylesheet">
    <style>
        .col,
        .col-1,
        .col-10,
        .col-11,
        .col-12,
        .col-2,
        .col-3,
        .col-4,
        .col-5,
        .col-6,
        .col-7,
        .col-8,
        .col-9,
        .col-auto,
        .col-lg,
        .col-lg-1,
        .col-lg-10,
        .col-lg-11,
        .col-lg-12,
        .col-lg-2,
        .col-lg-3,
        .col-lg-4,
        .col-lg-5,
        .col-lg-6,
        .col-lg-7,
        .col-lg-8,
        .col-lg-9,
        .col-lg-auto,
        .col-md,
        .col-md-1,
        .col-md-10,
        .col-md-11,
        .col-md-12,
        .col-md-2,
        .col-md-3,
        .col-md-4,
        .col-md-5,
        .col-md-6,
        .col-md-7,
        .col-md-8,
        .col-md-9,
        .col-md-auto,
        .col-sm,
        .col-sm-1,
        .col-sm-10,
        .col-sm-11,
        .col-sm-12,
        .col-sm-2,
        .col-sm-3,
        .col-sm-4,
        .col-sm-5,
        .col-sm-6,
        .col-sm-7,
        .col-sm-8,
        .col-sm-9,
        .col-sm-auto,
        .col-xl,
        .col-xl-1,
        .col-xl-10,
        .col-xl-11,
        .col-xl-12,
        .col-xl-2,
        .col-xl-3,
        .col-xl-4,
        .col-xl-5,
        .col-xl-6,
        .col-xl-7,
        .col-xl-8,
        .col-xl-9,
        .col-xl-auto {
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 10px;
            padding-left: 10px;
        }
    </style>
@endpush



@section('content')
    <section class="gry-bg">
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container">

                <ul class="breadcrumb">
                    <li class="facl facl-angle-right"><a href="{{ route('shundorjo-care-tips') }}">Shundorjo Care Tips</a>
                    </li>
                    <li class="facl facl-angle-right"><a href="{{ route('health-and-bueaty-tips.category', $data['blog']->category->slug) }}">{{ $data['blog']->category->name }}</a></li>
                    <li class="breadcrumb-item active">{{ $data['blog']->title }}</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- Single News Start-->
        <div class="single-news">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="sn-container">
                            <div class="sn-img">
                                <img src="{{ asset($data['blog']->photo) }}" />
                                <small><i class="fa fa-eye">{{$data['blog']->views}}</i>
                                </small>
                        <small>{{date("F j, Y, g:i a", strtotime($data['blog']->created_at))}}</small>
                        <small>Written by {{$data['blog']->create_by}}</small>
                            </div>
                            <div class="sn-content">
                                <h1 class="sn-title">{{ $data['blog']->title }}</h1>
                                <p>
                                    {!! $data['blog']->details !!}
                                </p>
                            </div>
                        </div>
                        <div class="sn-related">
                            <h2>Related Health & Beauty Tips</h2>
                            <div class="row sn-slider">
                                @foreach ($data['blogs'] as $item)
                                    <div class="col-md-4">
                                        <div class="sn-img">
                                            <img data-src="{{ asset($item->photo) }}" style="width: 350px; height:223px;" class="lazyload" alt="{{ $item->title }}"/>
                                            <div class="sn-title">
                                                <a
                                                    href="{{ route('health-and-bueaty-tips', $item->slug) }}">{{ $item->title }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <section class="productFeatured py-2">
                            <div class="container">
                                <div id="product-list">
                                    @include('frontend.blogs.load_more_products') <!-- Initial product list -->
                                </div>

                                <!-- Load More Button -->
                                <div class="text-center my-4">

                                    <button id="load-more" class="btn btn-primary"
                                        data-category-id="{{ $data['blog']->pcategory_id }}"> <!-- Pass category_id -->
                                        Load More
                                    </button>





                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="col-lg-4">
                        <div class="sidebar">
                            <div class="sidebar-widget">
                                <h4 class="sw-title text-pink">Shundorjo Care Category</h4>
                                <div class="news-list">
                                    @foreach ($data['blogCategories'] as $value)
                                        <div class="nl-item">
                                            <div class="nl-img">
                                                <a href="{{ route('health-and-bueaty-tips.category', $value->slug) }}">
                                                    <img data-src="{{ asset($value->banner) }}" width="100px" height="44px" class="lazyload" alt="{{ @$value->name }}" />
                                                </a>
                                            </div>
                                            <div class="nl-title">
                                                <a href="{{ route('health-and-bueaty-tips.category', $value->slug) }}">{{ @$value->name }}</a>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>

                            <div class="sidebar-widget">
                                <div class="image">
                                    <a href="https://www.shundorjo.com"><img
                                            src="{{ asset('frontend/blog') }}/img/ads-2.jpg" alt="Image"></a>
                                </div>
                            </div>

                            <div class="sidebar-widget">
                                <div class="tab-news">
                                    <ul class="nav nav-pills nav-justified">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="pill" href="#latest">Latest</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="pill" href="#featured">Featured</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="pill" href="#popular">Popular</a>
                                        </li>

                                    </ul>

                                    <div class="tab-content">
                                        <div id="featured" class="container tab-pane fade">
                                            @foreach (filter_products(\App\Models\Product::where('featured', 1))->limit(10)->get() as $key => $top_product)
                                                <div class="mb-3 product-box-3 myDIV">
                                                    <div class="clearfix">
                                                        <div class="product-image float-left">
                                                            <a href="{{ route('product', $top_product->slug) }}"><img class="lazyload"
                                                                data-src="{{ asset($top_product->thumbnail_img) }}"
                                                                    height="90" width="90" alt="{{ $top_product->name }}"></a>
                                                        </div>
                                                        <div class="product-details float-left">
                                                            <h4 class="title text-truncate-2">
                                                                <a href="{{ route('product', $top_product->slug) }}"
                                                                    class="d-block">{{ $top_product->name }}</a>
                                                            </h4>
                                                            <div class="price-box">
                                                                @if (home_base_price($top_product->id) != home_discounted_base_price($top_product->id))
                                                                    <del
                                                                        class="old-product-price strong-400">{{ home_base_price($top_product->id) }}</del>
                                                                @endif
                                                                <span
                                                                    class="product-price strong-600">{{ home_discounted_base_price($top_product->id) }}</span>
                                                            </div>

                                                            @if($top_product->is_stock==1)
                                                            <button class="buyNowBtn mt-3"
                                                                onclick="buyNow({{ $top_product->id }})">
                                                                <i class="fa fa-eye"></i>
                                                                <article class="d-inline">Order Now</article>
                                                            </button>
                                                            @else
                                                            <button class="buyNowBtn  mt-3">
                                                                <i class="fa fa-eye"></i>
                                                                <article class="d-inline">Stock Out</article></button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div id="popular" class="container tab-pane fade">
                                            @foreach (filter_products(\App\Models\Product::orderBy('num_of_sale', 'desc'))->limit(10)->get() as $key => $top_product)
                                                <div class="mb-3 product-box-3 myDIV">
                                                    <div class="clearfix">
                                                        <div class="product-image float-left">
                                                            <a href="{{ route('product', $top_product->slug) }}"><img
                                                                    src="{{ asset($top_product->thumbnail_img) }}"
                                                                    height="90" width="90" alt=""></a>
                                                        </div>
                                                        <div class="product-details float-left">
                                                            <h4 class="title text-truncate-2">
                                                                <a href="{{ route('product', $top_product->slug) }}"
                                                                    class="d-block">{{ $top_product->name }}</a>
                                                            </h4>
                                                            <div class="price-box">
                                                                @if (home_base_price($top_product->id) != home_discounted_base_price($top_product->id))
                                                                    <del
                                                                        class="old-product-price strong-400">{{ home_base_price($top_product->id) }}</del>
                                                                @endif
                                                                <span
                                                                    class="product-price strong-600">{{ home_discounted_base_price($top_product->id) }}</span>
                                                            </div>

                                                            @if($top_product->is_stock==1)
                                                            <button class="buyNowBtn mt-3"
                                                                onclick="buyNow({{ $top_product->id }})">
                                                                <i class="fa fa-eye"></i>
                                                                <article class="d-inline">Order Now</article>
                                                            </button>
                                                            @else
                                                            <button class="buyNowBtn  mt-3">
                                                                <i class="fa fa-eye"></i>
                                                                <article class="d-inline">Stock Out</article></button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div id="latest" class="container tab-pane active">
                                            @foreach (filter_products(\App\Models\Product::where('category_id', $data['blog']->pcategory_id))->orderBy('id', 'desc')->limit(10)->get() as $key => $top_product)
                                                <div class="mb-3 product-box-3 myDIV">
                                                    <div class="clearfix">
                                                        <div class="product-image float-left">
                                                            <a href="{{ route('product', $top_product->slug) }}"><img
                                                                data-src="{{ asset($top_product->thumbnail_img) }}"
                                                                    height="90" width="90" alt="{{ $top_product->name }}" class="lazyload"></a>
                                                        </div>
                                                        <div class="product-details float-left">
                                                            <h4 class="title text-truncate-2">
                                                                <a href="{{ route('product', $top_product->slug) }}"
                                                                    class="d-block">{{ $top_product->name }}</a>
                                                            </h4>
                                                            <div class="price-box">
                                                                @if (home_base_price($top_product->id) != home_discounted_base_price($top_product->id))
                                                                    <del
                                                                        class="old-product-price strong-400">{{ home_base_price($top_product->id) }}</del>
                                                                @endif
                                                                <span
                                                                    class="product-price strong-600">{{ home_discounted_base_price($top_product->id) }}</span>
                                                            </div>

                                                            @if($top_product->is_stock==1)
                                                            <button class="buyNowBtn mt-3"
                                                                onclick="buyNow({{ $top_product->id }})">
                                                                <i class="fa fa-eye"></i>
                                                                <article class="d-inline">Order Now</article>
                                                            </button>
                                                            @else
                                                            <button class="buyNowBtn  mt-3">
                                                                <i class="fa fa-eye"></i>
                                                                <article class="d-inline">Stock Out</article></button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sidebar-widget">
                                <h2 class="sw-title">Products Category</h2>

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
        </div>
        <!-- Single News End-->
        <!-- Main News End-->
    </section>

@endsection
@push('script')
    <script src="{{ asset('frontend/blog/lib/slick/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/blog/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('frontend/blog/js/main.js') }}"></script>
@endpush
