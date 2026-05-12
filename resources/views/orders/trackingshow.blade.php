@extends('layouts.app')

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
    .table td, table th {
    border: 1px solid #c1b9b9;
    padding: 5px;
    }
</style>
<div>
    <div>
        {{-- search strt  --}}
        <form  action="{{route('tracking_search.index')}}" method ="POST">
            @csrf
            <br>
            <div class="container-fluid" style="background-color: rgb(0 0 0 / 20%); border: 1px solid #8a753bbf;">
                <div class="row">
                    <div class="col-md-9">
                        <label for="code" style="margin-top: 9px;" class="col-form-label col-md-3">Order Code</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" style="margin-top: 2px;" id="code" name="code" required placeholder="Input Order Number">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-success" name="search" title="Search" style="width: 220px"><img src="https://img.icons8.com/android/24/000000/search.png"/>Search</button>
                    </div>
                </div>
            </div>
            <br>
        </form>
{{-- search end  --}}
    </div>
    <div class="top-area justify-content-center">
        <div class="content">
            <h4 class="heading">
                Customer Order Details
            </h4>
            <h5><div class="float-left">{{__('Order Summary')}}</div></h5>
        </div>
    </div>
    <div class="card">
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
                            <td class="w-50 strong-600">{{__('Delivery Status')}}:</td>
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
                        <tr>
                            <td class="w-50 strong-600">{{__('Order Type')}}:</td>
                            <td>@if($order->meduserorder==1) Medication Order @else E-commerce Order @endif</td>
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
                                <th width="10%">{{__('Photo')}}</th>
                                <th width="30%">{{__('Product')}}</th>
                                <th>{{__('Variation')}}</th>
                                <th>{{__('Quantity')}}</th>
                                <th>{{__('Price')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $key => $orderDetail)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank"><img src="{{ asset($orderDetail->product->thumbnail_img) }}" width="50px" alt="{{ asset($orderDetail->product->thumbnail_img) }}"></a></td>
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
                            <tr>
                                <th>{{__('Tax')}}</th>
                                <td class="text-right">
                                    <span class="text-italic">{{ single_price($order->orderDetails->sum('tax')) }}</span>
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
    <div class="row">
        <div class="col-lg-12">
              {{-- tracking_complain strt  --}}
                <form  action="{{route('tracking_complain.store')}}" method ="POST">
                    @csrf
                    <br>
                    <div class="container-fluid" style="background-color: rgb(0 0 0 / 20%); border: 1px solid #8a753bbf;">
                        <div class="row">
                            <div class="col-md-9">
                                <label for="complain" style="margin-top: 13px; font-weight: 600; font-size: 14px;" class="col-form-label col-md-3">Add Request/Complain</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" style="margin-top: 2px; height: 41px;" id="complain" name="complain" required placeholder="Add Customer Request/Complain">
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-lg btn-success w-100" name="search" title="Search">Add Request/Complain</button>
                            </div>
                        </div>
                    </div>
                    <br>
                </form>
              {{-- tracking_complain end  --}}
        </div>
    </div>


</div>





@endsection


