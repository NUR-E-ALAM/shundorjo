@extends('layouts.app')

@section('content')
{{-- <div class="row">
    <div class="col-sm-12">
        <a href="{{ route('custom-orders.index.admin')}}" class="btn btn-rounded btn-info pull-right">{{__('Add Custom Order')}}</a>
    </div>
</div> --}}

<br>
<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Orders')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Date')}}</th>
                    <th>{{__('Order Code')}}</th>
                    <th>{{__('Num. of Products')}}</th>
                    <th>{{__('Customer')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{__('Delivery Status')}}</th>
                    <th>{{__('Order Type(Source)')}}</th>
                    <th>{{__('Payment Status')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $order_id)
                    @php
                        $order = \App\Models\Order::find($order_id->id);
                    @endphp
                    @if($order != null)
                        <tr>
                            <td>
                                {{ $key+1 }}
                            </td>
                            <td>

                                    {{ $order->created_at }}

                            </td>
                            <td>
                                {{ $order->code }} @if($order->viewed == 0) <span class="pull-right badge badge-info">{{ __('New') }}</span> @endif
                            </td>
                            <td>
                                {{ count($order->orderDetails) }}
                            </td>
                            <td>
                                @if ($order->user_id != null)
                                    {{ @$order->user->name }} <br> {{ json_decode($order->shipping_address)->phone }}
                                @else
                                {{ json_decode($order->shipping_address)->name }} </br>   {{ json_decode($order->shipping_address)->phone }}
                                @endif
                            </td>
                            <td>

                                {{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax') + $order->shipping_cost-$order->discount) }}

                            </td>
                            <td>
                                @php
                                    $status = $order->delivery_status;
                                @endphp
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </td>
                            <td>
                            {{ ucfirst(str_replace('_', ' ',json_decode($order->shipping_address)->checkout_type)) }} - {{ ucfirst(str_replace('_', ' ', $order->order_source)) }}
                            </td>

                            <td>
                                <span class="badge badge--2 mr-4">

                                    {{ $order->payment_status }}

                                </span>
                            </td>

                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ route('orders.show', encrypt($order->id)) }}">{{__('View')}}</a></li>
                                        {{-- <li><a href="{{ route('orders.prescription.show', encrypt($order->id)) }}">{{__('Prescription View')}}</a></li> --}}
                                        <li><a href="{{ route('seller.invoice.download', $order->id) }}">{{__('Download Invoice')}}</a></li>
                                        @if($order->delivery_status=='pending' ||$order->delivery_status=='processing')
                                        <li><a href="{{ route('orders.edit', encrypt($order->id)) }}">{{__('Edit')}}</a></li>
                                        @endif
                                        {{-- <li><a onclick="confirm_modal('{{route('orders.destroy', $order->id)}}');">{{__('Delete')}}</a></li> --}}
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection


@section('script')
    <script type="text/javascript">

    </script>
@endsection
