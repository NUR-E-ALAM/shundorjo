@extends('frontend.layouts.app')
@section('title')
    {{ $product->name }} | Shundorjo
@stop
@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $product->meta_title }}">
    <meta itemprop="description" content="{{ $product->meta_description }}">
    <meta itemprop="image" content="{{ asset($product->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $product->meta_title }}">
    <meta name="twitter:description" content="{{ $product->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ asset($product->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($product->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $product->meta_title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ route('product', $product->slug) }}" />
    <meta property="og:image" content="{{ asset($product->meta_img) }}" />
    <meta property="og:description" content="{{ $product->meta_description }}" />
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
    <meta property="og:price:amount" content="{{ single_price($product->unit_price) }}" />
@endsection

@section('content')

    <section class="siteBreadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="facl facl-angle-right"><a href="#">Home</a></li>
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
                    @if ($product->subcategory_id != null)
                        <li class="facl facl-angle-right"><a
                                href="{{ route('products.subsubcategory', $product->subsubcategory_id) }}">{{ $product->subsubcategory->name }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ __($product->name) }}</li>
                </ol>
            </nav>

        </div>
    </section>

    <section class="productDetails py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-gal sticky-top d-flex flex-row-reverse">
                        <div class="product-gal-img">
                            <img class="xzoom img-fluid" src="{{ asset(json_decode($product->photos)[0]) }}"
                                xoriginal="{{ asset(json_decode($product->photos)[0]) }}" />
                        </div>
                        <div class="product-gal-thumb">
                            <div class="xzoom-thumbs">
                                @foreach (json_decode($product->photos) as $key => $photo)
                                    <a href="{{ asset($photo) }}">
                                        <img class="xzoom-gallery" width="80" src="{{ asset($photo) }}"
                                            @if ($key == 0) xpreview="{{ asset($photo) }}" @endif>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="text-dark font-weight-bold">{{ __($product->name) }} @php
                        $qty = 0;
                        foreach (json_decode($product->variations) as $key => $variation) {
                            $qty += $variation->qty;
                        }
                    @endphp
                        @if (count(json_decode($product->variations, true)) >= 1)
                            @if ($qty > 0)
                                <span class="badge badge-md badge-pill bg-green">{{ __('In stock') }}</span>

                            @else
                                <span class="badge badge-md badge-pill bg-red">{{ __('Out of stock') }}</span>
                            @endif
                        @endif
                    </h5>
                    @if (count(json_decode($product->variations, true)) >= 1)
                        <div class="avialable-amount">({{ $qty }} {{ __('available') }})</div>
                    @endif


                    <div class="d-flex justify-content-between flex-wrap">

                        {{-- <h5 class="price text-dark">$15.00</h5> --}}
                        @if (home_price($product->id) != home_discounted_price($product->id))
                            <h5 class="price_range" id="price_ppr">
                                <del class="text-danger">{{ home_price($product->id) }}</del>
                                <ins class="pl-2">
                                    {{ home_discounted_price($product->id) }}
                                </ins>
                            </h5>
                        @else

                            <h5>
                                <ins>
                                    {{ home_price($product->id) }}
                                </ins>
                            </h5>
                        @endif
                        <div class="review d-flex flex-wrap justify-content-center align-items-center">
                            <span>
                                <i class="iconify" data-icon="codicon:star-full"></i>
                                <i class="iconify" data-icon="codicon:star-full"></i>
                                <i class="iconify" data-icon="codicon:star-full"></i>
                                <i class="iconify" data-icon="codicon:star-full"></i>
                                <i class="iconify" data-icon="codicon:star-full"></i>
                            </span>
                            <span class="text-dark ml-2">(12 reviews)</span>
                        </div>
                    </div>

                    <div><?php echo $product->description; ?></div>
                    <form id="option-choice-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}">

                        @if (count(json_decode($product->colors)) > 0)
                            <small class="font-weight-bold text-uppercase text-dark"> Color:
                                {{-- <span id="colorName" class="text-capitalize" ></span> --}}
                            </small>
                            <div class="variationSec my-2">
                                <!-- color 1 -->
                                @foreach (json_decode($product->colors) as $key => $color)
                                    <input type="radio" id="{{ $color }}" class="variation" name="color"
                                        value="{{ $color }}">
                                    <label for="{{ $color }}" title="{{ $color }}">
                                        <div style="background: {{ $color }};" class="setColor {{ $color }}"
                                            onclick="catchColor(event);"></div>
                                    </label>
                                @endforeach


                            </div>
                        @endif

                        @foreach (json_decode($product->choice_options) as $key => $choice)

                            <div class="row no-gutters">
                                <div class="col-2">
                                    <div class="product-description-label mt-2 ">{{ $choice->title }}:</div>
                                </div>
                                <div class="col-10">
                                    <ul class="list-inline checkbox-alphanumeric checkbox-alphanumeric--style-1 mb-2">
                                        @foreach ($choice->options as $key => $option)
                                            <li>
                                                <input type="radio" id="{{ $choice->name }}-{{ $option }}"
                                                    name="{{ $choice->name }}" value="{{ $option }}">
                                                <label
                                                    for="{{ $choice->name }}-{{ $option }}">{{ $option }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        @endforeach
                    </form>
                    <div class="addCart d-flex">
                        <div class="cart">
                            <button id="dec" onclick="dec()">-</button>
                            <input type="text" name="quantity" id="cartValue" value="1">
                            <button onclick="inc()">+</button>
                        </div>

                        <button class="addCartBtn" onclick="addToCart()">Add Cart</button>
                        <!-- Add to wishlist button -->
                        <button type="button" class="btn btn-outline btn-base-1 btn-icon-left mr-2"
                            onclick="addToWishList({{ $product->id }})">
                            <i class="la la-heart-o"></i>
                            <span class="d-none d-md-inline-block"> {{ __('Add to wishlist') }}</span>
                        </button>
                        <!-- Add to compare button -->
                        <button type="button" class="btn btn-outline btn-base-1 btn-icon-left"
                            onclick="addToCompare({{ $product->id }})">
                            <i class="la la-refresh"></i>
                            <span class="d-none d-md-inline-block"> {{ __('Add to compare') }}</span>
                        </button>
                    </div>
                    <img src="./images/trust_img2.png" class="img-fluid my-3">
                    <div class="product_meta">
                        <span class="sku_wrapper"><span class="">
                                SKU:
                            </span> <span class="sku value cg d-inline-block">P15-2</span></span><br>
                        <span class="posted_in">
                            <span class="">Categories:</span>
                            <a
                                href="{{ route('products.category', $product->category_id) }}">{{ $product->category->name }}</a>
                        </span>
                        <br>
                        <span class="tagged_as"><span class=""> Tags:</span>
                            {{ $product->tags }}
                        </span>
                    </div>
                </div>
            </div>
        </div>



    </section>
    <section>

        <div class="container container_des">
            <div class="row productView">
                <div class="col-xl-3 d-none d-xl-block">
                    <div class="seller-top-products-box bg-white sidebar-box mb-3">
                        <div class="box-title">
                            {{ __('Top Selling Products') }}
                        </div>
                        <div class="box-content">
                            @foreach (filter_products(\App\Models\Product::where('user_id', $product->user_id)->orderBy('num_of_sale', 'desc'))->limit(5)->get()
        as $key => $top_product)
                                <div class="mb-3 product-box-3 myDIV">
                                    <div class="clearfix">
                                        <div class="product-image float-left">
                                            <a href="{{ route('product', $top_product->slug) }}"><img
                                                    src="{{ asset($top_product->thumbnail_img) }}" height="90" width="90"
                                                    alt=""></a>
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
                                            <button class="addCartBtn mt-3" style="padding: 3px; 5px;"
                                                onclick="showAddToCartModal({{ $top_product->id }})">
                                                <i class="fa fa-eye"></i>
                                                <article class="d-inline">Quick View</article>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="product-desc-tab bg-white">
                        <div class="tabs tabs--style-2">
                            <ul class="nav nav-tabs justify-content-center sticky-top bg-white">
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
                            </ul>

                            <div class="tab-content pt-0">
                                <div class="tab-pane active show" id="tab_default_1">
                                    <div class="py-2 px-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo $product->description; ?>
                                            </div>
                                        </div>
                                        <span class="space-md-md"></span>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_default_2">
                                    <div class="fluid-paragraph py-2">
                                        <!-- 16:9 aspect ratio -->
                                        <div class="embed-responsive embed-responsive-16by9 mb-5">
                                            @if ($product->video_provider == 'youtube' && $product->video_link != null)
                                                <iframe class="embed-responsive-item"
                                                    src="https://www.youtube.com/embed/{{ explode('=', $product->video_link)[1] }}"></iframe>
                                            @elseif ($product->video_provider == 'dailymotion' && $product->video_link
                                                != null)
                                                <iframe class="embed-responsive-item"
                                                    src="https://www.dailymotion.com/embed/video/{{ explode('video/', $product->video_link)[1] }}"></iframe>
                                            @elseif ($product->video_provider == 'vimeo' && $product->video_link !=
                                                null)
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
                                                    <img src="{{ asset($review->user->avatar_original) }}"
                                                        class="rounded-circle">
                                                </div>
                                                <div class="block-body">
                                                    <div class="block-body-inner">
                                                        <div class="row no-gutters">
                                                            <div class="col">
                                                                <h3 class="heading heading-6">
                                                                    <a href="javascript:;">{{ $review->user->name }}</a>
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
                                                                <textarea class="form-control" rows="4" name="comment"
                                                                    placeholder="{{ __('Your review') }}"
                                                                    required></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="text-right">
                                                            <button type="submit"
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

                            </div>
                        </div>
                    </div>
                    <div class="my-4 bg-white p-3">
                        <div class="section-title-1">
                            <h3 class="heading-5 strong-700 mb-0">
                                <span class="mr-4">{{ __('Related products') }}</span>
                            </h3>
                        </div>
                        <div class="caorusel-box">
                            <div class="slick-carousel" data-slick-items="4" data-slick-lg-items="4"
                                data-slick-md-items="3" data-slick-sm-items="2" data-slick-xs-items="2">
                                @foreach (filter_products(\App\Models\Product::where('subcategory_id', $product->subcategory_id)->where('id', '!=', $product->id))->limit(10)->get()
        as $key => $related_product)
                                    <div class="product-card-2 card card-product m-2 shop-cards shop-tech">
                                        <div class="card-body p-0">
                                            <div class="card-image">
                                                {{-- <a href="{{ route('product', $related_product->slug) }}" class="d-block">
                                                <img data-original="{{ asset($related_product->thumbnail_img) }}" alt="">
                                            </a> --}}
                                                <a href="{{ route('product', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $related_product->slug)))) }}"
                                                    class="d-block"
                                                    style="background-image:url('{{ asset($related_product->thumbnail_img) }}');">
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
                                            <div class="">
                                                <button class="paction add-wishlist" title="Add to Wishlist"
                                                    onclick="addToWishList({{ $product->id }})">
                                                    <i class="la la-heart-o"></i>
                                                </button>

                                                <button type="button"
                                                    class="paction add-cart btn btn-base-1 btn-circle btn-icon-left"
                                                    onclick="showAddToCartModal({{ $product->id }})">
                                                    <i class="fa la la-shopping-cart"></i>{{ __('Add to cart') }}
                                                </button>

                                                <button class="paction add-compare" title="Add to Compare"
                                                    onclick="addToCompare({{ $product->id }})">
                                                    <i class="la la-refresh"></i>
                                                </button>
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


    <!-- description and review -->





@endsection
