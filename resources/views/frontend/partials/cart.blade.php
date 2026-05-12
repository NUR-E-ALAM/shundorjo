

<div class="modal-dialog custom" role="document">
    <div class="modal-content h-100">
        <div class="modal-header">
            <h5 class="modal-title text-black" id="exampleModalLabel">SHOPPING CART</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          {{-- product start  --}}
        @if(Session::has('cart'))
        @if(count($cart = Session::get('cart')) > 0)

          <div class="productListContaineR">
            @php
            $total = 0;
            @endphp
            @foreach($cart as $key => $cartItem)
                @php
                    $product = \App\Models\Product::find($cartItem['id']);
                    $total = $total + $cartItem['price']*$cartItem['quantity'];
                @endphp
            <div class="productCartList border-bottom my-2">
                <div class="items">
                    <a href="{{ route('product', $product->slug) }}">
                    <img src="{{ asset($product->thumbnail_img) }}"
                        class="img-fluid" alt="">
                    </a>
                </div>
                <div class="items">
                    <a href="" class="pname lead">
                        <h6><a href="{{ route('product', $product->slug) }}">
                            {{ __($product->name) }}
                        </a></h6>
                    </a>
                    {{-- <div class="type">Grey / S</div> --}}
                    <div class="price">x{{ $cartItem['quantity'] }} {{ single_price($cartItem['price']*$cartItem['quantity']) }}</div>
                    {{-- <div class="addCart mt-2 d-flex justify-content-between align-items-center">
                        <div class="cart">
                            <button class="btn btn-number" type="button" data-type="minus" data-field="quantity[{{ $key }}]">-</button>
                            <input type="number" name="quantity[{{ $key }}]" placeholder="1" value="{{ $cartItem['quantity'] }}" min="1" max="100" onchange="updateQuantity({{ $key }}, this)">
                            <button class="btn btn-number" type="button" data-type="plus" data-field="quantity[{{ $key }}]">+</button>
                        </div>
                    </div> --}}
                    <div class="modify ml-1">
                        
                        <a href="{{ route('cart') }}"><span class="iconify mr-1" data-icon="bi:pencil-square"></span></a>
                        <span onclick="removeFromCart({{ $key }})" class="iconify" data-icon="carbon:trash-can"></span>
                    </div>

                </div>
            </div>
            @endforeach
{{-- product stop  --}}
          </div>
            <div class="bottomTotal">
                <div class="row text-black">
                    <div class="col-md-6">
                        <h4>Subtotal:</h4>
                    </div>
                    <div class="col-md-6">
                        <h4>{{ single_price($total) }}</h4>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="checkbox" name="" id="chk">
                            <label for="chk">I agree with <a target="__blank" href="{{ route('privacypolicy') }}">terms</a> the  and <a target="__blank" href="{{ route('returnpolicy') }}"> conditions </a>.</label>
                        </div>
                    </div>
                    <div
                        class="col-md-12 text-center d-flex flex-column justify-content-center align-item-center">
                        <a href="{{ route('cart') }}" class="text-center mb-2 btn btn-primary rounded"> View Cart</a>
                        @if(Auth::check())
                        <a href="{{ route('checkout.shipping_info') }}" class="text-center btn btn-info rounded"> Checkout</a>
                        @else
                        <a href="{{ route('cart.login') }}" class="text-center btn btn-info rounded"> Checkout</a>
                        @endif
                    </div>
                </div>
            </div>
            @else
            {{-- <div class="shadow-sm py-2 px-1 text-center border-bottom"> Free Shipping for all orders over $100.00</div> --}}
          <div class="emptyProduct d-flex flex-column align-items-center justify-content-center">
           <span class="iconify" data-icon="clarity:shopping-bag-line"></span>
              <span class="py-2">Your cart is empty.</span>
              <a href="{{route('products')}}" class="btn btn-primary px-3 rounded">Return To Shop</a>
          </div>

          @endif
            @else
            {{-- <div class="shadow-sm py-2 px-1 text-center border-bottom"> Free Shipping for all orders over 10000.00</div> --}}
            <div class="emptyProduct d-flex flex-column align-items-center justify-content-center">
             <span class="iconify" data-icon="clarity:shopping-bag-line"></span>
                <span class="py-2">Your cart is empty.</span>
                <a href="{{route('products')}}" class="btn btn-primary px-3 rounded">Return To Shop</a>
            </div>
        @endif

        </div>
    </div>
</div>

