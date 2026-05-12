@extends('frontend.layouts.app')
@section('content')
<style>
    .top-area .content .heading {
        font-size: 30px;
        font-weight: 700;
    }
    .top-area .content .text {
        margin-bottom: 0;
        font-size: 16px;
        line-height: 26px;
    }
    .top-area .content .link {
        font-weight: 700;
        font-size: 14px;
        text-decoration: underline;
    }
    .justify-content-center {
        -ms-flex-pack: center!important;
        justify-content: center!important;
        text-align: center;
    }
</style>
<div class="container">
    <div class="top-area justify-content-center">
        <div class="content">
            <h4 class="heading">
                THANK YOU FOR YOUR PURCHASE.
            </h4>
            <p class="text">
                We'll email you an order confirmation with details and tracking info.
            </p>
            <a href="{{ route('home') }}" class="link">Get Back To Our Homepage</a>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header py-2 px-3 heading-6 strong-600 clearfix">
            <div class="float-left">{{__('Order Summary')}}</div>
        </div>
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-lg-6">
                    <table class="details-table table">
                        <tr>
                            <td class="w-50 strong-600">{{__('Order id')}}:</td>
                            <td>{{ $order->code }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Customer')}}:</td>
                            <td>{{ json_decode($order->shipping_address)->name }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Email')}}:</td>
                            {{-- @if ($order->user_id != null)
                                <td>{{ $order->user->email }}</td>
                                @else


                            @endif --}}
                            <td>{{ json_decode($order->shipping_address)->email }} </td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Shipping address')}}:</td>
                            <td>{{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->area }}, {{ json_decode($order->shipping_address)->city }}-{{ json_decode($order->shipping_address)->post_code }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="details-table table">
                        <tr>
                            <td class="w-50 strong-600">{{__('Order date')}}:</td>
                            <td>{{ date('d-m-Y H:m A', $order->date) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Delivery status')}}:</td>
                            <td>{{ ucfirst(str_replace('_', ' ', \App\Models\Order::where('id','=',$order->id)->first()->delivery_status)) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Total amount')}}:</td>
                            <td>{{ single_price($order->grand_total) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Shipping method')}}:</td>
                            <td>{{__('Flat shipping rate')}}</td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Payment method')}}:</td>
                            <td>{{ $order->payment_type }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9">
            <div class="card mt-4">
                <div class="card-header py-2 px-3 heading-6 strong-600">{{__('Order Details')}}</div>
                <div class="card-body pb-0">
                    <table class="details-table table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th width="40%">{{__('Product')}}</th>
                                <th>{{__('Variation')}}</th>
                                <th>{{__('Quantity')}}</th>
                                <th>{{__('Price')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $key => $orderDetail)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank">{{ $orderDetail->product->name }}</a></td>
                                    <td>
                                        {{ $orderDetail->variation }}
                                    </td>
                                    <td>
                                        {{ $orderDetail->quantity }}
                                    </td>
                                    <td>{{ single_price($orderDetail->price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card mt-4">
                <div class="card-header py-2 px-3 heading-6 strong-600">{{__('Order Ammount')}}</div>
                <div class="card-body pb-0">
                    <table class="table details-table">
                        <tbody>
                            <tr>
                                <th>{{__('Subtotal')}}</th>
                                <td class="text-right">
                                    <span class="strong-600">{{ single_price($order->orderDetails->sum('price')) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{__('Shipping')}}</th>
                                <td class="text-right">
                                    <span class="text-italic">{{ single_price($order->shipping_cost) }}</span>
                                </td>
                            </tr>
                            <!--<tr>-->
                            <!--    <th>{{__('Tax')}}</th>-->
                            <!--    <td class="text-right">-->
                            <!--        <span class="text-italic">{{ single_price($order->orderDetails->sum('tax')) }}</span>-->
                            <!--    </td>-->
                            <!--</tr>-->
                            <tr class="cart-total">
                                <th><span>{{__('Discount')}}</span></th>
                                <td class="text-right">
                                    <strong><span>{{ single_price($order->discount) }}</span></strong>
                                </td>
                            </tr>
                            <tr>
                                <th><span class="strong-600">{{__('Total')}}</span></th>
                                <td class="text-right">
                                    <strong><span>{{ single_price($order->grand_total) }}</span></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection
