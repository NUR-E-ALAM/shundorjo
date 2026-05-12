@if (Session::has('cart'))
    @php
        $total = 0;
    @endphp
    @foreach (Session::get('cart') as $key => $cartItem)
        @php
            $product = \App\Models\Product::find($cartItem['id']);
            $total = $total + $cartItem['price'] * $cartItem['quantity'];
            
        @endphp
    @endforeach
    <span>{{ single_price($total) }}</span>
@endif
