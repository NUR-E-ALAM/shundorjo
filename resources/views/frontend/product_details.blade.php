@extends('frontend.layouts.app')
@section('title')
{{ $product->name }} Price in Bangladesh {{ date('Y') }} | Original {{ $product->brand->name ?? '' }} - Shundorjo
    @stop
@section('css')
<style>
    a.wp.btn {
        background-color: #25d366 !important;
        color: white !important;
        border-color: #25d366 !important;
    }
    .guaranteed-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 120px;
    height: auto;
    z-index: 5;
}
.guaranteed-badge {
    filter: drop-shadow(0 2px 6px rgba(0,0,0,.3));
}
@media (max-width: 576px) {
    .guaranteed-badge {
        width: 90px;
        top: 6px;
        right: 6px;
    }
}
.product-image-wrapper {
    position: relative;
    display: inline-block;
}

.watermark-badge {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80%;              /* full product cover feel */
    opacity: 0.12;           /* watermark effect */
    pointer-events: none;    /* don't zoom/click block  */
    z-index: 4;
}
.product-image-wrapper::after {
    content: "";
    background: url('{{ asset('frontend/images/watermark.png') }}') center/contain no-repeat;
    opacity: 0.1;
    position: absolute;
    inset: 0;
    pointer-events: none; /* ✅ THIS IS THE FIX */
}
</style>
<link rel="preload" as="image" href="{{ asset($product->photos_array[0]) }}">
@endsection
@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $product->meta_title }}">
    <meta name="description" content="Buy {{ $product->name }} original {{ $product->brand->name ?? '' }} in Bangladesh at best price. ✔ Cash on Delivery ✔ 100% Authentic ✔ Fast Delivery. Order now from Shundorjo!">
    <meta itemprop="image" content="{{ asset($product->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $product->meta_title }}">
    <meta name="twitter:description" content="{{ $product->name }} original {{ $product->brand->name ?? '' }} available in Bangladesh at best price. Order now with cash on delivery from Shundorjo.">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ asset($product->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($product->unit_price) }}">
    <meta name="twitter:label1" content="Price">
    <meta name="twitter:label2" content="Brand">
    <meta name="twitter:data2" content="{{ $product->brand->name ?? 'N/A' }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $product->meta_title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ route('product', $product->slug) }}" />
    <meta property="og:image" content="{{ asset(@$product->meta_img) }}" />
    <meta property="og:description" content="{{ $product->name }} original {{ $product->brand->name ?? '' }} available in Bangladesh at best price. Order now with cash on delivery from Shundorjo." />
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
    <meta property="og:price:amount" content="{{ single_price($product->unit_price) }}" />

@endsection

@section('content')

    <section class="siteBreadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="facl facl-angle-right"><a href="{{ route('home') }}">Home</a></li>
                    <li class="facl facl-angle-right"><a
                            href="{{ route('categories.all') }}">{{ __('All Categories') }}</a></li>
                    @if ($product->category_id != null)
                        <li class="facl facl-angle-right"><a
                                href="{{ route('products.category', $product->category_id) }}">{{ $product->category->name }}</a>
                        </li>
                    @endif
                    @if ($product->subcategory_id != null)
                        <li class="facl facl-angle-right"><a
                                href="{{ route('products.subcategory', $product->subcategory_id) }}">{{ $product->subcategory->name }}</a>
                        </li>
                    @endif
                    @if ($product->subsubcategory_id != null)
                        <li class="facl facl-angle-right"><a
                                href="{{ route('products.subsubcategory', $product->subsubcategory_id) }}">{{ $product->subsubcategory?->name }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ __($product->name) }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="productDetails py-2">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="product-gal sticky-top d-flex flex-row-reverse">
                        <div class="product-gal-img product-image-wrapper" >

                            @if(isset($product->photos_array))
                            <img class="xzoom img-fluid" src="{{ isset($product->photos_array[0]) ? asset($product->photos_array[0]) : asset('default-photo.jpg') }}"
                                xoriginal="{{ isset($product->photos_array[0]) ? asset($product->photos_array[0]) : asset('default-photo.jpg') }}" loading="eager"
     fetchpriority="high" alt="Buy {{ $product->name }} original {{ $product->brand->name ?? '' }} in Bangladesh" />

    <img src="{{ asset('frontend/images/guaranteed.png') }}"
         class="guaranteed-badge"
         alt="Guaranteed Product">

                                @endif
                        </div>
                        <div class="product-gal-thumb">
                            <div class="xzoom-thumbs">
                                @if(isset($product->photos_array))
                              @foreach ($product->photos_array as $key => $photo)
    <a href="{{ asset($photo) }}">
        <img class="xzoom-gallery"
             width="60"
             height="60"
             loading="lazy"
             src="{{ asset($photo) }}">
    </a>
@endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <h1 class="text-dark font-weight-bold product-font-size">{{ __($product->name) }}
                        <br>
                        @php
                            $qty = 0;
                            foreach ($product->variations_array as $key => $variation) {
                                 $qty += $variation['qty'] ?? 0;
                            }
                        @endphp

                            @if (count($product->variations_array) >= 1)
                                @if ($qty > 0)
                                    <span class="badge badge-md badge-pill bg-green">{{ __('In stock') }}</span>
                                @else
                                    <span class="badge badge-md badge-pill bg-red">{{ __('Out of stock') }}</span>
                                @endif
                            @else
                            @if ($product->is_stock==1)
                                <span class="badge badge-md badge-pill bg-green">{{ __('In stock') }}</span>
                                @else
                                <span class="badge badge-md badge-pill bg-red">{{ __('Out of stock') }}</span>
                            @endif
                            @endif


                    </h1>
                    @if (count($product->variations_array) >= 1)
                        <div class="avialable-amount">({{ $qty }} {{ __('available') }})</div>
                    @endif

                    <div class="d-flex flex-wrap">
                        @if (home_price($product->id) != home_discounted_price($product->id))
                            <h5 class="price text-dark">
                               {{ __('Price') }}:
                                <del>
                                    {{ home_price($product->id) }}
                                    @if (!@empty($product->unit))
                                        <span>/{{ $product->unit }}</span>
                                    @endif
                                </del>
                            </h5>
                            <h5 class="price text-dark">
                                <!--{{ __('Discount Price') }}:-->
                                <div class="product-price" style="margin-left: 10px; color: #ff3d71;">
                                    <strong>
                                        {{ home_discounted_price($product->id) }}
                                    </strong>
                                    @if (!@empty($product->unit))
                                        <span class="piece">/{{ $product->unit }}</span>
                                    @endif
                                </div>
                            </h5>
                        @else
                            <h5 class="price" style="margin-right: 100px; color:#ff3d71;">
                                {{ __('Price') }}:
                                <strong>
                                    {{ home_discounted_price($product->id) }}
                                </strong>
                                @if (!@empty($product->unit))
                                    <span class="piece">/{{ $product->unit }}</span>
                                @endif
                            </h5>


                        @endif
                        @if(isset($product->reviews) && $product->reviews->isNotEmpty())
                         <div class="review d-flex flex-wrap justify-content-center align-items-center">
                            <span>
                                <i class="iconify" data-icon="codicon:star-full"></i>
                                <i class="iconify" data-icon="codicon:star-full"></i>
                                <i class="iconify" data-icon="codicon:star-full"></i>
                                <i class="iconify" data-icon="codicon:star-full"></i>
                                <i class="iconify" data-icon="codicon:star-full"></i>
                            </span>
                            <span class="text-dark ml-2">(@php echo count($product->reviews) @endphp reviews)</span>
                        </div>

                        @endif
                    </div>
                    <style>
                        .ullisthid li {
                            list-style: inside !important;
                        }

                    </style>
                    <div class="ullisthid">
                        <p >{!! $product->short_description !!} </p>
                    </div>


                    {{-- form start --}}
                    <form id="option-choice-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <div class="row no-gutters pb-3 d-none" id="chosen_price_div">
                            <div class="col-2">
                                <div class="product-description-label">{{ __('Total Price') }}:</div>
                            </div>
                            <div class="col-10">
                                <div class="product-price">
                                    <strong id="chosen_price">

                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div>
                            @if (count($product->colors_array) > 0)
                                <small class="font-weight-bold text-uppercase text-dark"> Color:
                                    <span id="colorName" class="text-capitalize"></span>
                                </small>
                                <div class="variationSec my-2">
                                    <!-- color 1 -->
                                    @foreach ($product->colors_array as $key => $color)
                                        <input type="radio" class="variation"
                                            id="{{ $product->id }}-color-{{ $key }}" name="color"
                                            value="{{ $color }}">
                                        <label for="{{ $product->id }}-color-{{ $key }}" title="grey"
                                            style="background: {{ $color }};">
                                            <div class="setColor" style="background: {{ $color }};"
                                                onclick="catchColor(event);"></div>
                                        </label>
                                    @endforeach

                                </div>
                            @endif

                           @foreach ($product->choice_options_array as $choice)
    <small class="font-weight-bold text-uppercase text-dark">
        {{ data_get($choice, 'title') }}:
    </small>

    <div class="variationSize my-2">
        @foreach (data_get($choice, 'options', []) as $option)
            <input type="radio" name="{{ data_get($choice, 'name') }}" value="{{ $option }}">
            <label>{{ $option }}</label>
        @endforeach
    </div>
