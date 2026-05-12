<div class="row productView">
    @foreach ($products as $key => $product)
        <div class="col-md-3 col-xl-3 col-lg-3 col-sm-6" style="padding: 5px !important">
            <div class="productDesign bg-white product-cat-box" style="
    height: 280px !important;">
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
                        <img class="img-fluid product-photo lazyload"
                        data-src="{{ asset($product->thumbnail_img) }}" alt="" />
                    </a>

                    <div class="inner">
                        <button class="btn-invisible"
                            onclick="showAddToCartModal({{ $product->id }})">
                            <span class="iconify" data-icon="clarity:eye-show-solid"></span>
                            <article class="d-inline">Quick View</article>
                        </button>

                        @if($product->is_stock==1)
                        <a onclick="buyNow({{$product->id}})">
                            <button class="btn-invisible">
                                <span class="iconify" data-icon="ei:cart"></span>
                                <article class="d-inline">Order Now</article>
                            </button>
                        </a>
                            @else
                            <a>
                                <button class="btn-invisible">
                                    <span class="iconify" data-icon="ei:cart"></span>
                                    <article class="d-inline">Stock Out</article>
                                </button>
                            </a>
                            @endif


                    </div>
                </div>

                <div class="product-info">
                    <h6 class="product-title">
                        <a class=""
                            href="{{ route('product', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product->slug)))) }}">{{ __($product->name) }}
                        </a>
                    </h6>
                    <span class="price" style="margin-top: -30px;">
                        @if (home_base_price($product->id) != home_discounted_base_price($product->id))
                            {{-- <span class="old-product-price strong-300"></span> --}}
                            <del class="pl-3">{{ home_base_price($product->id) }}</del>
                        @endif

                        <ins
                            class="pl-3">{{ home_discounted_base_price($product->id) }}</ins>
                    </span>


                </div>
            </div>
        </div>
    @endforeach
    <!-- Pagination (hidden on the first load but used by AJAX) -->
@if ($products->hasMorePages())
<div class="pagination-links" style="display: none;">
    {{ $products->appends(request()->query())->links() }}
</div>
@endif
</div>

