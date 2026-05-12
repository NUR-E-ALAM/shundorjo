@extends('frontend.layouts.app')
@section('title')
@php
    $title = 'Shundorjo Skincare Shop';

    if (!empty($category_id)) {
        $title = optional(\App\Models\Category::find($category_id))->name;
    } elseif (!empty($subcategory_id)) {
        $title = optional(\App\Models\SubCategory::find($subcategory_id))->name;
    } elseif (!empty($subsubcategory_id)) {
        $title = optional(\App\Models\SubSubCategory::find($subsubcategory_id))->name;
    } elseif (!empty($brand_id)) {
        $title = optional(\App\Models\Brand::find($brand_id))->name;
    }
@endphp

{{ $title }} Price in Bangladesh {{ date('Y') }} | Shundorjo

@stop
<style>
   /* Default (Desktop/Laptop) */
.product-cat-box {
    height: 315px;
}

.productFeatured .product-photo {
    height: 200px;
    width: 100%;
}

/* Mobile (max-width:480px) */
@media (max-width:480px){
    .product-cat-box {
        height: 340px !important;  /* Mobile height */
    }
    .productFeatured .product-photo {
        height: 150px;
    }
}

/* Tablet/Mid devices (max-width:600px) */
@media (max-width:600px){
   .productFeatured .productContainer .inner {
        top: 70%;
   }
   .product-cat-box {
        height: 340px !important;  /* Mobile height */
    }
}
.background-image{
    background-position: center center !important;
    background-attachment: fixed !important;
    background-repeat: no-repeat !important;
    background-size: cover !important;
}
    </style>
