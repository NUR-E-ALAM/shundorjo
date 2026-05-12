@extends('frontend.layouts.app')
@section('title')
    About Us
@stop
@section('content')

    <section class="gry-bg py-4">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="bg-white">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Truck Product</h4>
                                </div>
                                <div class="card-body" id="offersContainer">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                <div>
                                                    {{-- search strt --}}
                                                    <form action="{{ route('product_truck.show') }}" method="POST">
                                                        @csrf
                                                        <br>
  <div class="container-fluid" >
    <div class="row">
      <div class="col-8">
 <input type="text" class="form-control" id="code" name="code" required placeholder="Order Number">
                                                                </div>
    <button type="submit" class="btn btn-sm"  name="search" title="Search"><img
                                                                            src="https://img.icons8.com/android/24/000000/search.png" />Search</button>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </form>
                                                    {{-- search end --}}
                                                </div>
                                                <div class="top-area justify-content-center">
                                                    <div class="content text-center">
                                                        <h4 class="heading">
                                                            Customer Order Details
                                                        </h4>
                                                        <h5>
                                                            <div>{{ __('Order Summary') }}</div>
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="pt-4">
                                                    <ul class="process-steps clearfix">
                                                        <li class="done">
                                                            <div class="icon">1</div>
                                                            <div class="title">{{__('Order placed')}}</div>
                                                        </li>
                                                        <li @if($order->delivery_status == 'processing' || $order->delivery_status == 'on_delivery'|| $order->delivery_status == 'delivered') class="done" @else class="active" @endif>
                                                            <div class="icon">2</div>
                                                            <div class="title">{{__('On Processing')}}</div>
                                                        </li>
                                                        </li>
                                                        <li @if($order->delivery_status == 'delivered' || $order->delivery_status == 'on_delivery') class="done" @else class="active" @endif>
                                                            <div class="icon">3</div>
                                                            <div class="title">{{__('On delivery')}}</div>
                                                        </li>
                                                        <li @if($order->delivery_status == 'delivered') class="done" @else class="active" @endif>
                                                            <div class="icon">4</div>
                                                            <div class="title">{{__('Delivered')}}</div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body pb-0">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <table class="details-table table">
                                                                    <tr>
                                                                        <td class="w-50 strong-600">{{ __('Order id') }}:
                                                                        </td>
                                                                        <td>{{ $order->code }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="w-50 strong-600">{{ __('Customer') }}:
                                                                        </td>
                                                                        <td>{{ json_decode($order->shipping_address)->name }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="w-50 strong-600">{{ __('Email') }}:
                                                                        </td>
                                                                        <td>{{ json_decode($order->shipping_address)->email }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="w-50 strong-600">
                                                                            {{ __('Shipping address') }}:</td>
                                                                        <td>{{ json_decode($order->shipping_address)->address }},
                                                                            {{ json_decode($order->shipping_address)->area }},
                                                                            {{ json_decode($order->shipping_address)->city }}-{{ json_decode($order->shipping_address)->post_code }}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <table class="details-table table">
                                                                    <tr>
                                                                        <td class="w-50 strong-600">
                                                                            {{ __('Order date') }}:</td>
                                                                        <td>{{ date('d-m-Y H:m A', $order->date) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="w-50 strong-600">
                                                                            {{ __('Delivery Status') }}:</td>
                                                                        <td>{{ ucfirst(str_replace('_', ' ', \App\Models\Order::where('id', '=', $order->id)->first()->delivery_status)) }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="w-50 strong-600">
                                                                            {{ __('Total amount') }}:</td>
                                                                        <td>{{ single_price($order->grand_total) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="w-50 strong-600">
                                                                            {{ __('Shipping method') }}:</td>
                                                                        <td>{{ __('Flat shipping rate') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="w-50 strong-600">
                                                                            {{ __('Payment method') }}:</td>
                                                                        <td>{{ $order->payment_type }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="w-50 strong-600">
                                                                            {{ __('Order Type') }}:</td>
                                                                        <td>
                                                                            @if ($order->meduserorder == 1)
                                                                                Medication Order
                                                                            @else
                                                                                E-commerce Order
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-9">
                                                        <div class="card mt-4">
                                                            <div class="card-header py-2 px-3 heading-6 strong-600">
                                                                {{ __('Order Details') }}</div>
                                                            <div class="card-body pb-0">
                                                                <table class="details-table table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th width="10%">{{ __('Photo') }}</th>
                                                                            <th width="30%">{{ __('Product') }}</th>
                                                                            <th>{{ __('Variation') }}</th>
                                                                            <th>{{ __('Quantity') }}</th>
                                                                            <th>{{ __('Price') }}</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($order->orderDetails as $key => $orderDetail)
                                                                            <tr>
                                                                                <td>{{ $key + 1 }}</td>
                                                                                <td><a href="{{ route('product', $orderDetail->product->slug) }}"
                                                                                        target="_blank"><img
                                                                                            src="{{ asset($orderDetail->product->thumbnail_img) }}"
                                                                                            width="50px"
                                                                                            alt="{{ asset($orderDetail->product->thumbnail_img) }}"></a>
                                                                                </td>
                                                                                <td><a href="{{ route('product', $orderDetail->product->slug) }}"
                                                                                        target="_blank">{{ $orderDetail->product->name }}</a>
                                                                                </td>
                                                                                <td>
                                                                                    {{ $orderDetail->variation }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $orderDetail->quantity }}
                                                                                </td>
                                                                                <td>{{ single_price($orderDetail->price) }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="card mt-4">
                                                            <div class="card-header py-2 px-3 heading-6 strong-600">
                                                                {{ __('Order Ammount') }}</div>
                                                            <div class="card-body pb-0">
                                                                <table class="table details-table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th>{{ __('Subtotal') }}</th>
                                                                            <td class="text-right">
                                                                                <span
                                                                                    class="strong-600">{{ single_price($order->orderDetails->sum('price')) }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>{{ __('Shipping') }}</th>
                                                                            <td class="text-right">
                                                                                <span
                                                                                    class="text-italic">{{ single_price($order->shipping_cost) }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>{{ __('Tax') }}</th>
                                                                            <td class="text-right">
                                                                                <span
                                                                                    class="text-italic">{{ single_price($order->orderDetails->sum('tax')) }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><span
                                                                                    class="strong-600">{{ __('Total') }}</span>
                                                                            </th>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