@endforeach
                            <div class="addCarts">
                                <div class="row mr-1">
                                    <div class="col-6 col-md-4 col-sm-6 mt-2 pr-0">
                                        <div class="carts">
                                            <span class="m">
                                                <button aria-label="Minus Quantity" class="btn btn-number" type="button" data-type="minus"
                                                    data-field="quantity" disabled="disabled">
                                                    <i class="la la-minus"></i>
                                                </button>
                                            </span>
                                            <input type="text" name="quantity" class="form-control input-number text-center"
                                                placeholder="1" value="1" min="1" max="100">
                                            <span class="input-group-btn">
                                                <button aria-label="Plus Quantity" class="btn btn-number" type="button" data-type="plus"
                                                    data-field="quantity">
                                                    <i class="la la-plus"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-6 col-md-4 col-sm-6 mt-2  pr-0">
                                        @php
                                            $generalsetting = \App\Models\GeneralSetting::first();

                                            $price = home_discounted_price($product->id);
                                            $url = route('product', $product->slug);
                    $detailsInfo = $product->name.", \r\n Price : $price , \r\n URL : $url";


                                        @endphp
                                        <div class="text-secondary" id="colFour">
                                            @if ($generalsetting->phone != null)
                                                <a class="btn btn-outline btn-base-1 strong-800 w-100 wp"
                                                    href="https://api.whatsapp.com/send/?phone=880{{ $generalsetting->phone }}&text={{$detailsInfo}}&type=phone_number&app_absent=0" target="_blank" rel="noopener noreferrer" title="Whatsapp Massage Only">
                                                    <i class="la la-whatsapp"></i>
                                                    <span class="d-md-inline-block"> {{ $generalsetting->phone }}</span>

                                                </a>
                                                <small style="color:#eb232d;">⚡ Instant order via WhatsApp</small>
                                            @else
                                                <a class="btn btn-outline btn-base-1 strong-800 wp" href="https://api.whatsapp.com/send/?phone=88001882542525&text={{$detailsInfo}}&type=phone_number&app_absent=0">
                                                    <i class="la la-whatsapp"></i>
                                                    01882542525

                                                </a>
                                                <small style="color:#25d366;">⚡ Instant order via WhatsApp</small>
                                            @endif

                                        </div>
                                    </div>
                                </div>



                            </div>
                    </form>
                    {{-- form close --}}
                </div>
                <div>
                    <div class="row mr-1">
                        <div class="col-md-6 col-sm-6 mt-2 pr-0">
                            @if (count($product->variations_array) >= 1)
                            @if ($qty <= 0)
                            <button aria-label="Add to Cart" class="addCartBtn" disabled title="This Product Out of stock at this moment">Add to Cart</button>
                            @else
                            <button class="addCartBtn" aria-label="Add to Cart" onclick="addToCart()">Add to Cart</button>
                            @endif
                        @else
                        @if ($product->is_stock==0)
                        <button class="addCartBtn" disabled aria-label="Add to Cart" title="This Product Out of stock at this moment">Add to Cart</button>
                        @else
                        <button class="addCartBtn" onclick="addToCart()" aria-label="Add to Cart">Add to Cart</button>
                        @endif

                        @endif


                        </div>
                        <div class="col-md-6 col-sm-6 mt-2 pr-0">
                            @if (count($product->variations_array) >= 1)
                            @if ($qty <= 0)
                            <button class="buyNowBtn" disabled title="This Product Out of stock at this moment" aria-label="Stok Out">Stock Out</button>
                            @else
                            <button class="buyNowBtn" aria-label="Order Now" onclick="buyNow({{$product->id}})">Order Now</button>
                            @endif
                        @else
                        @if ($product->is_stock==0)
                        <button class="buyNowBtn" disabled title="This Product Out of stock at this moment" aria-label="Stock Out">Stock Out</button>
                        @else
                        <button class="buyNowBtn" aria-label="Order Now" onclick="buyNow({{$product->id}})">Order Now</button>
                        @endif

                        @endif


                        </div>

                                <div class="col-6 col-sm-6 col-md-6 mt-2 pr-0">
                            <!-- Add to wishlist button -->
                            <button type="button" aria-label="Wishlist" class="btn btn-outline btn-base-1 btn-icon-left w-100"
                                onclick="addToWishList({{ $product->id }})">
                                <i class="la la-heart-o"></i>
                                <span class="d-md-inline-block"> {{ __('Add to wishlist') }}</span>
                            </button>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 mt-2 pr-0">
                            <!-- Add to compare button -->
                            <button type="button" aria-label="Add to Compare" class="btn btn-outline btn-base-1 btn-icon-left w-100"
                                onclick="addToCompare({{ $product->id }})">
                                <i class="la la-refresh"></i>
                                <span class="d-md-inline-block"> {{ __('Add to Compare') }}</span>
                            </button>

                      </div>
                    </div>
                </div>
                <hr style="padding-bottom: 10px">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
