@extends('frontend.layouts.app')
@section('title')
    Buy Authentic Cosmetics & Skincare Products in Bangladesh | Shundorjo
@stop
@section('css')

    <style>
        .cat_space_item {
            margin-left: 10px;
            margin-right: 10px;
            margin-bottom: 20px;
        }

        .nt_bg_lz {
            display: block;
            width: 100%;
            height: 100%;
            position: relative;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .swiper-container {
            width: 100%;
            height: 450px;
        }

        .text-logo {
            color: #ff3d71;
        }

        @media (max-width: 425px) {
            .swiper-slide>img {
                height: 160px !important;
            }

        }

        .cat-items-wrap {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -5px;
        }

        .cat-item {
            flex: 0 0 12.33%;
            padding: 0 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .cat-item .cat-icon {
            display: inline-block;
            /* padding: 15px; */
        }

        .cat-item .cat-item-inner {
            display: block;
            background: #ffffff;
            border-radius: 5px;
            box-shadow: 0px 0px 7px 0px rgb(0 0 0 / 10%);
            padding: 10px 0 5px 0;
        }

        .cat-item a:hover {
            color: red
        }

        .gallery-block.grid-gallery {
            padding-bottom: 30px;
            padding-top: 30px;
        }



        .gallery-block.grid-gallery a:hover {
            opacity: 0.8;
        }


        .gallery-block.grid-gallery .item {
            margin-bottom: 7px;
            padding-right: 4px !important;
            padding-left: 4px !important;

        }



        .gallery-block.grid-gallery img {
            width: 490px !important;
            height: 200px !important;
            border-radius: 8px;
        }

        @media (min-width: 576px) {

            .gallery-block.grid-gallery .scale-on-hover:hover {
                transform: scale(1.05);
                box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.15) !important;
            }
        }
    </style>

@endsection
@section('content')

    <!-- Slider main container -->
    <div class="swiper-container">
        <!-- Additional required wrapper -->
        <!-- If we need navigation buttons -->
        <!--<div class="control">-->
        <!--    <div class="swiper-button-prev"></div>-->
        <!--    <div class="swiper-button-next"></div>-->
        <!--</div>-->
        <div class="swiper-wrapper">
            <!-- Slides -->
            @foreach (\App\Models\Slider::where('published', 1)->get() as $key => $slider)
                <div class="swiper-slide">
                    <img src="{{ asset($slider->photo) }}"
                        alt="Shundorjo Care Authentic Cosmetics and Medicated shop in Bangladesh" class="img-fluid"
                        loading="eager">
                </div>
            @endforeach
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>
    </div>
    {{-- category section  start --}}

    <section class="gallery-block grid-gallery">
        <div class="container">

            <div class="row">
                @foreach (\App\Models\Category::latest('id')->limit(8)->get() as $category)
                    <div class="col-sm-6 col-md-4 col-lg-3 item">
                        <div class="category-box card">
                            <a class="lightbox" href="{{ route('products.category', $category->id) }}">
                                <img class="img-fluid image scale-on-hover lazyload card-img-top"
                                    data-src="{{ asset($category->banner) }}" alt="{{ $category->name }}" loading="lazy">
                            </a>
                            <div class="card-body" style="padding: 0%;">
                                <h6> <a href="{{ route('products.category', $category->id) }}"
                                        class="text-truncate mb-0 fw-bold" title=" {{ $category->name }}">
                                        {{ $category->name }}
                                    </a></h6>
                            </div>
                        </div>




                    </div>
                @endforeach

            </div>


        </div>
    </section>
    <section>

        {{-- category section  end --}}

        {{-- flash deal --}}
        @php
            $flash_deal = \App\Models\FlashDeal::where('status', 1)->first();
            $today = now()->timestamp;
        @endphp

        @if ($flash_deal && $today >= $flash_deal->start_date && $today <= $flash_deal->end_date)
            <section class="productFeatured productFetRem">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center my-2">
                            <h2 class="mb-0 titlePro text-danger">{{ $flash_deal->title }}</h2>
                        </div>
                    </div>

                    <div class="row productView mx-lg-auto">
                        @foreach ($flash_deal->flash_deal_products as $flash_product)
                            @php
                                $product = \App\Models\Product::find($flash_product->product_id);
                                if (!$product) {
                                    continue;
                                }
                            @endphp

                            <div class="col-md-3 col-sm-6 col-xl-3 col-lg-3" style="padding: 5px !important">
                                <div class="productDesign">
                                    <div class="productContainer">

                                        {{-- Product Badge --}}
                                        <div class="productBadge">
                                            @if ($product->todays_deal)
                                                <div class="proBadgePer">New</div>
                                            @endif

                                            @if (percentage($product->id) > 0)
                                                <div class="proBadge">-{{ percentage($product->id) }}%</div>
                                            @endif
                                        </div>

                                        {{-- Product Image --}}
                                        <a href="{{ route('product', $product->slug) }}">
                                            @if ($product->thumbnail_webp && file_exists(public_path($product->thumbnail_webp)))
                                                <img class="img-fluid product-photo lazyload"
                                                    data-src="{{ asset($product->thumbnail_webp) }}"
                                                    alt="{{ $product->name }} price in Bangladesh | Buy original {{ $product->brand->name ?? 'cosmetics' }}"
                                                    loading="lazy">
                                            @else
                                                <img class="img-fluid product-photo lazyload"
                                                    data-src="{{ asset($product->thumbnail_img) }}"
                                                    alt="{{ $product->name }} price in Bangladesh | Buy original {{ $product->brand->name ?? 'cosmetics' }}"
                                                    loading="lazy">
                                            @endif
                                        </a>

                                        {{-- Buttons --}}
                                        <div class="inner">
                                            <button class="btn-invisible btn-invisible"
                                                onclick="showAddToCartModal({{ $product->id }})">
                                                <span class="iconify" data-icon="clarity:eye-show-solid"></span>
                                                Quick View
                                            </button>

                                            @if ($product->is_stock == 1)
                                                <button class="btn-invisible" onclick="buyNow({{ $product->id }})">
                                                    <span class="iconify" data-icon="ei:cart"></span>
                                                    Order Now
                                                </button>
                                            @else
                                                <button class="btn-invisible">
                                                    <span class="iconify" data-icon="ei:cart"></span>
                                                    Stock Out
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Info --}}
                                    <div class="product-info-home mb-2">
                                        <!-- for Google -->
                                        <div itemscope itemtype="https://schema.org/Product">

                                            <meta itemprop="name" content="{{ $product->name }}">
                                            <meta itemprop="image" content="{{ asset($product->thumbnail_img) }}">
                                            <meta itemprop="description"
                                                content="{{ Str::limit(strip_tags($product->description), 150) }}">
                                            <meta itemprop="sku" content="{{ $product->prescribed }}">
                                            <meta itemprop="url" content="{{ route('product', $product->slug) }}">

                                            <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                                <meta itemprop="priceCurrency" content="BDT">
                                                <meta itemprop="price"
                                                    content="{{ home_discounted_base_price_raw($product->id) }}">
                                                <link itemprop="availability"
                                                    href="https://schema.org/{{ $product->is_stock ? 'InStock' : 'OutOfStock' }}">
                                            </div>

                                            @if (count($product->reviews) > 0)
                                                <div itemprop="aggregateRating" itemscope
                                                    itemtype="https://schema.org/AggregateRating">
                                                    <meta itemprop="ratingValue" content="4.8">
                                                    <meta itemprop="reviewCount" content="{{ count($product->reviews) }}">
                                                </div>
                                            @endif

                                        </div>
                                        <div class="price-box text-center">
                                            <span class="product-price strong-600">
                                                {{ home_discounted_base_price($product->id) }}
                                            </span>

                                            @if (home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <del class="old-product-price strong-400">
                                                    {{ home_base_price($product->id) }}
                                                </del>
                                            @endif
                                        </div>

                                        <h6 class="product-title">
                                            <a href="{{ route('product', $product->slug) }}">
                                                {{ __($product->name) }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </section>
        @endif

        {{-- flash deal end --}}
        {{-- product section --}}
        {{-- product section --}}
        <section class="productFeatured productFetRem mt-2">

            @foreach (\App\Models\Category::where('featured', 1)->get() as $key => $category)
                <div class="container">

                    <div class="row">
                        <div class="col-md-12 text-center my-2">
                            <h2 class="mb-0 titlePro">
                                <a href="{{ route('products.category', $category->id) }}"
                                    title="{{ $category->name }} products in Bangladesh">
                                    {{ $category->name }}
                                </a>
                            </h2>
                        </div>
                    </div>

                    <!-- Grid Controls -->
                    <div class="grid-controls">
                        <button class="grid-btn" data-columns="6" data-category="category_{{ $category->id }}">
                            <div class="grid-icon"></div>
                            <div class="grid-icon"></div>
                        </button>
                        <button class="grid-btn" data-columns="4" data-category="category_{{ $category->id }}">
                            <div class="grid-icon"></div>
                            <div class="grid-icon"></div>
                            <div class="grid-icon"></div>
                        </button>
                        <button class="grid-btn" data-columns="3" data-category="category_{{ $category->id }}">
                            <div class="grid-icon"></div>
                            <div class="grid-icon"></div>
                            <div class="grid-icon"></div>
                            <div class="grid-icon"></div>
                        </button>
                        <button class="grid-btn" data-columns="2" data-category="category_{{ $category->id }}">
                            <div class="grid-icon"></div>
                            <div class="grid-icon"></div>
                            <div class="grid-icon"></div>
                            <div class="grid-icon"></div>
                            <div class="grid-icon"></div>
                            <div class="grid-icon"></div>
                        </button>
                    </div>

                    <!-- Mobile Controls -->
                    <div class="grid-controls mobile-grid-controls">
                        <button class="grid-btn grid-btn-mobile" data-columns="12"
                            data-category="category_{{ $category->id }}">
                            <div class="grid-icon"></div>
                        </button>
                        <button class="grid-btn grid-btn-mobile" data-columns="6"
                            data-category="category_{{ $category->id }}">
                            <div class="grid-icon"></div>
                            <div class="grid-icon"></div>
                        </button>
                    </div>

                    <!-- Product List -->
                    <div class="row productView mx-lg-auto mt-3">

                        @foreach (filter_products(\App\Models\Product::where('category_id', $category->id))->latest('id')->limit(12)->get() as $key => $related_product)
                            <div class="col-md-3 col-sm-6 product-column" data-category="category_{{ $category->id }}"
                                style="padding: 5px !important;">

                                <!-- Product Schema Wrapper -->
                                <div class="productDesign product-box-col-3"
                                    data-category="category_{{ $category->id }}">
                                    <!-- for Google -->

                                    <div itemscope itemtype="https://schema.org/Product">
                                        <meta itemprop="name" content="{{ $related_product->name }}">
                                        <meta itemprop="image" content="{{ asset($related_product->thumbnail_img) }}">
                                        <meta itemprop="description"
                                            content="{{ Str::limit(strip_tags($related_product->description), 150) }}">
                                        <meta itemprop="sku" content="{{ $related_product->prescribed }}">
                                        <meta itemprop="url" content="{{ route('product', $related_product->slug) }}">

                                        <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                            <meta itemprop="priceCurrency" content="BDT">
                                            <meta itemprop="price"
                                                content="{{ home_discounted_base_price_raw($related_product->id) }}">
                                            <link itemprop="availability"
                                                href="https://schema.org/{{ $related_product->is_stock ? 'InStock' : 'OutOfStock' }}">
                                        </div>
                                        @if (count($related_product->reviews) > 0)
                                            <div itemprop="aggregateRating" itemscope
                                                itemtype="https://schema.org/AggregateRating">
                                                <meta itemprop="ratingValue" content="4.8">
                                                <meta itemprop="reviewCount"
                                                    content="{{ count($related_product->reviews) }}">
                                            </div>
                                        @endif
                                    </div>


                                    <div class="productContainer">

                                        <div class="productBadge">
                                            @if ($related_product->todays_deal == 1)
                                                <div class="proBadgePer">New</div>
                                            @endif

                                            @if (percentage($related_product->id) > 0)
                                                <div class="proBadge">-{{ percentage($related_product->id) }}%</div>
                                            @endif
                                        </div>

                                        <a href="{{ route('product', $related_product->slug) }}"
                                            title="{{ $related_product->name }} price in Bangladesh">

                                            @if ($related_product->thumbnail_webp && file_exists(public_path($related_product->thumbnail_webp)))
                                                <img class="img-fluid product-photo custom-height-img custom-height-img-3 lazyload"
                                                    data-src="{{ asset($related_product->thumbnail_webp) }}"
                                                    alt="{{ $related_product->name }} price in Bangladesh | Buy original {{ $related_product->brand->name ?? 'Cosmetics' }}"
                                                    itemprop="image" loading="lazy">
                                            @else
                                                <img class="img-fluid product-photo custom-height-img custom-height-img-3 lazyload"
                                                    data-src="{{ asset($related_product->thumbnail_img) }}"
                                                    alt="{{ $related_product->name }} price in Bangladesh | Buy original {{ $related_product->brand->name ?? 'Cosmetics' }}"
                                                    itemprop="image" loading="lazy">
                                            @endif
                                        </a>

                                        <div class="inner">
                                            <a class="btn-invisible btn-quick"
                                                aria-label="Quick view - {{ $related_product->name }}"
                                                onclick="showAddToCartModal({{ $related_product->id }})">
                                                <span class="iconify">Quick View</span>
                                                <article class="d-inline">Quick View</article>
                                            </a>

                                            @if ($related_product->is_stock == 1)
                                                <a class="btn-invisible" onclick="buyNow({{ $related_product->id }})"
                                                    title="Order {{ $related_product->name }} now">
                                                    <span class="iconify">Order Now</span>
                                                    <article class="d-inline">Order Now</article>
                                                </a>
                                            @else
                                                <a class="btn-invisible" title="{{ $related_product->name }} stock out">
                                                    <span class="iconify">Stock Out</span>
                                                    <article class="d-inline">Stock Out</article>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="product-info-home mb-2">

                                        <div class="price-box text-center">


                                            <span class="product-price strong-600" itemprop="price">
                                                ৳
                                                {{ floatval(preg_replace('/[^0-9\.]/', '', home_discounted_base_price($related_product->id))) }}
                                            </span>

                                            @if (home_base_price($related_product->id) != home_discounted_base_price($related_product->id))
                                                <del class="old-product-price strong-400">
                                                    {{ home_base_price($related_product->id) }}
                                                </del>
                                            @endif
                                        </div>

                                        <h2 class="product-title">
                                            <a href="{{ route('product', $related_product->slug) }}"
                                                title="{{ $related_product->name }} price in Bangladesh">
                                                {{ \Illuminate\Support\Str::limit($related_product->name, 80) }}
                                            </a>
                                        </h2>

                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="col-md-12 text-center mt-2">
                        <button class="btn-visible">
                            <a href="{{ route('products.category', $category->id) }}" title="{{ $category->name }}">
                                Load More {{ $category->name }} Products
                            </a>
                        </button>
                    </div>

                </div>
            @endforeach

        </section>
        <section class="category-section py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                        <div class="owl-carousel owl-theme">

                            @foreach (\App\Models\Category::with('subcategories')->latest('id')->limit(8)->get() as $category)
                                <div class="item">

                                    <div class="category-banner-box p-3 bg-white rounded shadow-sm" itemscope
                                        itemtype="https://schema.org/CollectionPage">

                                        <meta itemprop="name" content="{{ $category->name }}">

                                        <div class="row">

                                            <!-- Left Image -->
                                            <div class="col-md-6 d-flex justify-content-center align-items-center"
                                                style="min-height:190px;">
                                                <div class="cat-left text-center">

                                                    <a class="lightbox d-block mb-2"
                                                        href="{{ route('products.category', $category->id) }}"
                                                        itemprop="url">
                                                        <img class="img-fluid lazyload scale-on-hover"
                                                            data-src="{{ asset($category->icon) }}"
                                                            alt="{{ $category->name }}" itemprop="image"
                                                            style="max-height:140px;" loading="lazy">
                                                    </a>

                                                    <a class="font-weight-bold text-dark h6 d-block"
                                                        href="{{ route('products.category', $category->id) }}"
                                                        title="{{ $category->name }}" itemprop="name">
                                                        {{ $category->name }}
                                                    </a>

                                                </div>
                                            </div>

                                            <!-- Right – Subcategories -->
                                            <div class="col-md-6 mt-3">
                                                <ul class="category-list pl-3">

                                                    @foreach ($category->subcategories as $subcategory)
                                                        <li itemprop="hasPart" itemscope
                                                            itemtype="https://schema.org/CollectionPage">
                                                            <a href="{{ route('products.subcategory', $subcategory->id) }}"
                                                                title="{{ $subcategory->name }}" itemprop="url">
                                                                <span itemprop="name">{{ $subcategory->name }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>
        </section>




        <section class="newSale py-3">
            <div class="container">
                <div class="row g-3"> <!-- Bootstrap gutter -->
                    @foreach (\App\Models\Banner::all() as $banner)
                        <div class="col-md-6 mb-4">
                            <div class="innerSale rounded shadow-sm overflow-hidden">
                                <a href="{{ $banner->url }}" target="_blank" rel="nofollow noopener">
                                    <img class="img-fluid lazyload w-100" data-src="{{ asset($banner->photo) }}"
                                        alt="{{ $banner->title ?? 'Shundorjo.com — Shine Naturally, Shop Confidently.' }}"
                                        loading="lazy">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>




        <section class="py-1">
            <div class="container-fluid">
                <div class="col-md-12 text-center">
                    <h1 class="mb-0 titlePro " style="font-size:medium;">Our Most Popular Brand</h1>

                </div>
                <div class="slider slider-nav px-3" id="brand">
                    @foreach (\App\Models\Brand::where('featured', 1)->latest('id')->take(16)->get() as $brand)
                        <a href="{{ route('products.brand', $brand->id) }}">
                            <div class="d-flex justify-content-center ml-1 mr-2 ">
                                <img data-src="{{ asset($brand->logo) }}" class="img-fluid lazyload"
                                    style="border-radius: 10px;
                    box-shadow: 2px 2px 2px 2px rgb(0 0 0 / 20%);"
                                    alt="{{ $brand->name }}" loading="lazy">
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="col-md-12 text-center">
                    <button class="btn-visible"><a href="{{ route('brands.all') }}"> Load More Brand
                        </a></button>
                </div>
            </div>
        </section>
        {{-- shipping system --}}
        <section class="delivery  py-3 " style="background-color: #6B21A8; color:#ffffff;">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 d-flex">
                        <div> <i class="iconify mr-3" data-icon="bi:patch-check" width="30px;"></i></div>
                        <div class="content">
                            <h5 class="title mb-0 text-logo font-weight-bold">100% AUTHENTIC<small> PRODUCTS</small></h5>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex">
                        <div><span class="iconify mr-3" data-icon="bi:gift"></span> </div>
                        <div class="content">
                            <h5 class="title mb-0 text-logo font-weight-bold">5000+ BEAUTY <small>PRODUCTS</small></h5>

                        </div>
                    </div>

                    <div class="col-md-3 d-flex">
                        <div><span class="iconify mr-3" data-icon="bi:magic"></span></div>
                        <div class="content">
                            <h5 class="title mb-0 text-logo font-weight-bold">FREE BEAUTY <small>CONSULTATION</small></h5>

                        </div>
                    </div>

                    <div class="col-md-3 d-flex">
                        <div><span class="iconify mr-3" data-icon="bi:repeat"></span> </div>
                        <div class="content">
                            <h5 class="title mb-0 text-logo font-weight-bold">07 DAYS RETURN <small>POLYCE</small></h5>

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <section class="py-4 border-top">
            <div class="container">
                <p class="mb-0">
                    @php
                        $generalsetting = \App\Models\GeneralSetting::first();
                    @endphp
                    {!! $generalsetting->home_description !!}


                </p>

            </div>
        </section>
    @endsection
    @section('script')
        {{-- timmer  --}}
        {{-- <script src="{{asset('frontend/js/timmer.js')}}"></script>

<script>
    ;(function($) {

     var MERCADO_JS = {
       init: function(){
          this.mercado_countdown();

       },
     mercado_countdown: function() {
          if($(".mercado-countdown").length > 0){
                 $(".mercado-countdown").each( function(index, el){
                   var _this = $(this),
                   _expire = _this.data('expire');
                _this.countdown(_expire, function(event) {
                         $(this).html( event.strftime('<span><b>%D</b> Days</span> <span><b>%-H</b> Hrs</span> <span><b>%M</b> Mins</span> <span><b>%S</b> Secs</span>'));
                     });
                 });
          }
       },

    }

       window.onload = function () {
          MERCADO_JS.init();
       }

       })(window.Zepto || window.jQuery, window, document);
 </script> --}}
        {{-- timmer  --}}

        <script>
            $('.slider').slick({
                arrows: true,
                infinite: true,
                slidesToShow: 3,
                accessibility: true,
                autoplay: false,
                autoplaySpeed: 3000,
                prevArrow: "<span class='arrow prev'><i class='fa fa-angle-left'></i></span>",
                nextArrow: "<span class='arrow next'><i class='fa fa-angle-right'></i></span>",
                customPaging: function(slider, i) {
                    /* ADDING CUSTOM PAGING
                             Example
                             return  return '<li>Something you want to insert</li>';
                     */
                },
                responsive: [{
                        breakpoint: 1920,
                        settings: {
                            slidesToShow: 6,
                            slidesToScroll: 1,
                            infinite: true,
                            // dots: true
                        }
                    },
                    {
                        breakpoint: 1440,
                        settings: {
                            slidesToShow: 6,
                            slidesToScroll: 1,
                            infinite: true,
                            // dots: true
                        }
                    },
                    {
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            infinite: true,
                            // dots: true
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 425,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 375,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },

                ]
            });
        </script>
        <script type="text/javascript">
            cartQuantityInitialize();
            $('#option-choice-form input').on('change', function() {
                getVariantPrice();
            });
        </script>
        <script>
            baguetteBox.run('.grid-gallery', {
                animation: 'slideIn'
            });
        </script>
        <script type="application/ld+json">
{
 "@context": "https://schema.org",
 "@type": "BreadcrumbList",
 "itemListElement": [{
   "@type": "ListItem",
   "position": 1,
   "name": "Home",
   "item": "{{ url('/') }}"
 }]
}
</script>
        <script type="application/ld+json">
{
 "@context": "https://schema.org",
 "@type": "Organization",
 "name": "Shundorjo",
 "url": "https://www.shundorjo.com",
 "logo": "{{ asset('logo.png') }}"
}
</script>
    @endsection
