<div class="row productView">
    @foreach ($products as $key => $product)
        <div class="col-md-3 col-xl-3 col-lg-3 col-sm-6" style="padding: 5px !important">
            <div class="productDesign bg-white product-cat-box" itemscope itemtype="https://schema.org/Product">
                <div class="productContainer">
                    <div class="productBadge">
                        @if ($product->todays_deal == 1)
                            <div class="proBadgePer">
                                New
                            </div>
                        @else
                        @endif
                        @if (percentage($product->id) > 0)
                            <div class="proBadge">
                                -{{ percentage($product->id) }}%
                            </div>
                        @endif
                    </div>
                    <a
                        href="{{ route('product', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product->slug)))) }}">
                        @if($product->thumbnail_webp && file_exists(public_path($product->thumbnail_webp)))
    <img class="img-fluid lazyload"
         data-src="{{ asset($product->thumbnail_webp) }}"
         alt="{{ $product->name }} price in Bangladesh | Authentic Product by Shundorjo" itemprop="image">
@else
    <img class="img-fluid lazyload"
         data-src="{{ asset($product->thumbnail_img) }}"
         alt="{{ $product->name }} price in Bangladesh | Authentic Product by Shundorjo" itemprop="image">
@endif
                    </a>

                    <div class="inner2">
                        <a class="btn-invisible btn-quick" aria-label="Quick view - {{ $product->name }}"
                            onclick="showAddToCartModal({{ $product->id }})">
                            <span  >Quick View</span>
                            <article class="d-inline">Quick View</article>
                    </a>
                        @if($product->is_stock==1)
                            <a class="btn-invisible" onclick="buyNow({{$product->id}})" title="Order {{ $product->name }} Now">
                                <span class="iconify">Order Now</span>
                                <article class="d-inline">Order Now</article>
                            </a>
                            @else
                                <a class="btn-invisible" title="{{ $product->name }} Stock Out">
                                    <span class="iconify">Stock Out</span>
                                    <article class="d-inline">Stock Out</article>
                                </a>
                            @endif



                    </div>
                    <div class="product-info" >
                        <!-- for Google -->
                <meta itemprop="sku" content="{{ $product->prescribed }}">
                <meta itemprop="brand" content="Shundorjo">
                <meta itemprop="name" content="{{ $product->name }}">
                <meta itemprop="image" content="{{ asset($product->thumbnail_img) }}">
                <meta itemprop="description" content="{{ Str::limit(strip_tags($product->description), 150) }}">

                       @php
    $priceNumber = home_discounted_base_price_raw($product->id);
@endphp

<div class="price-box text-center"
     itemprop="offers"
     itemscope
     itemtype="https://schema.org/Offer">

    <!-- for Google -->
    <meta itemprop="price" content="{{ $priceNumber }}">
    <meta itemprop="priceCurrency" content="BDT">
    <meta itemprop="availability" content="https://schema.org/{{ $product->is_stock ? 'InStock' : 'OutOfStock' }}">

    <!-- for user -->
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

                            <a class="" title="{{ $product->name }} price in Bangladesh" itemprop="url"
                                href="{{ route('product', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product->slug)))) }}">{{ Str::limit(strip_tags($product->name), 40) }}
                            </a>
                        </h6>



                    </div>
                </div>


            </div>
        </div>
    @endforeach

</div>
@if ($products->hasMorePages())
    <div class="text-center my-4 load-more-wrapper">
        <button class="btn btn-primary load-more-btn"
                data-url="{{ $products->nextPageUrl() }}">
            Load More Products
        </button>
    </div>
@endif