<div class="product_meta">
                    @if(!@empty($product->brand_id))
                    <span class="brand_in">
                        <span class="">Brand:</span>
                        <a
                            href="{{ route('search', ['slug' => Str::slug($product->brand->name),'brand_id' => $product->brand_id]) }}">{{ $product->brand->name }}</a>
                    </span>
                    @endif
                    <br>
                    <span class="sku_wrapper">
                        <span class=""> SKU: </span>
                        <span class="sku value cg d-inline-block">{{ $product->prescribed }}</span>
                    </span>
                    <br>
                    <span class="posted_in">
                        <span class="">Categories:</span>
                        <a href="{{ route('search', ['slug' => Str::slug($product->subsubcategory?->name),'subsubcategory_id' => $product->subsubcategory_id]) }}">{{ $product->subsubcategory?->name }}</a>
                    </span>
                    <br>


                    <span class="tagged_as"><span class=""> Tags:</span>
                    @php
                    $tags = explode(',', $product->tags);
                @endphp

                @foreach ($tags as $tag)
                    <a href="{{ url('product-tags',Str::slug($tag)) }}">{{ trim($tag) }}</a>{{ !$loop->last ? ',' : '' }}
                @endforeach
                    </span>
                </div>
                    </div>
                     <div class="col-xs-12 col-sm-12 col-md-6 ">
<div class="p-details-contact-section">
                                <div class="justify-content-between">
                                        <p><i class="fa fa-motorcycle"></i> Inside Dhaka: 1-2 working days</p>
                                        <p><i class="fa fa-truck"></i> Outside Dhaka: 2-4 working days</p>
                                        <p><i class="fa fa-money"></i> Full Cash on Delivery Available</p>
                                        <p><i class="fa fa-refresh"></i> Refund : Within 7 Days <a
                                href="{{ route('returnpolicy') }}" target="__blank">Returns Policy</a></p>

                                </div>
                                <div class="pay-method mb-3">
                                    <span>Payment</span>
                                    <img src="{{ asset('frontend/images/payment.jpg') }}" style="width:300px" alt="Payment Methods">
                                </div>
                            </div>
                    </div>
                </div>
                <hr style="padding-bottom: 10px">
                <div style="text-align:center;" class="sharethis-inline-share-buttons"></div>
                <hr style="padding-bottom: 10px">

            </div>
        </div>
        </div>
    </section>

    <section>

        <div class="container container_des">
            <div class="row productView">
                <div class="col-xl-3 d-none d-xl-block">
                    <div class="seller-top-products-box bg-white sidebar-box mb-3">
                        <div class="box-title text-uppercase text-white" style="background: #ff3d71">
                            {{ __('Top Selling Products') }}
                        </div>
                        <div class="box-content">
                            @foreach (filter_products(\App\Models\Product::where('category_id', $product->category_id)->orderBy('num_of_sale', 'desc'))->limit(5)->get()
        as $key => $top_product)
                                <div class="mb-3 product-box-3 myDIV">
                                          <!-- for Google -->
                                                 @php
    $priceNumber = home_discounted_base_price_raw($top_product->id);