@section('content')

    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        <li><a href="{{ route('products') }}">{{ __('All Categories') }}</a></li>
                        @if (isset($category_id))
                            <li class="active"><a
                                    href="{{ route('products.category', $category_id) }}">{{ \App\Models\Category::find($category_id)->name }}</a>
                            </li>
                        @endif
                        @if (isset($subcategory_id))
                            <li><a
                                    href="{{ route('products.category', \App\Models\SubCategory::find($subcategory_id)->category->id) }}">{{ \App\Models\SubCategory::find($subcategory_id)->category->name }}</a>
                            </li>
                            <li class="active"><a
                                    href="{{ route('products.subcategory', $subcategory_id) }}">{{ \App\Models\SubCategory::find($subcategory_id)->name }}</a>
                            </li>
                        @endif
                        @if (isset($subsubcategory_id))
                            <li><a
                                    href="{{ route('products.category', \App\Models\SubSubCategory::find($subsubcategory_id)->subcategory->category->id) }}">{{ \App\Models\SubSubCategory::find($subsubcategory_id)->subcategory->category->name }}</a>
                            </li>
                            <li><a
                                    href="{{ route('products.subcategory', \App\Models\SubsubCategory::find($subsubcategory_id)->subcategory->id) }}">{{ \App\Models\SubsubCategory::find($subsubcategory_id)->subcategory->name }}</a>
                            </li>
                            <li class="active"><a
                                    href="{{ route('products.subsubcategory', $subsubcategory_id) }}">{{ \App\Models\SubSubCategory::find($subsubcategory_id)->name }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="py-5 background-image"
        @if (isset($category_id)) style="background-image: url('{{ asset('frontend/images/Banner-1.png') }}'); "
        @elseif (isset($subcategory_id)) style="background-image: url('{{ asset('frontend/images/Banner-2.png') }}');"
        @elseif (isset($subsubcategory_id)) style="background-image: url('{{ asset('frontend/images/Banner-3.png') }}');"
        @elseif (isset($brand_id)) style="background-image: url('{{ asset('frontend/images/Banner-4.png') }}');"
        @else  style="background-image: url('{{ asset('frontend/images/Shop-Banner.jpg') }}');" @endif>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">

                    @if (isset($category_id))
                        <h2 class="mb-0" style="color: #ffff;">
                            {{ \App\Models\Category::find($category_id)->name }}
                        </h2>
                    @elseif(isset($subcategory_id))
                        <h2 class="mb-0" style="color: #ffff;">
                            {{ \App\Models\SubCategory::find($subcategory_id)->name }}
                        </h2>
                    @elseif(isset($subsubcategory_id))
                        <h2 class="mb-0" style="color: #ffff;">
                            {{ \App\Models\SubSubCategory::find($subsubcategory_id)->name }}
                        </h2>
                    @elseif(isset($brand_id))
                        <h2 class="mb-0" style="color: #ffff;">
                            {{ \App\Models\Brand::find($brand_id)->name }}
                        </h2>
                    @else
                        <h2 class="mb-0" style="color: #ffff;">
                            Shop
                        </h2>
                    @endif




                </div>
            </div>
        </div>
    </section>

    <section class="gry-bg py-4">
        <div style="width: 90%; margin: 0 auto;">
            <div class="row">
                <div class="col-xl-3 d-none d-xl-block">

                    <div class="bg-white sidebar-box mb-3">

                        <div class="widget widget-categories mb-4 pb-4 border-bottom">
                            <div class="box-title text-center">
                                {{ __('Categories') }}
                            </div>
                            <div class="divider-role"
                                style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: -6px;"></div>
                            <div class="accordion mt-n1" id="shop-categories">
                                @foreach (\App\Models\Category::all() as $key => $category)
                                    <div class="card">
                                        <div class="card-header p-1">
                                            <label class="for-hover-lable" style="cursor: pointer"
                                                onclick="location.href='{{ route('search', ['slug' => Str::slug($category->name),'category_id' => $category->id]) }}'">{{ __($category->name) }}</label>
                                            <strong class="pull-right for-brand-hover" style="cursor: pointer"
                                                onclick="$('#collapse-{{ $key }}').toggle(400)">
                                                +
                                            </strong>
                                        </div>
                                        <div class="card-body" id="collapse-{{ $key }}" style="display: none;">
                                            @foreach ($category->subcategories as $key2 => $subcategory)
                                                <div class=" for-hover-lable card-header p-1">
                                                    <label style="cursor: pointer"
                                                        onclick="location.href='{{ route('search', ['slug' => Str::slug($subcategory->name),'subcategory_id' => $subcategory->id]) }}'">{{ __($subcategory->name) }}</label>
                                                    <strong class="pull-right" style="cursor: pointer"
                                                        onclick="$('#collapse-{{ $key }}-{{ $key2 }}').toggle(400)">
                                                        +
                                                    </strong>
                                                </div>
                                                <div class="card-body"
                                                    id="collapse-{{ $key }}-{{ $key2 }}"
                                                    style="display: none">
                                                    @foreach ($subcategory->subsubcategories as $key3 => $subsubcategory)
                                                        <div class=" for-hover-lable card-header p-1">
                                                            <label style="cursor: pointer"
                                                                onclick="location.href='{{ route('search', ['slug' => Str::slug($subsubcategory->name),'subsubcategory_id' => $subsubcategory->id]) }}'">{{ __($subsubcategory->name) }}</label>

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
                    <div class="bg-white sidebar-box mb-3">
                        <div class="box-title text-center">
                            {{ __('Price range') }}
                        </div>
                        <div class="box-content">
                            <div class="range-slider-wrapper mt-3">
                                <!-- Range slider container -->
                                <div id="input-slider-range"
                                    data-range-value-min="{{ filter_products(\App\Models\Product::all())->min('unit_price') }}"
                                    data-range-value-max="{{ filter_products(\App\Models\Product::all())->max('unit_price') }}">
                                </div>

                                <!-- Range slider values -->
                                <div class="row">
                                    <div class="col-6">
                                        <span class="range-slider-value value-low"
                                            @if (isset($min_price)) data-range-value-low="{{ $min_price }}"
                                        @elseif($products->min('unit_price') > 0)
                                            data-range-value-low="{{ $products->min('unit_price') }}"
                                        @else
                                            data-range-value-low="0" @endif
                                            id="input-slider-range-value-low">
                                    </div>

                                    <div class="col-6 text-right">
                                        <span class="range-slider-value value-high"
                                            @if (isset($max_price)) data-range-value-high="{{ $max_price }}"
                                        @elseif($products->max('unit_price') > 0)
                                            data-range-value-high="{{ $products->max('unit_price') }}"
                                        @else
                                            data-range-value-high="0" @endif
                                            id="input-slider-range-value-high">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- brands  --}}
                    <div class="bg-white sidebar-box mb-3">
                        <div class="box-title text-center">
                            {{ __('Brands') }}
                        </div>
                        <div class="box-content">
                            <div class="row m-1">
                                @php
                                    $brands = [];
                                @endphp
                                @if (isset($subsubcategory_id))
                                    @php
                                        foreach (
                                            json_decode(\App\Models\SubSubCategory::find($subsubcategory_id)->brands)
                                            as $brand
                                        ) {
                                            if (!in_array($brand, $brands)) {
                                                array_push($brands, $brand);
                                            }
                                        }
                                    @endphp
                                @elseif(isset($subcategory_id))
                                    @foreach (\App\Models\SubCategory::find($subcategory_id)->subsubcategories as $key => $subsubcategory)
                                        @php
                                            foreach (json_decode($subsubcategory->brands) as $brand) {
                                                if (!in_array($brand, $brands)) {
                                                    array_push($brands, $brand);
                                                }
                                            }
                                        @endphp
                                    @endforeach
                                @elseif(isset($category_id))
                                    @foreach (\App\Models\Category::find($category_id)->subcategories as $key => $subcategory)
                                        @foreach ($subcategory->subsubcategories as $key => $subsubcategory)
                                            @php
                                                foreach (json_decode($subsubcategory->brands) as $brand) {
                                                    if (!in_array($brand, $brands)) {
                                                        array_push($brands, $brand);
                                                    }
                                                }
                                            @endphp
                                        @endforeach
                                    @endforeach
                                @else
                                    @php
                                        foreach (\App\Models\Brand::get()->take(54)->sortBy('name') as $key => $brand) {
                                            if (!in_array($brand->id, $brands)) {
                                                array_push($brands, $brand->id);
                                            }
                                        }
                                    @endphp
                                @endif

                                @foreach ($brands as $key => $id)
                                    @if (\App\Models\Brand::find($id) != null)
                                        <div class="col-6 border"><a href="{{ route('search', ['slug' => Str::slug(\App\Models\Brand::find($id)->name),'brand_id' => $id]) }}"><img
                                            data-src="{{ asset(\App\Models\Brand::find($id)->logo) }}" alt="{{(\App\Models\Brand::find($id)->name)}}"
                                                    class="img-fluid lazyload"></a></div>
                                    @endif
                                @endforeach
                                <div class="col-12 text-center mt-2">
                                    <button aria-label="More Brands" class="btn-visible"><a href="{{ route('brands.all') }}"> More
                                            Brands </a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9" style="padding: 5px 0px;">
                    <!-- <div class="bg-white"> -->
                    <div class="brands-bar row no-gutters pb-3 bg-white p-3 d-lg-none">
                        <div class="col-12">
                            <div class="brands-collapse-box" id="brands-collapse-box">
                                <ul class="inline-links">
                                    @php
                                        $brands = [];
                                    @endphp
                                    @if (isset($subsubcategory_id))
                                        @php
                                            foreach (
                                                json_decode(
                                                    \App\Models\SubSubCategory::find($subsubcategory_id)->brands,
                                                )
                                                as $brand
                                            ) {
                                                if (!in_array($brand, $brands)) {
                                                    array_push($brands, $brand);
                                                }
                                            }
                                        @endphp
                                    @elseif(isset($subcategory_id))
                                        @foreach (\App\Models\SubCategory::find($subcategory_id)->subsubcategories as $key => $subsubcategory)
                                            @php
                                                foreach (json_decode($subsubcategory->brands) as $brand) {
                                                    if (!in_array($brand, $brands)) {
                                                        array_push($brands, $brand);
                                                    }
                                                }
                                            @endphp
                                        @endforeach
                                    @elseif(isset($category_id))
                                        @foreach (\App\Models\Category::find($category_id)->subcategories as $key => $subcategory)
                                            @foreach ($subcategory->subsubcategories as $key => $subsubcategory)
                                                @php
                                                    foreach (json_decode($subsubcategory->brands) as $brand) {
                                                        if (!in_array($brand, $brands)) {
                                                            array_push($brands, $brand);
                                                        }
                                                    }
                                                @endphp
                                            @endforeach
                                        @endforeach
                                    @else
                                        @php
                                            foreach (\App\Models\Brand::all()->sortBy('name') as $key => $brand) {
                                                if (!in_array($brand->id, $brands)) {
                                                    array_push($brands, $brand->id);
                                                }
                                            }
                                        @endphp
                                    @endif

                                    @foreach ($brands as $key => $id)
                                        @if (\App\Models\Brand::find($id) != null)
                                            <li><a href="{{ route('search', ['slug' => Str::slug(\App\Models\Brand::find($id)->name),'brand_id' => $id]) }}"><img
                                                        src="{{ asset(\App\Models\Brand::find($id)->logo) }}"
                                                        alt="{{(\App\Models\Brand::find($id)->name)}}" class="img-fluid"></a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" aria-label="Add Brands" name="button" onclick="morebrands(this)" class="more-brands-btn">
                                <i class="fa fa-plus"></i>
                                <span class="d-none d-md-inline-block">{{ __('More') }}</span>
                            </button>
                        </div>
                    </div>
                    <form class="" id="search-form" action="{{ route('search') }}" method="GET">

                        <div class="sort-by-bar row no-gutters bg-white mb-3 px-3">
                            <div class="col-lg-6 col-md-5 col-sm-12">
                                <div class="sort-by-box">
                                    <div class="form-group">
                                        <label>{{ __('Search') }}</label>
                                        <div class="search-widget">
                                            <input class="form-control input-lg" type="text" name="keyword"
                                                placeholder="{{ __('Search products') }}"
                                                @isset($query) value="{{ $query }}" @endisset>
                                            <button aria-label="Search" type="submit" class="btn-inner">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-7 col-sm-12">
                                <div class="row no-gutters">
                                    <div class="col-6">
                                        <div class="sort-by-box px-1">
                                            <div class="form-group">
                                                <label>{{ __('Sort by') }}</label>
                                                <select class="form-control" data-minimum-results-for-search="Infinity"
                                                    name="sort_by" onchange="filter()">
                                                    <option value="1"
                                                        @isset($sort_by) @if ($sort_by == '1') selected @endif
                                                                                    @endisset>
                                                        {{ __('Newest') }}</option>
                                                    <option value="2"
                                                        @isset($sort_by) @if ($sort_by == '2') selected @endif
                                                                                @endisset>
                                                        {{ __('Oldest') }}</option>
                                                    <option value="3"
                                                        @isset($sort_by) @if ($sort_by == '3') selected @endif
                                                                            @endisset>
                                                        {{ __('Price low to high') }}</option>
                                                    <option value="4"
                                                        @isset($sort_by) @if ($sort_by == '4') selected @endif
                                                                        @endisset>
                                                        {{ __('Price high to low') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="sort-by-box px-1">
                                            <div class="form-group">
                                                <label>{{ __('Brands') }}</label>
                                                <select class="form-control" data-placeholder="{{ __('All Brands') }}"
                                                    name="brand_id" onchange="filter()">
                                                    <option value="">{{ __('All Brands') }}</option>
                                                    @foreach ($brands as $key => $id)
                                                        @if (\App\Models\Brand::find($id) != null)
                                                            <option value="{{ $id }}"
                                                                @isset($brand_id) @if ($brand_id == $id) selected @endif
                                                                                    @endisset>
                                                                {{ \App\Models\Brand::find($id)->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="min_price" value="">
                        <input type="hidden" name="max_price" value="">
                    </form>

                    <section class="productFeatured py-2">
                        <div class="container">
                            <div id="product-list">
                                @include('frontend.load_more') <!-- Initial product list -->
                            </div>


                        </div>
                    </section>


                    <!-- </div> -->
                </div>
            </div>
        </div>
            @if (isset($category_id))
        <?php
        $category = \App\Models\Category::find($category_id);
        ?>
        @if (isset($category->description))
            <section class="gry-bg py-4">
                <div class="container">
                    <div class="products-box-bar p-3 bg-white">
                        <p>
                            {!! $category->description !!}
                        </p>
                    </div>
                </div>
            </section>
        @endif
    @endif

    @if (isset($subcategory_id))
        <?php
        $category = \App\Models\SubCategory::find($subcategory_id);

        ?>
        @if (isset($category->description))
            <section class="gry-bg py-4">
                <div class="container">
                    <div class="products-box-bar p-3 bg-white">
                        <p>
                            {!! $category->description !!}
                        </p>
                    </div>
                </div>
            </section>
        @endif
    @endif

    @if (isset($subsubcategory_id))
        <?php
        $category = \App\Models\SubSubCategory::find($subsubcategory_id);
        ?>
        @if (isset($category->description))
            <section class="gry-bg py-4">
                <div class="container">
                    <div class="products-box-bar p-3 bg-white">
                        <p>
                            {!! $category->description !!}
                        </p>
                    </div>
                </div>
            </section>
        @endif
    @endif
    @if (isset($brand_id))
        <?php
        $category = \App\Models\Brand::find($brand_id);
        ?>
        @if (isset($category->description))
            <section class="gry-bg py-4">
                <div class="container">
                    <div class="products-box-bar p-3 bg-white">
                        <p>
                            {!! $category->description !!}
                        </p>
                    </div>
                </div>
            </section>
        @endif
    @endif
    </section>



@endsection

@section('script')
    <script type="text/javascript">
        function filter() {
            $('#search-form').submit();
        }

        function rangefilter(arg) {
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
      $(document).on('click', '.load-more-btn', function () {

    let button = $(this);
    let url = button.data('url');

    if (!url) return;

    button.text('Products Loading...');

    $.get(url, function (data) {

        // 🔥 Remove old button
        button.closest('.load-more-wrapper').remove();

        // 🔥 Append new products + new button
        $('#product-list').append(data);

    });
});
    </script>
@endsection
