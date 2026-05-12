@extends('frontend.layouts.app')
@section('title')
    Purchase History
@stop
@section('content')

<div class="dashbaord-main">
    @if(Auth::user()->user_type == 'seller')
        @include('frontend.inc.seller_side_nav')
    @elseif(Auth::user()->user_type == 'customer')
        @include('frontend.inc.customer_side_nav')
    @elseif(Auth::user()->user_type == 'doctor')
        @include('frontend.inc.doctor_side_nav')
    @endif
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
            <section class="profile purchase-status">
                <div class="title-section">
                    <span class="iconify mr-1" data-icon="et:wallet"></span>  Orders
                </div>
                <div class="infoBox mt-3">
                    <div class="row col-lg-12 mx-auto">
                        <div class="col-lg-11 mx-auto">
                            {{-- <form class="form-custom mt-4" action=""> --}}
                                <div class="row shadow-sm">
                                    <div class="p-0 col-md-12 bg-white">
                                        <div class="form-container ">
                                            <div class="overflow">
                                                @if (count($orders) > 0)
                                                <table class="table table-custom shadow-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>#Order Id</th>
                                                            <th>Date</th>
                                                            <th>Amount</th>
                                                            <th>Order Status</th>
                                                            <th>Payment </th>
                                                            <th>Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($orders as $key => $order)
                                                        <tr>
                                                            <td><a href="#{{ $order->code }}" onclick="show_purchase_history_details({{ $order->id }})">{{ $order->code }}</a></td>
                                                            <td>{{ date('d-m-Y', $order->date) }}</td>
                                                            <td>{{ single_price($order->grand_total) }}</td>
                                                            <td>
                                                                @php
                                                                    $status = $order->delivery_status;
                                                                @endphp
                                                                @if ($order->delivery_status == 'wpayment')
                                                                    Waiting for payment
                                                                @else
                                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($order->payment_status == 'paid')
                                                                    <button class="btn btn-success btn-sm" disabled>Payment Complete</button>
                                                                @else
                                                                <form action="{{route('payment.med.order')}}" method="post">
                                                                    @csrf
                                                                    <input type="text" name="amount" id="" value="{{$order->grand_total}}" readonly hidden>
                                                                    <input type="text" name="payment_option" id="" value="medorder" readonly hidden>
                                                                    <input type="text" name="tran_id" id="" value="{{$order->id}}" readonly hidden>
                                                                    <button class="pay-now">pay now</button></td>
                                                                </form>
                                                                @endif

                                                            <td>
                                                                <div class="action">
                                                                    <span onclick="show_purchase_history_details({{ $order->id }})" title="Order Details"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                                                    <a href="{{ route('customer.invoice.download', $order->id) }}" class="dropdown-item"><span title="Download Invoice" ><i class="fa fa-download" aria-hidden="true"></i></span></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @else
                                                <span>Order not found</span>
                                                @endif
                                            </div>

                                            <div class="pagination-wrapper py-4">
                                                <ul class="pagination justify-content-end">
                                                    {{ $orders->links() }}
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
</div>

    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>

@endsection