@endphp
                <meta itemprop="sku" content="{{ $top_product->prescribed }}">
                <meta itemprop="brand" content="Shundorjo">
                <meta itemprop="name" content="{{ $top_product->name }}">
                <meta itemprop="image" content="{{ asset($top_product->thumbnail_img) }}">
                <meta itemprop="description" content="{{ Str::limit(strip_tags($top_product->description), 150) }}">
    <meta itemprop="price" content="{{ $priceNumber }}">
    <meta itemprop="priceCurrency" content="BDT">
    <meta itemprop="availability" content="https://schema.org/{{ $top_product->is_stock ? 'InStock' : 'OutOfStock' }}">
                                    <div class="clearfix">
                                        <div class="product-image float-left">
                                            <a href="{{ route('product', $top_product->slug) }}">


                                                  @if($top_product->thumbnail_webp && file_exists(public_path($top_product->thumbnail_webp)))
    <img class="lazyload"
        data-src="{{ asset($top_product->thumbnail_webp) }}"
        alt="{{ $top_product->name }}"
        width="90" height="90">
@else
    <img class="lazyload"
        data-src="{{ asset($top_product->thumbnail_img) }}"
        alt="{{ $top_product->name }}"
        width="90" height="90">
@endif
                                                </a>
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
                                            <button aria-label="Order Now" class="buyNowBtn" onclick="buyNow({{$top_product->id}})">Order Now</button>
                                            @else
                                            <button aria-label="Stock Out" class="buyNowBtn">Stock Out</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="product-desc-tab bg-white">
                        <style>
                            #tab_default_1 li {
                                list-style: inside !important;
                            }

                        </style>

                        <div class="tabs tabs--style-2">
                            <ul class="nav nav-tabs justify-content-center sticky-top bg-gray">
                                <li class="nav-item">
                                    <a href="#tab_default_1" data-toggle="tab"
                                        class="nav-link text-uppercase strong-600 active show">{{ __('Description') }}</a>
                                </li>
                                @if ($product->video_link != null)
                                    <li class="nav-item">
                                        <a href="#tab_default_2" data-toggle="tab"
                                            class="nav-link text-uppercase strong-600">{{ __('Video') }}</a>
                                    </li>
                                @endif
                                @if ($product->pdf != null)
                                    <li class="nav-item">
                                        <a href="#tab_default_3" data-toggle="tab"
                                            class="nav-link text-uppercase strong-600">{{ __('Downloads') }}</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a href="#tab_default_4" data-toggle="tab"
                                        class="nav-link text-uppercase strong-600">{{ __('Reviews') }}</a>
                                </li>
                                   <li class="nav-item">
                                    <a href="#tab_default_5" data-toggle="tab"
                                        class="nav-link text-uppercase strong-600">{{ __('FAQ') }}</a>
                                </li>
                            </ul>

                            <div class="tab-content pt-0">
                                <!--<div class="tab-pane active show" id="tab_default_1">-->
                                <div class="tab-pane active show" id="tab_default_1">
                                    <div class="row">

                                        <div class="col-md-12">

                                            {!! $product->description !!}
                                             <br> <br>
                                            <p>
