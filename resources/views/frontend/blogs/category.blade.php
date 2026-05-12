@extends('frontend.layouts.app')

@section('title', 'Shundorjo Category List')

@push('css')
    <link href="{{ asset('frontend/blog/lib/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/blog/lib/slick/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/blog/css/style.css') }}" rel="stylesheet">

    <style>
        .blog-meta h3 {
            font-size: 14px;
            color: #797979;
        }

        a {
            text-decoration: none !important;
        }

        #load-more-blog {
            background-color: #ec21cd;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <section class="gry-bg">

        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container">
                <ul class="breadcrumb">
                    <li class="facl facl-angle-right">
                        <a href="{{ route('shundorjo-care-tips') }}">Shundorjo Care Tips</a>
                    </li>
                    <li class="facl facl-angle-right"><a href="#">Category</a></li>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- Blog & Sidebar Start -->
        <section class="section wb">
            <div class="container">
                <div class="row">

                    <!-- Blog List -->
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="page-wrapper">
                            <div class="blog-list clearfix">

                                <div id="blog-list">
                                    @include('frontend.blogs.load_more_categories_post')
                                </div>

                                <!-- Load More Button -->
                                <div class="text-center my-4">
                                    <button id="load-more-blog" class="btn">Load More</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="sidebar">

                            <!-- Categories Widget -->
                            <div class="widget">
                                <h4 class="sw-title text-pink text-lg">Shundorjo Care Category</h4>
                                <div class="news-list">
                                    @foreach ($blogCategories as $value)
                                        <div class="nl-item d-flex align-items-center mb-2">
                                            <div class="nl-img mr-2">
                                                <a href="{{ route('health-and-bueaty-tips.category', $value->slug) }}">
                                                    <img class="lazyload"
                                                         data-src="{{ asset($value->banner) }}"
                                                         width="100" height="44"
                                                         alt="{{ $value->name }}" />
                                                </a>
                                            </div>
                                            <div class="nl-title">
                                                <a href="{{ route('health-and-bueaty-tips.category', $value->slug) }}">
                                                    {{ $value->name }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tabbed Products -->
                            <div class="widget">
                                <div class="tab-news">
                                    <ul class="nav nav-pills nav-justified">
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="pill" href="#latest">Latest</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="pill" href="#featured">Featured</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="pill" href="#popular">Popular</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content mt-3">

                                        <!-- Featured Products -->
                                        <div id="featured" class="tab-pane fade">
                                            @foreach (filter_products(\App\Models\Product::where('featured', 1))->limit(10)->get() as $product)
                                                @include('frontend.partials.product_sidebar', ['product' => $product])
                                            @endforeach
                                        </div>

                                        <!-- Popular Products -->
                                        <div id="popular" class="tab-pane fade show active">
                                            @foreach (filter_products(\App\Models\Product::orderBy('num_of_sale', 'desc'))->limit(10)->get() as $product)
                                                @include('frontend.partials.product_sidebar', ['product' => $product])
                                            @endforeach
                                        </div>

                                        <!-- Latest Products -->
                                        <div id="latest" class="tab-pane fade">
                                            @foreach (filter_products(\App\Models\Product::where('category_id', $category->pcategory_id))->orderBy('id', 'desc')->limit(10)->get() as $product)
                                                @include('frontend.partials.product_sidebar', ['product' => $product])
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Advertisement -->
                            <div class="widget">
                                <h2 class="widget-title">Advertising</h2>
                                <div class="banner-spot clearfix">
                                    <div class="banner-img">
                                        <a href="https://www.shundorjo.com">
                                            <img src="{{ asset('frontend/blog/img/ads-2.jpg') }}"
                                                 alt="Shundorjo is Authentic Cosmetics Products Hub"
                                                 class="img-fluid">
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Sidebar End -->

                </div>
            </div>
        </section>
        <!-- Blog & Sidebar End -->

    </section>
@endsection

@push('script')
    <script src="{{ asset('frontend/blog/lib/slick/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/blog/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('frontend/blog/js/main.js') }}"></script>
@endpush
