@php
$generalsetting = \App\Models\GeneralSetting::first();
@endphp
<style>
    ul {
    list-style:none;
}
</style>
<footer class="py-3 mt-4" style="background: #192038 !important; color:white !important;">
    <div class="container">
        <div class="my-4">
            <div class="row justify-content-lg-between">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <h5 onclick="mobileViewActive('logos');" class="text-white d-flex justify-content-between">
                    <span class="getfooter">GET IN TOUCH</span>
                        <span class="iconify clickableIcon" data-icon="akar-icons:plus"></span>
                    </h5>
                    <!-- Nav Link -->
                    <ul class="flex-column  visualcolumn" id="colOne">
                        <li class=""></i>@if ($generalsetting->logo != null)
                            <img src="{{ asset($generalsetting->logo) }}" class="img-fluid"
                                alt="Shundorjo" style="width:160px;">
                        @else
                            <img src="{{ asset('frontend/images/logo.png') }}" width="150px" class="img-fluid"
                                alt="Shundorjo">
                        @endif
                        </li>
                        <li class=""><i class="fa fa-map-marker"> </i>
                        @if ($generalsetting->address != null)
                            {{ $generalsetting->address }}
                        @else
                            Add Address here from Backend
                        @endif
                        </li>
                        <li class=""><i class="fa fa-envelope"> </i>
                            @if ($generalsetting->email != null)
                                <a class="cg" href="mailto:{{ $generalsetting->email }}">
                                    {{ $generalsetting->email }}
                                </a>
                            @else
                                <a class="cg" href="#">
                                    tanzirnur@gmail.com
                                </a>
                            @endif
                        </li>
                        <li class=""><i class="fa fa-mobile" aria-hidden="true"> </i>
                            @if ($generalsetting->phone != null)
                                <a class="cg" href="tel:{{ $generalsetting->phone }}">

                                    {{ $generalsetting->phone }}
                                </a>
                            @else
                                <a class="cg" href="#">
                                    01738356180
                                </a>
                            @endif
                        </li>

                    </ul>
                    <!-- End Nav Link -->
                </div>

                <div class="col-lg-2 col-md-2 col-sm-6">
                    <h5 onclick="mobileViewActive('info');" class="text-pink d-flex justify-content-between">
                        <span>TOP CATEGORIES</span>
                        <span class="iconify clickableIcon" data-icon="akar-icons:plus"></span>
                    </h5>
                    <!-- Nav Link -->
                    <ul class=" flex-column  visualcolumn" id="colTwo">
                        @foreach (\App\Models\Category::where('featured', 1)->limit(5)->get()
    as $key => $category)
                            <li class=""> <a href="{{ route('products.category', $category->id) }}"
                                    class="text-white">{{ __($category->name) }}</a></li>
                        @endforeach
                    </ul>
                    <!-- End Nav Link -->
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <h5 onclick="mobileViewActive('link');" class="text-pink d-flex justify-content-between">
                        <span>USEFULL LINK</span>
                        <span class="iconify clickableIcon" data-icon="akar-icons:plus"></span>
                    </h5>

                    <!-- Nav Link -->
                    <ul class="flex-column visualcolumn" id="colThree">
                        <li class="n"><a class="text-white" href="{{ route('aboutus') }}" target="__blank">About
                                us</a></li>
                        <li class=""><a class="text-white" href="{{ route('contactus') }}" target="__blank">Contact
                                Us</a></li>
                        <li class=""><a class="text-white"
                                href="{{ route('privacypolicy') }}" target="__blank">Privacy</a></li>
                        <li class=""><a class="text-white"
                                href="{{ route('returnpolicy') }}" target="__blank">Returns Policy</a></li>
                        <li class="n"><a class="text-white" href="{{ route('faq') }}">FAQ</a></li>
                    </ul>
                    <!-- End Nav Link -->
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <!-- End Nav Link -->
                    <div id="contact">
                        <h5 onclick="mobileViewActive('contact');"
                            class="text-pink d-flex justify-content-between">
                            <span>CONTACT US</span>
                            <span class="iconify clickableIcon" data-icon="akar-icons:plus"></span>
                        </h5>
                        <div class="text-white visualcolumn" id="colFour">
                            <i class="la la-phone-square"></i>
                            @if ($generalsetting->phone != null)
                                <a class="cg" href="tel:{{ $generalsetting->phone }}">

                                    {{ $generalsetting->phone }}
                                </a>
                            @else
                                <a class="cg" href="tel:01674437137">
                                     01674437137
                                </a>
                            @endif
                        </div>
                        <ul class="list-inline mb-0 mt-3 social-sites visualcolumn">
                            <li class="list-inline-item">

                                @if ($generalsetting->facebook != null)
                                    <a class="text-white" href="{{ $generalsetting->facebook }}">
                                        <span class="iconify" data-icon="ant-design:facebook-filled"
                                            data-inline="false"></span>
                                    </a>
                                @else
                                    <a class="text-white" href="#">
                                        <span class="iconify" data-icon="ant-design:facebook-filled"
                                            data-inline="false"></span>
                                    </a>
                                @endif
                            </li>
                            <li class="list-inline-item">
                                @if ($generalsetting->youtube != null)
                                    <a class="text-white" href="{{ $generalsetting->youtube }}">
                                        <span class="iconify" data-icon="fa-brands:youtube"
                                            data-inline="false"></span>
                                    </a>
                                @else
                                    <a class="text-white" href="#">
                                        <span class="iconify" data-icon="fa-brands:youtube"
                                            data-inline="false"></span>
                                    </a>
                                @endif


                            </li>
                            <li class="list-inline-item">
                                @if ($generalsetting->twitter != null)
                                    <a class="text-white" href="{{ $generalsetting->twitter }}">
                                        <span class="iconify" data-icon="fa-brands:twitter-square"
                                            data-inline="false"></span>
                                    </a>
                                @else
                                    <a class="text-white" href="">
                                        <span class="iconify" data-icon="fa-brands:twitter-square"
                                            data-inline="false"></span>
                                    </a>
                                @endif

                            </li>
                            <li class="list-inline-item">
                                @if ($generalsetting->instagram != null)
                                    <a class="text-white" href="{{ $generalsetting->instagram }}">
                                        <span class="iconify" data-icon="fa-brands:instagram-square"
                                            data-inline="false"></span>
                                    </a>
                                @else
                                    <a class="text-white" href="">
                                        <span class="iconify" data-icon="fa-brands:instagram-square"
                                            data-inline="false"></span>
                                    </a>
                                @endif

                            </li>
                            <!-- End Social Networks -->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <h6 onclick="mobileViewActive('apps');" class="text-white d-flex justify-content-between">
                        <span>  Full Cash on Delivery Available</span>
                        <span class="iconify clickableIcon" data-icon="akar-icons:plus"></span>
                    </h6>
                    <!-- Nav Link -->
                    <ul class=" visualcolumn" id="colFive">

                        <li class="">
                            <a class="py-1 d-block app_download_link" href=" "><img class='img-fluid' loading="lazy"
                                    src="{{ asset('frontend/images/payment.jpg') }}" alt="Cash On Delivery"></a>
                        </li>
                    </ul>
                    <!-- End Nav Link -->
                </div>
            </div>
        </div>
        <hr class="my-4" style="background:rgba(255,255,255,0.5)">
        <div class="space-1">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 mb-2 my-2">
                    <!-- Copyright -->
                    <div class="text-center">
                        <p class="text-white small mobileHeightfooter">© Copyright 2016- @php echo date('Y'); @endphp.
                            All rights reserved <a href="https://www.shundorjo.com/" title="Shundorjo">Shundorjo</a>.</p>
                    </div>
                    <!-- End Copyright -->
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12  my-2">
                    <!-- Copyright -->
                    <div class="text-lg-right">
                        <p class="text-white small"></p>
                    </div>
                    <!-- End Copyright -->
                </div>
            </div>

        </div>
    </div>