Explore more
<a href="{{ route('search', ['slug' => Str::slug($product->subsubcategory?->name),'subsubcategory_id' => $product->subsubcategory_id]) }}">{{ $product->subsubcategory?->name }}</a> products in Bangladesh.
</p>


                                            <p>আরও আপডেট পেতে আমাদের <a class="text-center" href="https://www.facebook.com/shundorjjo" target="_blank" rel="noopener noreferrer">
                                                 Shundorjo.com
                                            </a>
                                            Or
                                            <a class="text-center" href="https://www.facebook.com/shundorjocare" target="_blank" rel="noopener noreferrer">
                                                Shundorjo Care
                                                </a>Facebook পেজ ভিজিট করুন।</p>
                                        </div>
                                    </div>
                                    <span class="space-md-md"></span>

                                </div>

                                <div class="tab-pane" id="tab_default_2">
                                    <div class="fluid-paragraph py-2">
                                        <!-- 16:9 aspect ratio -->
                                        <div class="embed-responsive embed-responsive-16by9 mb-5">
                                            @if ($product->video_provider == 'youtube' && $product->video_link != null)
                                                <iframe class="embed-responsive-item"
                                                    src="{{ $product->video_link }}"></iframe>
                                            @elseif ($product->video_provider == 'dailymotion' && $product->video_link != null)
                                                <iframe class="embed-responsive-item"
                                                    src="https://www.dailymotion.com/embed/video/{{ explode('video/', $product->video_link)[1] }}"></iframe>
                                            @elseif ($product->video_provider == 'vimeo' && $product->video_link != null)
                                                <iframe
                                                    src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $product->video_link)[1] }}"
                                                    width="500" height="281" frameborder="0" webkitallowfullscreen
                                                    mozallowfullscreen allowfullscreen></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_default_3">
                                    <div class="py-2 px-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ asset($product->pdf) }}">{{ __('Download') }}</a>
                                            </div>
                                        </div>
                                        <span class="space-md-md"></span>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_default_4">
                                    <div class="fluid-paragraph py-4">
                                        @foreach ($product->reviews as $key => $review)
                                            <div class="block block-comment">
                                                <div class="block-image">
                                                    @if(isset($review->user->avatar_original))
                                                    <img src="{{ asset($review->user->avatar_original) }}"
                                                        class="rounded-circle">
                                                        @endif
                                                </div>
                                                <div class="block-body">
                                                    <div class="block-body-inner">
                                                        <div class="row no-gutters">
                                                            <div class="col">
                                                                <h3 class="heading heading-6">
                                                                     @if(isset($review->user->name))
                                                                    <a href="javascript:;">{{ $review->user->name }}</a>
                                                                    @endif
                                                                </h3>
                                                                <span class="comment-date">
                                                                    {{ date('d-m-Y', strtotime($review->created_at)) }}
                                                                </span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="rating text-right clearfix d-block">
                                                                    <span class="star-rating float-right">
                                                                        @for ($i = 0; $i < $review->rating; $i++)
                                                                            <i class="fa fa-star"></i>
                                                                        @endfor
                                                                        @for ($i = 0; $i < 5 - $review->rating; $i++)
                                                                            <i class="fa fa-star-o"></i>
                                                                        @endfor
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="comment-text">
                                                            {{ $review->comment }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @if (Auth::check())
                                            @php
                                                $commentable = false;
                                            @endphp
                                            @foreach ($product->orderDetails as $key => $orderDetail)
                                                @if ($orderDetail->order->user_id == Auth::user()->id)
                                                    @php
                                                        $commentable = true;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if ($commentable)
                                                <div class="leave-review">
                                                    <div class="section-title section-title--style-1">
                                                        <h3
                                                            class="section-title-inner heading-6 strong-600 text-uppercase">
                                                            {{ __('Write a review') }}
                                                        </h3>
                                                    </div>
                                                    <form class="form-default" role="form"
                                                        action="{{ route('reviews.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $product->id }}">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for=""
                                                                        class="text-uppercase c-gray-light">{{ __('Your name') }}</label>
                                                                    <input type="text" name="name"
                                                                        value="{{ Auth::user()->name }}"
                                                                        class="form-control" disabled required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for=""
                                                                        class="text-uppercase c-gray-light">{{ __('Email') }}</label>
                                                                    <input type="text" name="email"
                                                                        value="{{ Auth::user()->email }}"
                                                                        class="form-control" required disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="c-rating mt-1 mb-1 clearfix d-inline-block">
                                                                    <input type="radio" id="star5" name="rating" value="5"
                                                                        required />
                                                                    <label class="star" for="star5"
                                                                        title="Awesome" aria-hidden="true"></label>
                                                                    <input type="radio" id="star4" name="rating" value="4"
                                                                        required />
                                                                    <label class="star" for="star4" title="Great"
                                                                        aria-hidden="true"></label>
                                                                    <input type="radio" id="star3" name="rating" value="3"
                                                                        required />
                                                                    <label class="star" for="star3"
                                                                        title="Very good" aria-hidden="true"></label>
                                                                    <input type="radio" id="star2" name="rating" value="2"
                                                                        required />
                                                                    <label class="star" for="star2" title="Good"
                                                                        aria-hidden="true"></label>
                                                                    <input type="radio" id="star1" name="rating" value="1"
                                                                        required />
                                                                    <label class="star" for="star1" title="Bad"
                                                                        aria-hidden="true"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" rows="4" name="comment" placeholder="{{ __('Your review') }}" required></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="text-right">
                                                            <button aria-label="Send Review" type="submit"
                                                                class="btn btn-styled btn-base-1 btn-circle mt-4">
                                                                {{ __('Send review') }}
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                 <div class="tab-pane" id="tab_default_5">
                                    <div class="py-2 px-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Frequently Asked Questions</h3>

<p><strong>Q: {{ $product->name }} price in Bangladesh?</strong><br>
A: Latest price is {{ home_discounted_price($product->id) }}.</p>

<p><strong>Q: Is this product original?</strong><br>
A: Yes, we provide 100% authentic products.</p>
                                            </div>
                                        </div>
                                        <span class="space-md-md"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="my-4 bg-white p-3">
                        <div class="section-title-1 bg-gray">
                            <h3 class="heading-5 strong-700 mb-0 text-white" style="background: #ff3d71">
                                <span class="mr-4 pl-2 text-uppercase">{{ __('Recommended For You') }}</span>
                            </h3>
                        </div>
                        <div class="caorusel-box" style="height: 400px;">

                            <div class="slick-carousel" data-slick-items="4" data-slick-lg-items="4"
                                data-slick-md-items="3" data-slick-sm-items="2" data-slick-xs-items="2">
                                @foreach (filter_products(\App\Models\Product::where('subsubcategory_id', $product->subsubcategory_id)->where('id', '!=', $product->id))->limit(10)->get() as $key => $related_product)
                                    <div class="product-card-2 card card-product shop-cards shop-tech">
                                        <!-- for Google -->
            @php
    $priceNumber = home_discounted_base_price_raw($related_product->id);
@endphp
                    <meta itemprop="name" content="{{ $related_product->name }}">
                    <meta itemprop="sku" content="{{ $related_product->prescribed }}">
                    <meta itemprop="brand" content="Shundorjo">
                    <meta itemprop="url"
                          content="{{ route('product', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $related_product->slug)))) }}">
                <meta itemprop="image" content="{{ asset($related_product->thumbnail_img) }}">
                <meta itemprop="description" content="{{ Str::limit(strip_tags($related_product->description), 150) }}">
    <meta itemprop="price" content="{{ $priceNumber }}">
    <meta itemprop="priceCurrency" content="BDT">
    <meta itemprop="availability" content="https://schema.org/{{ $related_product->is_stock ? 'InStock' : 'OutOfStock' }}">
                                        <div class="card-body p-0">
                                            <div class="card-image">
                 <a href="{{ route('product', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $related_product->slug)))) }}"
   class="d-block"
   @if($related_product->thumbnail_webp && file_exists(public_path($related_product->thumbnail_webp)))
       style="background-image:url('{{ asset($related_product->thumbnail_webp) }}');"
   @else
       style="background-image:url('{{ asset($related_product->thumbnail_img) }}');"
   @endif
>
</a>
                                            </div>
                                            <div class="p-1">
                                                <div class="price-box">
                                                    @if (home_base_price($related_product->id) != home_discounted_base_price($related_product->id))
                                                        <del
                                                            class="old-product-price strong-400">{{ home_base_price($related_product->id) }}</del>
                                                    @endif
                                                    <span
                                                        class="product-price strong-600">{{ home_discounted_base_price($related_product->id) }}</span>
                                                </div>
                                                <h2 class="product-title p-0 mt-2 text-truncate-2">
                                                    <a
                                                        href="{{ route('product', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $related_product->slug)))) }}">{{ __($related_product->name) }}</a>
                                                </h2>
                                            </div>
                                            <div class="mb-2">
                                                @if($related_product->is_stock==1)
                                                <button aria-label="Order Now" class="buyNowBtn" onclick="buyNow({{$related_product->id}})">Order Now</button>
                                                @else
                                                <button aria-label="Stock Out" class="buyNowBtn">Stock Out</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-12">
                    <div class="my-4 bg-white p-3">
                        <div class="section-title-1 bg-gray">
                            <h3 class="heading-5 strong-700 mb-0 text-white" style="background: #ff3d71">
                                <span class="mr-4 pl-2 text-uppercase">{{ $product->brand->name ?? 'N/A' }} {{ __('Just for Your Perfect Elegance') }}</span>
                            </h3>
                        </div>
                        <div class="caorusel-box" style="height: 400px;">
                            <div class="slick-carousel" data-slick-items="5" data-slick-lg-items="5"
                                data-slick-md-items="4" data-slick-sm-items="3" data-slick-xs-items="3">
                                @foreach (filter_products(\App\Models\Product::where('brand_id', $product->brand_id)->where('id', '!=', $product->id))->latest('id')->limit(10)->get() as $key => $related_product)
                                    <div class="product-card-2 card card-product shop-cards shop-tech">
                                           <!-- for Google -->
            @php
    $priceNumber = home_discounted_base_price_raw($related_product->id);
@endphp
                    <meta itemprop="name" content="{{ $related_product->name }}">
                    <meta itemprop="sku" content="{{ $related_product->prescribed }}">
                    <meta itemprop="brand" content="Shundorjo">
                    <meta itemprop="url"
                          content="{{ route('product', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $related_product->slug)))) }}">
                <meta itemprop="image" content="{{ asset($related_product->thumbnail_img) }}">
                <meta itemprop="description" content="{{ Str::limit(strip_tags($related_product->description), 150) }}">
    <meta itemprop="price" content="{{ $priceNumber }}">
    <meta itemprop="priceCurrency" content="BDT">
    <meta itemprop="availability" content="https://schema.org/{{ $related_product->is_stock ? 'InStock' : 'OutOfStock' }}">
                                        <div class="card-body p-0">
                                            <div class="card-image">
                                               <a href="{{ route('product', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $related_product->slug)))) }}"
   class="d-block"
   @if($related_product->thumbnail_webp && file_exists(public_path($related_product->thumbnail_webp)))
       style="background-image:url('{{ asset($related_product->thumbnail_webp) }}');"
   @else
       style="background-image:url('{{ asset($related_product->thumbnail_img) }}');"
   @endif
>
</a>
                                            </div>
                                            <div class="p-1">
                                                <div class="price-box">
                                                    @if (home_base_price($related_product->id) != home_discounted_base_price($related_product->id))
                                                        <del
                                                            class="old-product-price strong-400">{{ home_base_price($related_product->id) }}</del>
                                                    @endif
                                                    <span
                                                        class="product-price strong-600">{{ home_discounted_base_price($related_product->id) }}</span>
                                                </div>
                                                <h2 class="product-title p-0 mt-2 text-truncate-2">
                                                    <a
                                                        href="{{ route('product', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $related_product->slug)))) }}">{{ __($related_product->name) }}</a>
                                                </h2>
                                            </div>
                                            <div class="mb-2">
                                                @if($related_product->is_stock==1)
                                                <button aria-label="Order Now" class="buyNowBtn" onclick="buyNow({{$related_product->id}})">Order Now</button>
                                                @else
                                                <button aria-label="Stock Out" class="buyNowBtn">Stock Out</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection



<script>
requestIdleCallback(() => {
    var script = document.createElement("script");
    script.src = "https://platform-api.sharethis.com/js/sharethis.js#property=60ba46686cfa7d00118e7e92&product=inline-share-buttons";
    script.async = true;
    document.body.appendChild(script);
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const initSlider = () => {
        if ($('.slick-carousel').length) {
            $('.slick-carousel').slick();
        }
    };

    if ('requestIdleCallback' in window) {
        requestIdleCallback(initSlider);
    } else {
        setTimeout(initSlider, 300);
    }
});
</script>
<script type="application/ld+json">
@php

$images = [asset($product->thumbnail_img)];

foreach ($product->photos_array as $photo) {
    if (!empty($photo['photo'])) {
        $images[] = asset($photo['photo']);
    }
}

$data = [
    "@context" => "https://schema.org",
    "@type" => "Product",

    "name" => (string) $product->name,

    "image" => array_values(array_filter($images)),

    "description" => (string) (
        Str::limit(strip_tags($product->description), 150)
        ?: $product->name
    ),

    "sku" => (string) ($product->prescribed ?: $product->id),

    "mpn" => (string) ($product->prescribed ?: $product->id),

    "brand" => [
        "@type" => "Brand",
        "name" => (string) ($product->brand->name ?? 'Shundorjo')
    ],

    "offers" => [
        "@type" => "Offer",

        "url" => url()->current(),

        "priceCurrency" => "BDT",

        "price" => number_format((float)$product->unit_price, 2, '.', ''),

        "availability" => $product->is_stock
            ? "https://schema.org/InStock"
            : "https://schema.org/OutOfStock",

        "itemCondition" => "https://schema.org/NewCondition",

        "seller" => [
            "@type" => "Organization",
            "name" => "Shundorjo"
        ]
    ]
];

if ($product->reviews->count() > 0) {
    $data["aggregateRating"] = [
        "@type" => "AggregateRating",
        "ratingValue" => number_format((float)$product->reviews->avg('rating'), 1, '.', ''),
        "reviewCount" => (int) $product->reviews->count()
    ];
}

@endphp

{!! json_encode(
    $data,
    JSON_UNESCAPED_SLASHES |
    JSON_UNESCAPED_UNICODE |
    JSON_PRETTY_PRINT
) !!}
</script>


