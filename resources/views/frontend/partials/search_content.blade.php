<div>

    <div class="product">
        @if (count($products) > 0)
            <div class="title">{{__('Products')}}</div>

            <ul>
                @foreach ($products as $key => $product)
                    <li>
                        <a href="{{ route('product', $product->slug) }}" style="padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 0px;
">
                            <div class="productCartList">
                                <div class="items">
                                    <img src="{{ asset($product->thumbnail_img) }}" style="width:90px; height:91px;"
                                    class="img-fluid" alt="">
                                </div>
                                <div class="items">
                                    <a href="{{ route('product', $product->slug) }}" class="" style="font-weight: 500; line-height: 20px;">
                                        <p>{{ __($product->name) }}</p>
                                    </a>
                                    <div class="type"> @php
                                        $qty = 0;
                                        foreach (json_decode($product->variations) as $key => $variation) {
                                            $qty += $variation->qty;
                                        }
                                    @endphp
                                    @if(count(json_decode($product->variations, true)) >= 1)
                                        @if ($qty > 0)
                                            <span class="badge badge-pill bg-green">{{__('In stock')}}</span>
                                        @else
                                            <span class="badge badge badge-pill bg-red">{{__('Out of stock')}}</span>
                                        @endif
                                    @endif</div>
                                    <div class="price" style="margin-top: -35px"> @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                        <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                    @endif
                                    <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span></div>
                                </div>
                            </div>
{{-- ////////////////////////////////////////////////////////////// --}}
                            {{-- <div class="d-flex search-product align-items-center">
                                <div class="image" style="background-image:url('{{ asset($product->thumbnail_img) }}');">
                                </div>
                                <div class="w-100 overflow--hidden">
                                    <div class="product-name text-truncate">
                                        {{ __($product->name) }}
                                    </div>
                                    <div class="clearfix">
                                        <div class="price-box float-left">
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                            @endif
                                            <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                        </div>
                                        <div class="stock-box float-right">
                                            @php
                                                $qty = 0;
                                                foreach (json_decode($product->variations) as $key => $variation) {
                                                    $qty += $variation->qty;
                                                }
                                            @endphp
                                            @if(count(json_decode($product->variations, true)) >= 1)
                                                @if ($qty > 0)
                                                    <span class="badge badge-pill bg-green">{{__('In stock')}}</span>
                                                @else
                                                    <span class="badge badge badge-pill bg-red">{{__('Out of stock')}}</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
     <div class="keyword ">
        @if (sizeof($keywords) > 0)
            <div class="title">{{__('Popular Suggestions')}}</div>
            <ul>
                @foreach ($keywords as $key => $keyword)
                    <li><a href="{{ route('suggestion.search', $keyword) }}">{{ $keyword }}</a></li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="category">
        @if (count($subsubcategories) > 0)
            <div class="title">{{__('Category Suggestions')}}</div>
            <ul>
                @foreach ($subsubcategories as $key => $subsubcategory)
                    <li><a href="{{ route('products.subsubcategory', $subsubcategory->id) }}">{{ __($subsubcategory->name) }}</a></li>
                @endforeach
            </ul>
        @endif
    </div>
</div>


