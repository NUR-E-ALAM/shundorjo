<div class="mb-3 product-box-3 myDIV">
    <div class="clearfix d-flex">

        <!-- Product Image -->
        <div class="product-image mr-2">
            <a href="{{ route('product', $product->slug) }}">
                <img class="lazyload"
                     data-src="{{ asset($product->thumbnail_img) }}"
                     height="90" width="90"
                     alt="{{ $product->name }}">
            </a>
        </div>

        <!-- Product Details -->
        <div class="product-details flex-grow-1">
            <h4 class="title text-truncate-2 mb-1">
                <a href="{{ route('product', $product->slug) }}" class="d-block">
                    {{ $product->name }}
                </a>
            </h4>

            <!-- Price -->
            <div class="price-box mb-1">
                @if (home_base_price($product->id) != home_discounted_base_price($product->id))
                    <del class="old-product-price strong-400">
                        {{ home_base_price($product->id) }}
                    </del>
                @endif
                <span class="product-price strong-600">
                    {{ home_discounted_base_price($product->id) }}
                </span>
            </div>

            <!-- Stock / Order Button -->
            @if($product->is_stock == 1)
                <button class="buyNowBtn mt-2" onclick="buyNow({{ $product->id }})">
                    <i class="fa fa-eye"></i>
                    <span class="d-inline">Order Now</span>
                </button>
            @else
                <button class="buyNowBtn mt-2" disabled>
                    <i class="fa fa-eye"></i>
                    <span class="d-inline">Stock Out</span>
                </button>
            @endif
        </div>
    </div>
</div>
