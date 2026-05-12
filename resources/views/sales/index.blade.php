@extends('layouts.app')

@section('content')

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading" style="height: auto">
        <h3 class="panel-title">{{__('Orders')}}</h3>
         {{-- search strt  --}}
         <form  action="{{route('sales_search.index')}}" method ="POST">
            @csrf
            <br>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5">
                        <label for="fromDate" style="margin-top: 9px;" class="col-form-label col-md-3">From Date</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="fromDate" name="fromDate" required/>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="toDate" style="margin-top: 9px;" class="col-form-label col-md-2">To Date</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="toDate" name="toDate" required/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn" name="search" title="Search"><img src="https://img.icons8.com/android/24/000000/search.png"/>Search</button>
                    </div>
                </div>
            </div>
            <br>
        </form>
        {{-- search end  --}}
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic mt-2" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Order Code</th>
                    <th>Num. of Products</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Delivery Status</th>
                    <th>Payment Status</th>
                    <th width="10%">{{__('options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $order)
                    <tr>
                        <td>
                            {{ $key+1 }}
                        </td>
                        <td>
                            {{ $order->created_at }}
                        </td>
                        <td>
                            {{ $order->code }}
                        </td>
                        <td>
                            {{ count($order->orderDetails) }}
                        </td>
                        <td>
                            @if ($order->user_id != null)
                                {{ isset($order->user->name)?$order->user->name:'' }}
                            @else
                                Guest ({{ $order->guest_id }})
                            @endif
                        </td>
                        <td>
                            {{ single_price($order->grand_total) }}
                        </td>
                        <td>
                            {{ $order->delivery_status }}
                        </td>
                        <td>
                            <span class="badge badge--2 mr-4">
                                @if ($order->payment_status == 'paid')
                                    <i class="bg-green"></i> Paid
                                @else
                                    <i class="bg-red"></i> Unpaid
                                @endif
                            </span>
                        </td>

                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('sales.show', encrypt($order->id))}}">{{__('View')}}</a></li>
                                    <li><a href="{{ route('customer.invoice.download', $order->id) }}">{{__('Download Invoice')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('orders.destroy', $order->id)}}');">{{__('Delete')}}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection


@section('script')
    <script type="text/javascript">

    </script>
    <script>
        jQuery('#toDate').datetimepicker({
            format:'Y-m-d H:i:s',
            inline:false,
            lang:'ru'
        });

    </script>
    <script>
        jQuery('#fromDate').datetimepicker({
            format:'Y-m-d H:i:s',
            inline:false,
            lang:'ru'
        });

    </script>
@endsection
