@extends('frontend.layouts.app')

@section('content')
    <section class="slider-main">
        <div class="home-slide">
            <div class="home-slide">
                <div class="slick-carousel" data-slick-arrows="true" data-slick-dots="true" data-slick-autoplay="true">

                    @foreach (\App\Models\Slider::where('published', 1)->get() as $key => $slider)
                        <div class="" style="height:500px;">
                            <img class="d-block w-100 h-100" src="{{ asset($slider->photo) }}" alt="Slider Image">
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                @foreach (\App\Models\Banner::where('published', 1)->get() as $key => $banner)
                    <div class="col-lg-4">
                        <div class="media-banner mb-3 mb-lg-0">
                            <a href="{{ $banner->url }}" target="_blank" class="banner-container" style="background-image:url('{{ asset($banner->photo) }}');"></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="home-brand">
        <div class="container">
            <!-- Featured Brand -->
            <div class="wrap-banner style-twin-default">
                <div class="featured_brand">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section_title">
                                <h2>{{ __('Featured Brand') }}</h2>
                            </div>
                        </div>
                    </div>
                    @if (isset($feature_brands))
                        <div class="row">
                            @foreach($feature_brands as $feature_brand)
                                <div class="col-lg-3 col-sm-4 col-6">
                                    <div class="featured_item">
                                        <a href="{{ route('products.brand',$feature_brand->brand_id) }}">
                                            <img class="img-fluid" src="{{ asset($feature_brand->image) }}" alt="">
                                            <div class="featured_text">
                                                <h4>{{ $feature_brand->title }}</h4>
                                                <p> {!! str_limit(strip_tags($feature_brand->description),80) !!}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @php
        $flash_deal = \App\Models\FlashDeal::where('status', 1)->first();
    @endphp

    @if($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date)
        <section class="slice gry-bg">
            <div class="container">
                <div class="section-title section-title--style-1">
                    <h3 class="section-title-inner heading-4 strong-700 text-capitalize">
                        <span class="mr-4">{{__('Flash Deal')}}</span>
                        <small class="countdown countdown-sm d-inline-block" data-countdown-date="{{ date('m/d/Y', $flash_deal->end_date) }}" data-countdown-label="hide"></small>
                    </h3>
                </div>
                <div class="caorusel-box">
                    <div class="slick-carousel" data-slick-items="5" data-slick-lg-items="3"  data-slick-md-items="2" data-slick-sm-items="2" data-slick-xs-items="1">
                        @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                            @php
                                $product = \App\Models\Product::find($flash_deal_product->product_id);
                            @endphp
                            @if ($product != null)
                                <div class="product-card-2 card card-product m-2 shop-cards shop-tech">
                                    <div class="card-body p-0">

                                        <div class="card-image">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block" style="background-image:url('{{ asset($product->flash_deal_img) }}');">
                                            </a>
                                        </div>

                                        <div class="p-3">
                                            <div class="price-box">
                                                @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                    <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                                @endif
                                                <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                            </div>
                                            <h2 class="product-title p-0 mt-2 text-truncate-2">
                                                <a href="{{ route('product', $product->slug) }}">{{ __($product->name) }}</a>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (\App\Models\BusinessSetting::where('type', 'best_selling')->first()->value == 1)
        <section class="bg-white py-5">
            <div class="container">
                <div class="section-title-1 clearfix">
                    <h3 class="heading-5 strong-700 mb-0 float-left">
                        <span class="mr-4">{{__('Best Selling')}}</span>
                    </h3>
                    <ul class="inline-links float-right">
                        <li><a  class="active">{{__('Top 20')}}</a></li>
                        {{-- <li><a href="" >Category name</a></li>
                        <li><a href="" >Category name</a></li>
                        <li><a href="" >Category name</a></li> --}}
                    </ul>
                </div>
                <div class="caorusel-box">
                    <div class="slick-carousel" data-slick-items="3" data-slick-lg-items="3"  data-slick-md-items="2" data-slick-sm-items="2" data-slick-xs-items="1" data-slick-dots="true" data-slick-rows="2">
                        @foreach (filter_products(\App\Models\Product::where('published', 1)->orderBy('num_of_sale', 'desc'))->limit(20)->get() as $key => $product)
                            <div class="p-2">
                                <div class="row no-gutters product-box-2">
                                    <div class="col-4">
                                        <div class="position-relative overflow-hidden h-100">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block product-image h-100" style="background-image:url('{{ asset($product->thumbnail_img) }}');">
                                            </a>
                                            <div class="product-btns">
                                                <button class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})">
                                                    <i class="la la-heart-o"></i>
                                                </button>
                                                <button class="btn add-compare" title="Add to Compare" onclick="addToCompare({{ $product->id }})">
                                                    <i class="la la-refresh"></i>
                                                </button>
                                                <button class="btn quick-view" title="Quick view" onclick="showAddToCartModal({{ $product->id }})">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8 border-left">
                                        <div class="p-3">
                                            <h2 class="product-title mb-3 p-0 text-truncate-2">
                                                <a href="{{ route('product', $product->slug) }}">{{ __($product->name) }}</a>
                                            </h2>
                                            <div class="clearfix">
                                                <div class="price-box float-left">
                                                    @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                        <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                                    @endif
                                                    <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                                </div>
                                                <div class="float-right">
                                                    <button class="add-to-cart btn" title="Add to Cart" onclick="showAddToCartModal({{ $product->id }})">
                                                        <i class="la la-shopping-cart"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @foreach (\App\Models\HomeCategory::where('status', 1)->get() as $key => $homeCategory)
        <section class="gry-bg py-5">
            <div class="container">
                <div class="section-title-1 clearfix">
                    <h3 class="heading-5 strong-700 mb-0 float-left">
                        <span class="mr-4">{{ $homeCategory->category->name }}</span>
                    </h3>
                    <ul class="inline-links float-right nav d-none d-lg-inline-block">
                        @foreach (json_decode($homeCategory->subsubcategories) as $key => $subsubcategory)
                            @if (\App\Models\SubSubCategory::find($subsubcategory) != null)
                                <li class="@php if($key == 0) echo 'active'; @endphp"><a href="#subsubcat-{{ $subsubcategory }}" data-toggle="tab" class="@php if($key == 0) echo 'active'; @endphp">{{ \App\SubSubCategory::find($subsubcategory)->name }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="tab-content">
                    @foreach (json_decode($homeCategory->subsubcategories) as $key => $subsubcategory)
                        @if (\App\Models\SubSubCategory::find($subsubcategory) != null)
                            <div class="tab-pane fade @php if($key == 0) echo 'show active'; @endphp" id="subsubcat-{{ $subsubcategory }}">
                                <div class="row">
                                    @foreach (filter_products(\App\Models\Product::where('published', 1)->where('subsubcategory_id', $subsubcategory))->limit(4)->get() as $key => $product)
                                        <div class="col-lg-3 col-md-6">
                                            <div class="product-box-2 bg-white alt-box">
                                                <div class="position-relative overflow-hidden">
                                                    <a href="{{ route('product', $product->slug) }}" class="d-block product-image h-100" style="background-image:url('{{ asset($product->thumbnail_img) }}');" tabindex="0">
                                                    </a>
                                                    <div class="product-btns clearfix">
                                                        <button class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})" tabindex="0">
                                                            <i class="la la-heart-o"></i>
                                                        </button>
                                                        <button class="btn add-compare" title="Add to Compare" onclick="addToCompare({{ $product->id }})" tabindex="0">
                                                            <i class="la la-refresh"></i>
                                                        </button>
                                                        <button class="btn quick-view" title="Quick view" onclick="showAddToCartModal({{ $product->id }})" tabindex="0">
                                                            <i class="la la-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="p-3 border-top">
                                                    <h2 class="product-title mb-3 p-0 text-truncate-2">
                                                        <a href="{{ route('product', $product->slug) }}" tabindex="0">{{ __($product->name) }}</a>
                                                    </h2>
                                                    <div class="clearfix">
                                                        <div class="price-box float-left">
                                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                                <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                                            @endif
                                                            <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                                        </div>
                                                        <div class="float-right">
                                                            <button class="add-to-cart btn" title="Add to Cart" onclick="showAddToCartModal({{ $product->id }})" tabindex="0">
                                                                <i class="la la-shopping-cart"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="section-title-1 clearfix">
                        <h3 class="heading-5 strong-700 mb-0 float-left">
                            <span class="mr-4">{{__('Top Selling Products')}}</span>
                        </h3>
                    </div>
                    <div class="pt-3 row">
                        @foreach (filter_products(\App\Models\Product::where('published', 1)->orderBy('num_of_sale', 'desc'))->limit(4)->get() as $key => $product)
                            <div class="mb-4 product-box-3 col-md-6 col-lg-12">
                                <div class="clearfix">
                                    <div class="product-image float-left">
                                        <a href="{{ route('product', $product->slug) }}" style="background-image:url('{{ asset($product->thumbnail_img) }}');"></a>
                                    </div>
                                    <div class="product-details float-left">
                                        <h4 class="title text-truncate-2">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block">{{ __($product->name) }}</a>
                                        </h4>
                                        <div class="price-box">
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                            @endif
                                            <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="section-title-1 clearfix">
                        <h3 class="heading-5 strong-700 mb-0 float-left">
                            <span class="mr-4">{{__('Featured Products')}}</span>
                        </h3>
                    </div>
                    <div class="pt-3 row">
                        @foreach (filter_products(\App\Models\Product::where('published', 1)->where('featured', '1'))->limit(4)->get() as $key => $product)
                            <div class="mb-4 product-box-3 col-md-6 col-lg-12">
                                <div class="clearfix">
                                    <div class="product-image float-left">
                                        <a href="{{ route('product', $product->slug) }}" style="background-image:url('{{ asset($product->featured_img) }}');"></a>
                                    </div>
                                    <div class="product-details float-left">
                                        <h4 class="title text-truncate-2">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block">{{ __($product->name) }}</a>
                                        </h4>
                                        <div class="price-box">
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                            @endif
                                            <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="section-title-1 clearfix">
                        <h3 class="heading-5 strong-700 mb-0 float-left">
                            <span class="mr-4">{{__('Todays Deal')}}</span>
                        </h3>
                    </div>
                    <div class="pt-3 row">
                        @foreach (filter_products(\App\Models\Product::where('published', 1)->where('todays_deal', '1'))->limit(4)->get() as $key => $product)
                            <div class="mb-4 product-box-3 col-md-6 col-lg-12">
                                <div class="clearfix">
                                    <div class="product-image float-left">
                                        <a href="{{ route('product', $product->slug) }}" style="background-image:url('{{ asset($product->thumbnail_img) }}');"></a>
                                    </div>
                                    <div class="product-details float-left">
                                        <h4 class="title text-truncate-2">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block">{{ __($product->name) }}</a>
                                        </h4>
                                        <div class="price-box">
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                            @endif
                                            <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
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

    <!-- top brand -->
    <section class="top_brand gry-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_title">
                        <h2>{{ __('Top Brand') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach( \App\Models\Brand::latest()->take(8)->get() as $brand)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                        <div class="top_brand_img">
                            <a href="{{ route('products.brand', $brand->id) }}"><img src="{{ asset($brand->logo) }}" alt=""></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--End top brand -->

@endsection
