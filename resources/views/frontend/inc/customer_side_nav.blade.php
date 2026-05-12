<div class="leftSection wow fadeIn" data-wow-delay=".25s" id='leftSidebar'>
    <!-- <div class="brand">
        <img src="images/logo.png" alt="">
    </div> -->
    <div class="user-profile">
        <div class="close-dashboard-sidebar">
            <span class="iconify" onclick="foldSidebar();" data-icon="mdi:window-close"></span>
        </div>
        {{-- @if(!empty(Auth::user()->avatar_original))
            <img src="{{asset(Auth::user()->avatar_original)}}" alt="">
        @else
            <img src="{{asset('uploads/1.jpg')}}" alt="">
        @endif
        <p class='user-name mb-0'>
            <span>{{ Auth::user()->name }}</span>
        </p> --}}
    </div>
    <nav class="sidenav">
        <ul>
            <li class="nav-item {{ areActiveRoutesHome(['dashboard'])}}">
                <a href="{{ route('dashboard') }}" class="">
                    <span class="iconify" data-icon="clarity:dashboard-solid-badged"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item {{ areActiveRoutesHome(['purchase_history.index'])}}">
                <a href="{{ route('purchase_history.index') }}" class="">
                    <span class="iconify" data-icon="raphael:history"></span>
                    Orders
                </a>
            </li>
            <li class="nav-item {{ areActiveRoutesHome(['product-truck'])}}">
                <a href="{{ route('product-truck') }}" class="">
                    <span class="iconify" data-icon="raphael:history"></span>
                    Track Orders
                </a>
            </li>
            <li class="nav-item {{ areActiveRoutesHome(['wishlists.index'])}}">
                <a href="{{ route('wishlists.index') }}" class="">
                    <span class="iconify" data-icon="clarity:heart-solid"></span>
                    Wishlist
                </a>
            </li>
            <!--<li class="nav-item {{ areActiveRoutesHome(['usermedication.view'])}} {{ areActiveRoutesHome(['usermedication.index'])}}">-->
            <!--    @if(!empty(\App\Models\Medication::where('user_id', '=', Auth::user()->id)->first()->user_id))-->
            <!--    <a href="{{route('usermedication.view')}}" class="">-->
            <!--        <span class="iconify" data-icon="ic:outline-medication"></span>-->
            <!--        Medication-->
            <!--    </a>-->
            <!--    @else-->
            <!--    <a href="{{ route('usermedication.index') }}" class="">-->
            <!--        <span class="iconify" data-icon="ic:outline-medication"></span>-->
            <!--        Medication-->
            <!--    </a>-->
            <!--    @endif-->

            <!--</li>-->
            <!--<li class="nav-item {{ areActiveRoutesHome(['prescription.index'])}}">-->
            <!--    <a href="{{ route('prescription.index') }}" class="">-->
            <!--        <span class="iconify" data-icon="fluent:note-add-16-filled"></span>-->
            <!--        Prescription-->
            <!--    </a>-->
            <!--</li>-->
            <li class="nav-item {{ areActiveRoutesHome(['profile'])}}">
                <a href="{{ route('profile') }}" class="">
                    <span class="iconify" data-icon="icomoon-free:profile"></span>
                    Profile
                </a>
            </li>
            <li class="nav-item {{ areActiveRoutesHome(['address.book','address.edit','address.add','default.shipping.address','default.billing.address'])}}">
                <a href="{{ route('address.book') }}" class="">
                    <span class="iconify" data-icon="icomoon-free:profile"></span>
                    Address
                </a>
            </li>
            {{-- <li class="nav-item {{ areActiveRoutesHome(['wallet.index'])}}">
                <a href="{{ route('wallet.index') }}" class="">
                    <span class="iconify" data-icon="fontisto:wallet"></span>
                    Wallet
                </a>
            </li> --}}


            <li class="nav-item {{ areActiveRoutesHome(['message.index'])}}">
                <a href="{{ route('message.index') }}" class="">
                    <span class="iconify" data-icon="bpmn:end-event-message"></span>
                    Message
                </a>
            </li>


            <!--new code -->
            <!--@if(isset(Auth::user()->ref_id))-->
            <!--<li class="nav-item {{ areActiveRoutesHome(['withdraw.index'])}}">-->
            <!--    <a href="{{ route('withdraw.index') }}" class="">-->
            <!--        <span class="iconify" data-icon="ri:lock-password-fill"></span>-->
            <!--        Withdraw-->
            <!--    </a>-->
            <!--</li>-->
            <!--<li class="nav-item {{ areActiveRoutesHome(['withdraw-method'])}}">-->
            <!--    <a href="{{ route('withdraw-method') }}" class="">-->
            <!--        <span class="iconify" data-icon="ri:lock-password-fill"></span>-->
            <!--        Withdraw Method-->
            <!--    </a>-->
            <!--</li>-->
            <!--<li class="nav-item {{ areActiveRoutesHome(['transaction.index'])}}">-->
            <!--    <a href="{{ route('transaction.index') }}" class="">-->
            <!--        <span class="iconify" data-icon="ri:lock-password-fill"></span>-->
            <!--        Transaction-->
            <!--    </a>-->
            <!--</li>-->
            <!--@endif-->


            <!--end -->

            <!--<li class="nav-item {{ areActiveRoutesHome(['affiliate.index'])}}">-->
            <!--    <a href="{{ route('affiliate.index') }}" class="">-->
            <!--        <span class="iconify" data-icon="ri:lock-password-fill"></span>-->
            <!--        Agent-->
            <!--    </a>-->
            <!--</li>-->
            <!--<li class="nav-item {{ areActiveRoutesHome(['changepassword'])}}">-->
            <!--    <a href="{{ route('changepassword') }}" class="">-->
            <!--        <span class="iconify" data-icon="ri:lock-password-fill"></span>-->
            <!--        Change Password-->
            <!--    </a>-->
            <!--</li>-->
            <li class="nav-item {{ areActiveRoutesHome(['logout'])}}">
                <a href="{{ route('logout') }}" class="">
                    <span class="iconify" data-icon="ri-logout-box-line"></span>
                    Logout
                </a>
            </li>
            {{-- <li class="nav-item ">
                <a href="cart.html">
                    <span class="iconify" data-icon="ri:lock-password-fill"></span>
                    cart
                </a>
            </li>
            <li class="nav-item ">
                <a href="payment.html">
                    <span class="iconify" data-icon="ri:lock-password-fill"></span>
                   Payment Methods
                </a>
            </li> --}}

            <!-- <li class="nav-item">
                <a href="#">
                    <span class="iconify" data-icon="ic:baseline-space-dashboard"></span>
                    Submenu Item
                </a>
                <ul class="sub-item">
                    <li><a href="#"> <span class="iconify" data-icon="bi:arrow-right-short"></span></span> sub
                            items 1</a></li>
                    <li><a href="#"> <span class="iconify" data-icon="bi:arrow-right-short"></span></span> sub
                            items 1</a></li>
                </ul>
            </li> -->

        </ul>
    </nav>
</div>
