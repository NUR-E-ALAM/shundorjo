    @if(Session::has('cart'))
        <div class="cartitem">
            {{ count(Session::get('cart'))}}
        </div>
    @else
        <div class="cartitem">
            0
        </div>
     @endif