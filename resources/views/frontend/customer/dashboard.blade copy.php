@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.customer_side_nav')
                </div>
                <div class="col-lg-9">
                    <!-- Page title -->
                    <div class="page-title">
                        <div class="row align-items-center">
                            {{-- <div class="col-md-9 col-12">
                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                    {{__('Dashboard ')}}{{__(' > Your Identityfication No : ')}}
                                    <input type="text" value="{{Auth::user()->cid}}" readonly id="myInput">
                                    <!-- The button used to copy the text -->
                                    <button onclick="myFunction()">Copy ID</button>
                                </h2>
                            </div> --}}
                            <div class="col-md-3 col-12">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                        <li class="active"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- dashboard content -->
                    <div class="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dashboard-widget text-center green-widget mt-4 c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <i class="fa fa-shopping-cart"></i>
                                        @if(Session::has('cart'))
                                            <span class="d-block title">{{ count(Session::get('cart'))}} Product(s)</span>
                                        @else
                                            <span class="d-block title">0 Product</span>
                                        @endif
                                        <span class="d-block sub-title">in your cart</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-widget text-center red-widget mt-4 c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <i class="fa fa-heart"></i>
                                        <span class="d-block title">{{ count(Auth::user()->wishlists)}} Product(s)</span>
                                        <span class="d-block sub-title">in your wishlist</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-widget text-center yellow-widget mt-4 c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <i class="fa fa-building"></i>
                                        @php
                                            $orders = \App\Models\Order::where('user_id', Auth::user()->id)->get();
                                            $total = 0;
                                            foreach ($orders as $key => $order) {
                                                $total += count($order->orderDetails);
                                            }
                                        @endphp
                                        <span class="d-block title">{{ $total }} Product(s)</span>
                                        <span class="d-block sub-title">you ordered</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- shipping address  --}}
                            @foreach ($address as $item)
                            <div class="col-md-4">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 clearfix ">
                                        @if($item->label == 'Home') <i class="fa fa-home" aria-hidden="true"> </i> @endif @if($item->label == 'Office')<i class="fa fa-building-o" aria-hidden="true"></i> @endif {{__('Default Shipping Info')}}
                                        <div class="float-right">
                                            <a href="{{ route('address.edit', $item->id) }}" class="btn btn-link btn-sm">{{__('Edit')}}</a>
                                        </div>
                                    </div>
                                    <div class="form-box-content p-3">
                                        <table>
                                            <tr>
                                                <td>{{__('name')}}:</td>
                                                <td class="p-2">{{ $item->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Email')}}:</td>
                                                <td class="p-2" style="word-break: break-word;">{{ $item->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('phone')}}:</td>
                                                <td class="p-2">{{ $item->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('region')}}:</td>
                                                <td class="p-2">{{ $item->region }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('city')}}:</td>
                                                <td class="p-2">{{ $item->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('area')}}:</td>
                                                <td class="p-2">{{ $item->area }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('address')}}:</td>
                                                <td class="p-2" style="word-break: break-word;">{{ $item->address }}</td>
                                            </tr>


                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            {{-- shipping address  --}}
                            @foreach ($billaddress as $item)
                            <div class="col-md-4">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 clearfix ">
                                        @if($item->label == 'Home') <i class="fa fa-home" aria-hidden="true"> </i> @endif @if($item->label == 'Office')<i class="fa fa-building-o" aria-hidden="true"></i> @endif {{__('Default Billing Info')}}
                                        <div class="float-right">
                                            <a href="{{ route('address.edit', $item->id) }}" class="btn btn-link btn-sm">{{__('Edit')}}</a>
                                        </div>
                                    </div>
                                    <div class="form-box-content p-3">
                                        <table>
                                            <tr>
                                                <td>{{__('name')}}:</td>
                                                <td class="p-2">{{ $item->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Email')}}:</td>
                                                <td class="p-2" style="word-break: break-word;">{{ $item->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('phone')}}:</td>
                                                <td class="p-2">{{ $item->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('region')}}:</td>
                                                <td class="p-2">{{ $item->region }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('city')}}:</td>
                                                <td class="p-2">{{ $item->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('area')}}:</td>
                                                <td class="p-2">{{ $item->area }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('address')}}:</td>
                                                <td class="p-2" style="word-break: break-word;">{{ $item->address }}</td>
                                            </tr>


                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

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
