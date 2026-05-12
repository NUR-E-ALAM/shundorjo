@extends('frontend.layouts.app')
@section('content')
    <!-- dashboard  section -->
    <div class="dashbaord-main">
        @include('frontend.inc.customer_side_nav')
        <div class="rightSection">
            <div class="topbar">
                <div class="fold" onclick='foldSidebar();'>
                    <span class="iconify" data-icon="eva:menu-fill"></span>
                </div>
                <!-- <img src="images/logo.png" class="mobile-menu-logo"> -->
                <!--<div class="right-element">-->
                <!--    <div class="dropdown">-->
                <!--        <a class="btn dropdown-toggle profile-manage" href="#" role="button" id="dropdownMenuLink"-->
                <!--            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                <!--            @if(!empty(Auth::user()->avatar_original))-->
                <!--            <img src="{{asset(Auth::user()->avatar_original)}}" alt="">-->
                <!--            @else-->
                <!--                <img src="{{asset('uploads/1.jpg')}}" alt="">-->
                <!--            @endif-->
                <!--        </a>-->

                <!--        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">-->
                <!--            <a class="dropdown-item" href="{{ route('profile') }}"><span class="iconify"-->
                <!--                    data-icon="carbon:user-avatar"></span> Profile</a>-->
                <!--            <a class="dropdown-item" href="{{ route('logout') }}"><span class="iconify"-->
                <!--                    data-icon="ion:log-out-outline"></span> Log Out</a>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
            <div class="dashboard-content">
                <div class="rows">

                    <div class="cols">
                        <div class="card">
                            <div data-wow-delay=".25s" class="wow fadeIn box text-center theme-1 p-3 ">
                                <span class="iconify bg-violet" data-icon="mdi-light:cart"></span>
                                <div class="inner theme-txt-violet">
                                    @if(Session::has('cart'))
                                    <h1 class="my-0 ">{{ count(Session::get('cart'))}}</h1>
                                    <h5 class="my-0 ">Products in Your cart </h5>
                                    @else
                                    <h1 class="my-0 ">0</h1>
                                    <h5 class="my-0 ">Products in Your cart </h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cols">
                        <div class="card">
                            <div data-wow-delay=".30s" class="wow fadeIn box text-center theme-2 p-3 ">
                                <span class="iconify bg-pink" data-icon="ei:heart"></span>
                                <div class="inner theme-txt-pink">
                                    <h1 class="my-0 ">{{ count(Auth::user()->wishlists)}}</h1>
                                    <h5 class="my-0 ">Products in your wishlist </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cols">
                        <div class="card">
                            <div data-wow-delay=".35s" class="wow fadeIn box text-center theme-yellow p-3 ">
                                <span class="iconify bg-yellow" data-icon="healthicons:i-note-action-outline"></span>
                                <div class="inner theme-txt-yellow">
                                    @php
                                    $orders = \App\Models\Order::where('user_id', Auth::user()->id)->get();
                                    $total = 0;
                                    foreach ($orders as $key => $order) {
                                        $total += count($order->orderDetails);
                                    }
                                    @endphp
                                    <h1 class="my-0 ">{{ $total }}</h1>
                                    <h5 class="my-0">you ordered </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @foreach ($address as $item)
                <div class="rows ">
                    <div class="title-section w-100 justify-content-between flex-wrap">
                         <span>Default Shipping Address</span>
                         <a href="{{ route('address.edit', $item->id) }}" class="btn-theme text-white">Edit</a>
                    </div>
                    <div class="form-container w-100">
                        <div class="overflow">
                            <table class="table table-custom shadow-sm">
                                <thead>
                                    <tr>
                                        <th>Address</th>
                                        <th>city</th>
                                        <th>Region</th>
                                        <th>Postal code</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$item->address}}</td>
                                        <td>{{App\Models\District::where('id', '=', $item->city)->first()->name}}</td>
                                        <td>{{\App\Models\Division::where('id', '=', $item->region)->first()->name}}</td>
                                        <td>{{$item->post_code}}</td>
                                        <td>{{$item->phone}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
@section('script')
<script>
    function myFunction() {
  /* Get the text field */
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Copied the text: " + copyText.value);
}
</script>

@endsection
