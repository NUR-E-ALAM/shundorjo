@php
$generalsetting = \App\Models\GeneralSetting::first();
@endphp
<div class="" style="background: #F6F6F8; border-bottom: 1px solid #dbdbdb;">
    <div class="topBar d-none d-md-block container">
        <div class="row">
            <div class="col-md-2">
                <div class="header-text">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        @if ($generalsetting->logo != null)
                            <img src="{{ asset($generalsetting->logo) }}" width="95px" class="img-fluid"
                                alt="Shundorjo">
                        @else
                            <img src="{{ asset('frontend/images/logo.png') }}" width="95px" class="img-fluid"
                                alt="Shundorjo">
                        @endif
                    </a>
                </div>
            </div>

            <div class="col-md-7" style="margin: 15px 0px 0px 0px; text-align: center;">
                    <a style="padding: 0.5rem 1rem; font-weight: bold;" href="{{ route('products') }}">Shop</a>
               <a style="padding: 0.5rem 1rem; font-weight: bold;" href="{{ route('brands.all') }}">Brands</a>
                <a style="padding: 0.5rem 1rem; font-weight: bold;" href="{{ route('aboutus') }}">About</a>
                <a style="padding: 0.5rem 1rem; font-weight: bold;" href="{{ route('contactus') }}">Contact</a>
                <a style="padding: 0.5rem 1rem; font-weight: bold;" href="{{ route('faq') }}">FAQ</a>
                <a style="padding: 0.5rem 1rem; font-weight: bold;" href="{{ route('product-truck') }}">Order Track</a>
                <a style="padding: 0.5rem 1rem; font-weight: bold;" href="{{ route('shundorjo-care-tips') }}" target="__blank">সৌন্দর্য কেয়ার</a>
            </div>

            <div class="col-md-3">

                <div class="form-inline my-2 my-lg-0 userActivities">
                    {{-- computer view serch --}}
                    <span class="iconify mx-2" data-toggle="modal" data-target="#searchbar"
                data-icon="clarity:search-line"></span>

                    @auth
                        <a href="{{ route('dashboard') }}"><span class="iconify mx-2" data-icon="ph:user-thin"
                                data-toggle="modal"></span></a>
                    @else
                        <span class="iconify mx-2" data-icon="ph:user-thin" data-toggle="modal"
                            data-target="#userLogin"></span>
                    @endauth
                    <a href="{{route('compare')}}" class="mx-2 mt-2"><span class="iconify" data-icon="emojione-monotone:yellow-heart"></span></a>
                    {{-- ================================== --}}
                    <div class="">
                        <div style="float: left">
                            <span class="iconify mr-4 mt-2 text-dark" data-icon="ei:cart" data-toggle="modal" data-target="#cart"></span>

                            <span class="cartno">
                                <div id="cartNumberTaka">
                                    @if (Session::has('cart'))
                                        <div class="cartitemsf">
                                            {{ count(Session::get('cart')) }}
                                        </div>
                                    @else
                                        <div class="cartitemsg">
                                            0
                                        </div>
                                    @endif
                                </div>
                            </span>
                        </div>

                        {{-- ////////////////////////////////////////////////////////////// --}}
                        <div style="position: relative; left: -11px; top: 8px; float: right;">
                            <div id="cartThakUpdate">
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
                                <span >{{ single_price($total) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- ============================================ --}}
                </div>
            </div>
            {{-- fixed cart item  --}}
            <div class="st-cart-wrapper" data-toggle="modal" data-target="#cart">
                <div class="st-cartitem-wrap">
                <svg version="1.1" x="0px" y="0px" width="16px" height="24px" viewBox="0 0 100 160.13">
                <g><polygon points="11.052,154.666 21.987,143.115 35.409,154.666  "></polygon><path d="M83.055,36.599c-0.323-7.997-1.229-15.362-2.72-19.555c-2.273-6.396-5.49-7.737-7.789-7.737   c-6.796,0-13.674,11.599-16.489,25.689l-3.371-0.2l-0.19-0.012l-5.509,1.333c-0.058-9.911-1.01-17.577-2.849-22.747   c-2.273-6.394-5.49-7.737-7.788-7.737c-8.618,0-17.367,18.625-17.788,37.361l-13.79,3.336l0.18,1.731h-0.18v106.605l17.466-17.762   l18.592,17.762V48.06H9.886l42.845-10.764l2.862,0.171c-0.47,2.892-0.74,5.865-0.822,8.843l-8.954,1.75v106.605l48.777-10.655   V38.532l0.073-1.244L83.055,36.599z M36.35,8.124c2.709,0,4.453,3.307,5.441,6.081c1.779,5.01,2.69,12.589,2.711,22.513   l-23.429,5.667C21.663,23.304,30.499,8.124,36.35,8.124z M72.546,11.798c2.709,0,4.454,3.308,5.44,6.081   c1.396,3.926,2.252,10.927,2.571,18.572l-22.035-1.308C61.289,21.508,67.87,11.798,72.546,11.798z M58.062,37.612l22.581,1.34   c0.019,0.762,0.028,1.528,0.039,2.297l-23.404,4.571C57.375,42.986,57.637,40.234,58.062,37.612z M83.165,40.766   c-0.007-0.557-0.01-1.112-0.021-1.665l6.549,0.39L83.165,40.766z"></path></g>
                </svg>
                <p class="text-center" id="cartNumber">
                <span >
                    @if (Session::has('cart'))
                        {{ count(Session::get('cart')) }}
                    </span>
                @else
                <span >
                        0
                    </span>
                @endif
                ITEM
        </p>

        </div>
                <div class="st-total" style=""  >
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
                        <span id="cartTakaUpdate">{{ single_price($total) }}</span>
                        @endif

            </div>
        </div>


        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-white px-2 py-0 sticky" style="">
    <div class="container">
        <h4 class="categoryMobile">
            <span class="iconify" style="position: relative; font-size: 40px; top: 10px; left: 5px;"
                data-toggle="modal" data-target="#mobileMenu" data-icon="ci:menu-alt-03"></span>
        </h4>
        <div class="header-text lglogo">
            <a class="navbar-brand" href="{{ route('home') }}">
                @if ($generalsetting->logo != null)
                    <img src="{{ asset($generalsetting->logo) }}" width="140px" class="img-fluid" alt="Shundorjo">
                @else
                    <img src="{{ asset('frontend/images/logo.png') }}" width="140px" class="img-fluid"
                        alt="Shundorjo">
                @endif
            </a>
        </div>

        <div class=" userActivitiesMobile">
            <span class="iconify mx-2" data-toggle="modal" data-target="#searchbar"
            data-icon="clarity:search-line"></span>

            <span class="iconify mr-2 text-dark" data-icon="ei:cart" data-toggle="modal" data-target="#cart"></span>
            <span class="cartNumberMobileTop">
                <div id="cartNumberTMobile">
                         <div class="cartitemsf">
                            @php
                $cartItems = Session::get('cart');
                $cartCount = $cartItems ? count($cartItems) : 0;
            @endphp


                {{ $cartCount }}

                </div>
                </div>
            </span>

        </div>

        {{-- Hasib modified nav bar  --}}
       <div class="navbarMenu" id="main-nav">
        <ul class="navbarMenu-nav">
            @foreach (\App\Models\Category::take(12)->get() as $key => $category)
            <li class="nav-item-menu has-child-menu c-1">
                {{-- <a class="nav-link-menu" href="{{ route('products.category', $category->id) }}">{{ __($category->name) }}</a> --}}
                <a class="nav-link-menu" href="{{ route('search', ['slug' => Str::slug($category->name),'category_id' => $category->id]) }}">{{ __($category->name) }}</a>
                <ul class="drop-down-menu drop-menu001">
                    @foreach ($category->subcategories as $key2 => $subcategory)
                    <li class="nav-item-menu has-child-menu">
                        <a class="nav-link-menu" href="{{ route('search', ['slug' => Str::slug($subcategory->name),'subcategory_id' => $subcategory->id]) }}">{{ __($subcategory->name) }}</a>
                        <ul class="drop-down-menu drop-menu002">
                            @foreach ($subcategory->subsubcategories as $key3 => $subsubcategory)
                            <li class="nav-item-menu"><a class="nav-link-menu" href="{{ route('search', ['slug' => Str::slug($subsubcategory->name),'subsubcategory_id' => $subsubcategory->id]) }}">{{ __($subsubcategory->name) }}</a></li>
                            @endforeach
                        </ul>
                    </li>
           @endforeach
                </ul>
            </li>
            @endforeach
        </ul>

    </div>
        {{-- Hasib modified nav bar  --}}


    </div>

</nav>
<style>
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
        background-color: rgba(0,0,0,.05);

    }
    .nav-item .nav-link{    text-align: center;
    text-transform: uppercase;
    letter-spacing: .3px;
    font-weight: 500;
    font-size: 12px;
    color: #222;
    height: 55px;
    cursor: pointer;}
    .list-group>li>a{
        color: #222;
    }
    .single-category a { color: #222;}
</style>
<!-- modal for mobile menu -->
<div class="modal " id="mobileMenu" tabindex="-1" role="dialog" aria-hidden="true" style="background-color: rgba(0,0,0,.04);
    border-bottom: 1px solid rgba(129,129,129,.2);">
    <div class="modal-dialog custom forMobile" role="document">
        <div class="modal-content h-100">
            <div class="modal-body" style="padding:0px !important;">
                <ul class="nav nav-tabs w-100" id="myTab" role="tablist" style="background-color: rgba(0,0,0,.04);">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#menu" role="tab"
                            aria-controls="menu" aria-selected="true">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="categories-tab" data-toggle="tab" href="#categories" role="tab"
                            aria-controls="categories" aria-selected="false">Categories</a>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent" style="padding: 1rem 1.5rem;">
                    <div class="tab-pane fade show active" style="overflow-y: auto; max-height: 100vh;" id="menu"
                        role="tabpanel" aria-labelledby="menu-tab">
                        <ul class="list-group list-group-flush">
                            {{-- <li class="list-group-item"><a href="">Demo</a> </li> --}}
                            <li class="list-group-item"> <a href="{{ route('products') }}">Shop</a></li>
                           <li class="list-group-item"> <a href="{{ route('brands.all') }}">Brands</a></li>
                            {{-- <li class="list-group-item"><a href="">Product</a></li>
                            <li class="list-group-item"><a href="">Sales</a></li> --}}
                            <li class="list-group-item"><a href="{{ route('aboutus') }}">About us</a></li>
                            <li class="list-group-item"><a href="{{ route('contactus') }}">Contact Us</a></li>
                            <li class="list-group-item"><a href="{{ route('faq') }}">FAQ</a></li>
                            <li class="list-group-item">  <a href="{{ route('product-truck') }}">Order Track</a></li>
                            <li class="list-group-item">
                            <a  href="{{ route('shundorjo-care-tips') }}" target="__blank">সৌন্দর্য কেয়ার</a>
                        </li>

                        </ul>
                    </div>
                    <div class="tab-pane fade" style="overflow-y: auto; max-height: 100vh;" id="categories"
                        role="tabpanel" aria-labelledby="categories-tab">
                        <div class="box-content">
                            <div class="category-accordion">
                                @foreach (\App\Models\Category::all() as $key => $category)
                                    <div class="single-category">
                                        <button style="position:left;" class="btn w-100 category-name collapsed" type="button"
                                            data-toggle="collapse" data-target="#category-{{ $key }}"
                                            aria-expanded="true">
                                            <a href="{{ route('search', ['slug' => Str::slug($category->name),'category_id' => $category->id]) }}" title="{{ __($category->name) }}">
                                                <img src="{{ asset($category->icon) }}" alt="{{ __($category->name) }}" width="30px" height="30px">
                                                {{ __($category->name) }}</a>

                                        </button>

                                        <div id="category-{{ $key }}" class="collapse">
                                            @foreach ($category->subcategories as $key2 => $subcategory)
                                                <div class="single-sub-category">
                                                    <button class="btn w-100 sub-category-name" type="button"
                                                        data-toggle="collapse"
                                                        data-target="#subCategory-{{ $key }}-{{ $key2 }}"
                                                        aria-expanded="true">
                                                        <a href="{{ route('search', ['slug' => Str::slug($subcategory->name),'subcategory_id' => $subcategory->id]) }}">

                                                 {{ __($subcategory->name) }}</a>
                                                    </button>
                                                    <div id="subCategory-{{ $key }}-{{ $key2 }}"
                                                        class="collapse">
                                                        <ul class="sub-sub-category-list">
                                                            @foreach ($subcategory->subsubcategories as $key3 => $subsubcategory)
                                                                <li><a
                                                                        href="{{ route('search', ['slug' => Str::slug($subsubcategory->name),'subsubcategory_id' => $subsubcategory->id]) }}">{{ __($subsubcategory->name) }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal for search -->
<div class="modal " id="searchbar" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog custom" role="document">
        <div class="modal-content h-100">
            <div class="modal-header">
                <h3 class="modal-title text-black" id="exampleModalLabel" style="font-weight: 500; font-size: 16px; font-family: Poppins;">Search Products for Your Shundorjo</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <form action="{{ route('search') }}" method="GET">
                        <div class="position-relative mt-3">

                            <input type="text" aria-label="Search" id="search" name="keyword" class="form-control rounded  my-3" placeholder="{{ __('I am shopping for Shundorjo') }}" autocomplete="off" style="height: 62px;">
                            
                            <a class="mb-2 shadow-sm text-center btn w-100 text-white" style=" background-color: #ff3d71;" href="{{ route('products') }}"><i class="la la-search la-flip-horizontal"></i> View All</a>
                         
                            <div class="typed-search-box d-none">
                                <div class="search-preloader">
                                    <div class="loader"><div></div><div></div><div></div></div>
                                </div>
                                <div class="search-nothing d-none">

                                </div>
                                <div id="search-content">

                                </div>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
<!-- modal for user -->
<div class="modal" id="userLogin" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 999999;">
    <div class="modal-dialog custom" role="document">
        <div class="modal-content h-100">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">LOGIN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.login.submit') }}" method="POST">
                    @csrf
                    <div class="col-lg-12">
                        @if ($errors->has('email'))
                            <p style="color: rgb(155, 37, 37)">These credentials do not match our records.</p>
                        @elseif($errors->has('password'))
                            <p style="color: rgb(155, 37, 37)">These credentials do not match our records.</p>
                        @elseif($errors->has('account'))
                            <p style="color: rgb(155, 37, 37)">Sorry! Account Not Found</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone Number</label>
                        <input type="phone" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                            value="{{ old('phone') }}" placeholder="{{ __('Phone Number') }}" name="email" id="email"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password"
                            class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                            placeholder="{{ __('Password') }}" name="password" id="password" required>
                    </div>
                    <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox" name="remember" id="remember"
                        checked readonly hidden>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                </form>
                <p class="my-2">New customer?
                    <a href="#userRegister" data-icon="ph:user-thin" data-toggle="modal" data-target="#userRegister"
                        class="link">Create your account</a>
                        OR
                    {{-- <span  data-icon="ph:user-thin" data-toggle="modal" data-target="#userRegister">Create your account</span> --}}
                    <a href="{{ route('forget.password.get') }}" class="link link-xs link--style-3">{{__('Forgot password?')}}</a>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- modal for user Registration -->
<div class="modal" id="userRegister" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 999999;">
    <div class="modal-dialog custom" role="document">
        <div class="modal-content h-100">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabelReg">USER REGISTRATION</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-default" role="form" action="{{ route('user.register') }}" method="POST">
                    @csrf
                    {{-- <div class="col-lg-12">
                            @if ($errors->has('email'))
                                <p style="color: rgb(155, 37, 37)">These credentials do not match our records.</p>
                            @elseif($errors->has('password'))
                                <p style="color: rgb(155, 37, 37)">These credentials do not match our records.</p>
                            @elseif($errors->has('account'))
                                <p style="color: rgb(155, 37, 37)">Sorry! Account Not Found</p>
                            @endif
                        </div> --}}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                            value="{{ old('name') }}" placeholder="{{ __('Name') }}" name="name" id="name"
                            required>
                        @error('name')
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone</label>
                        <input id="emailreg" type="number" class="form-control @error('error') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="{{ __('Phone') }}" name="email" required
                            autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span id="error_email"></span>
                    </div>
                    {{-- password --}}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" class="form-control" placeholder="{{ __('Password') }}"
                            name="password" id="passwords" pattern="{6}"
                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 6 or more characters"
                            required>
                    </div>
                    {{-- confirm password --}}
                    <div class="form-group">
                        <label for="exampleInputEmail1">Confirm Password</label>
                        <input type="password" class="form-control" placeholder="{{ __('Password') }}"
                            name="password_confirmation" id="password_confirmations" required>
                    </div>
                    {{-- password validation --}}
                    <div class="row">
                        <div class="col-12">
                            <div id="message">
                                <p><span id='messagev'></span></p>
                            </div>
                        </div>
                    </div>
                    {{-- password validation --}}
                    <input class="form-check-input" type="checkbox" name="checkbox_example_1" id="mySwitch"
                        required >
                         <label class="form-check-label" for="mySwitch"> I agree with the <a target="__blank" href="{{ route('terms') }}">terms and
                                                                conditions</a>.</label>

                    <button type="submit" name="register" id="register" class="btn btn-primary btn-lg btn-block">Create
                        Account</button>
                </form>
                {{ csrf_field() }}
                <p class="my-2"> Already have a acoount?
                    <a href="#userRegister" data-icon="ph:user-thin" data-toggle="modal" data-target="#userRegister"
                        class="link"> Login</a>
                        {{-- <a href="#userRegister" data-icon="ph:user-thin" data-toggle="modal" data-target="#userRegister" class="link">Create your account</a> --}}
                </p>
            </div>
        </div>
    </div>
</div>
<!-- modal for cart -->
<div class="modal " id="cart" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 999999;">
    <div class="modal-dialog custom" role="document" id="cart_items">
        <div class="modal-content h-100">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">SHOPPING CART</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (Session::has('cart'))
                    @if (count($cart = Session::get('cart')) > 0)

                        <div class="productListContaineR">
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($cart as $key => $cartItem)
                                @php
                                    $product = \App\Models\Product::find($cartItem['id']);
                                    $total = $total + $cartItem['price'] * $cartItem['quantity'];

                                @endphp
                                <div class="productCartList border-bottom my-2">
                                    <div class="items">
                                        <a href="{{ route('product', $product->slug) }}">
                                            <img src="{{ asset($product->thumbnail_img) }}" class="img-fluid"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="items">
                                        <a href="" class="pname lead">
                                            <h6><a href="{{ route('product', $product->slug) }}">
                                                    {{ __($product->name) }}
                                                </a></h6>
                                        </a>
                                        <div class="price">x{{ $cartItem['quantity'] }}
                                            {{ single_price($cartItem['price'] * $cartItem['quantity']) }}</div>

                                        <div class="modify ml-1">
                                            <a href="{{ route('cart') }}"><span class="iconify mr-1"
                                                    data-icon="bi:pencil-square"></span></a>
                                            <span onclick="removeFromCart({{ $key }})" class="iconify"
                                                data-icon="carbon:trash-can"></span>
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="bottomTotal">
                            <div class="row text-black">
                                <div class="col-md-6">
                                    <h4>Subtotal:</h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>{{ single_price($total) }}</h4>

                                </div>
                               {{-- <div class="col-md-12">
                                    <div class="form-group">

                                        <label for="chk"> <input type="checkbox" value="" name="" id="chk" required> I agree with <a target="__blank" href="{{ route('privacypolicy') }}">terms</a> the  and <a target="__blank" href="{{ route('returnpolicy') }}"> conditions </a>.</label>
                                    </div>
                                </div>--}}
                                <div
                                    class="col-md-12 text-center d-flex flex-column justify-content-center align-item-center">
                                    <a href="{{ route('cart') }}" class="text-center mb-2 btn btn-primary rounded">
                                        View Cart</a>
                                    @if (Auth::check())
                                        <a href="{{ route('checkout.shipping_info') }}"
                                            class="text-center btn btn-info rounded"> Checkout</a>
                                    @else
                                        <a href="{{ route('cart.login') }}"
                                            class="text-center btn btn-info rounded"> Checkout</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else

                        <div class="emptyProduct d-flex flex-column align-items-center justify-content-center">
                            <span class="iconify" data-icon="clarity:shopping-bag-line"></span>
                            <span class="py-2">Your cart is empty.</span>
                            <a href="{{ route('products') }}" class="btn btn-primary px-3 rounded">Return To
                                Shop</a>
                        </div>

                    @endif
                @else
                    {{-- <div class="shadow-sm py-2 px-1 text-center border-bottom"> Free Shipping for all orders over
                        ৳100.00</div> --}}
                    <div class="emptyProduct d-flex flex-column align-items-center justify-content-center">
                        <span class="iconify" data-icon="clarity:shopping-bag-line"></span>
                        <span class="py-2">Your cart is empty.</span>
                        <a href="{{ route('products') }}" class="btn btn-primary px-3 rounded">Return To
                            Shop</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#emailreg').keyup(function() {
            var error_email = '';
            var email = $('#emailreg').val();
            var _token = $('input[name="_token"]').val();
            var filter = /(^(01){1}[3456789]{1}(\d){8})$/;
            if (!filter.test(email)) {
                $('#error_email').html('<label class="text-danger">Invalid Phone Number</label>');
                $('#emailreg').addClass('has-error');
                $('#register').attr('disabled', 'disabled');
            } else if (email.length > 11) {
                $('#error_email').html('<label class="text-danger">Invalid Phone Number</label>');
                $('#emailreg').addClass('has-error');
                $('#register').attr('disabled', 'disabled');
            } else {
                $.ajax({
                    url: "{{ route('email_available.check') }}",
                    method: "POST",
                    data: {
                        email: email,
                        _token: _token
                    },
                    success: function(result) {
                        if (result == 'unique') {
                            $('#error_email').html(
                                '<label class="text-success">Phone Available</label>');
                            $('#emailreg').removeClass('has-error');
                            $('#register').attr('disabled', false);
                        } else {
                            $('#error_email').html(
                                '<label class="text-danger">Already have a Account</label>'
                            );
                            $('#emailreg').addClass('has-error');
                            $('#register').attr('disabled', 'disabled');
                        }
                    }
                })
            }
        });
        $('#password_confirmations').on('keyup', function() {
        if ($('#passwords').val() == $('#password_confirmations').val() && $('#passwords').val()) {
            $('#messagev').html('Password Match').css('color', 'green');
            $('#messagev').addClass('valid');
            $('#messagev').removeClass('invalid');
            $('#register').attr('disabled', false);
        } else {
            $('#messagev').html('Password doesn\'t Match').css('color', 'red');
            $('#messagev').addClass('invalid');
            $('#messagev').removeClass('valid')
            $('#register').attr('disabled', 'disabled');
        }
    });
    $('#passwords').on('keyup', function() {
        if ($('#passwords').val() == $('#password_confirmations').val() && $('#password_confirmations').val()) {
            $('#messagev').html('Password Match').css('color', 'green');
            $('#messagev').addClass('valid');
            $('#messagev').removeClass('invalid');
            $('#register').attr('disabled', false);
        } else {
            $('#messagev').html('Password doesn\'t Match').css('color', 'red');
            $('#messagev').addClass('invalid');
            $('#messagev').removeClass('valid')
            $('#register').attr('disabled', 'disabled');
        }
    });
    });
</script>