</footer>

<div class="bottom-menu" id="bottom-menu">
    <div class="links">
        <div class="nav-cart-box dropdown" id="cart_items1">
            <a href="{{ route('products') }}" class="nav-box-link">
                <span class="iconify" data-icon="lucide:layout-dashboard"></span>
                <span>Shop</span>
          </a>

        </div>
        <a href="{{ route('wishlists.index') }}">
            <span class="iconify" data-icon="ant-design:heart-outlined"></span>
            <span>Wishlist</span>
        </a>
        <a data-icon="ei:cart" data-toggle="modal" data-target="#cart">
            <span class="iconify" data-icon="clarity:shopping-cart-line"></span>
            <span>Cart</span>
            {{-- <span class="count">0</span> --}}
            <span class="cartNumberBottom">
                <div class="count" id="cartNumberNav">
                    @if (Session::has('cart'))
                        <div class="cartitem">
                            {{ count(Session::get('cart')) }}
                        </div>
                    @else
                        <div class="cartitem">
                            0
                        </div>
                    @endif
                </div>
            </span>
        </a>
        <a href="{{ route('dashboard') }}">
            <span class="iconify" data-icon="clarity:user-line"></span>
            <span>Account</span>
        </a>
        <span>
            <span class="iconify" data-icon="clarity:search-line" data-toggle="modal" data-target="#searchbar"></span>
            <span>Search</span>
        </span>
    </div>
</div>
