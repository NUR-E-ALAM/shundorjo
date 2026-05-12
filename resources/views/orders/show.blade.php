@extends('layouts.app')

@section('content')

    <div class="panel">
    	<div class="panel-body">
    		<div class="invoice-masthead">
    			<div class="invoice-text">
    				<h3 class="h1 text-thin mar-no text-primary">{{ __('Order Details') }}</h3>
    			</div>
    		</div>
            <div class="row">
                @php
                    $delivery_status = $order->delivery_status;
                    $payment_status = $order->payment_status;

                @endphp
                <div class="col-lg-offset-6 col-lg-3">
                    <label for="update_payment_status">{{__('Payment Status')}}</label>
                    @if ($payment_status == 'paid')
                    <select class="form-control">
                        <option value="Paid">{{__('Paid')}}</option>
                    </select>
                    @else
                    <select class="form-control demo-select2"   data-minimum-results-for-search="Infinity" id="update_payment_status">
                        <option value="paid" @if ($payment_status == 'paid') selected @endif>{{__('Paid')}}</option>
                        <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>{{__('Unpaid')}}</option>
                    </select>
                    @endif


                </div>
               <div class="col-lg-3">
    <label for="update_delivery_status">{{__('Delivery Status')}}</label>

    <select class="form-control demo-select2"
            id="update_delivery_status"
            data-minimum-results-for-search="Infinity"
            {{ in_array($delivery_status, ['delivered','rejected']) ? 'disabled' : '' }}>

        @php
            $statuses = [
                'pending' => ['pending','processing','on_delivery','delivered','rejected'],
                'wpayment' => ['processing','on_delivery','delivered','rejected'],
                'return' => ['return','processing','on_delivery','delivered','rejected'],
                'processing' => ['processing','on_delivery','delivered','rejected'],
                'on_delivery' => ['on_delivery','return','delivered','rejected'],
                'delivered' => ['delivered','rejected'],
                'rejected' => ['rejected']
            ];
        @endphp

        @foreach($statuses[$delivery_status] ?? [] as $status)
            <option value="{{ $status }}" {{ $delivery_status == $status ? 'selected' : '' }}>
                {{ __(ucwords(str_replace('_',' ',$status))) }}
            </option>
        @endforeach

    </select>
    <div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <input type="text" name="reject_reason" class="form-control" placeholder="Enter reject reason">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="saveReject">Save</button>
            </div>
        </div>
    </div>
</div>
</div>
            </div>
            <hr>
    		<div class="invoice-bill row">
    			<div class="col-sm-6 text-xs-center">
    				<address>
        				<strong class="text-main">{{ json_decode($order->shipping_address)->name }}</strong><br>
                         {{ json_decode($order->shipping_address)->email }}<br>
                         {{ json_decode($order->shipping_address)->phone }}<br>
        				 {{ json_decode($order->shipping_address)->address }}
                         @if(json_decode($order->shipping_address)->area!=null)
                         , {{ json_decode($order->shipping_address)->area }}, {{ json_decode($order->shipping_address)->city }}-{{ json_decode($order->shipping_address)->post_code }}
@endif
.
                    </address>

    			</div>
    			<div class="col-sm-6 text-xs-center">
    				<table class="invoice-details">
    				<tbody>
    				<tr>
    					<td class="text-main">
    						{{__('Order #')}}
    					</td>
    					<td class="text-right text-info">
    						{{ $order->code }}
    					</td>
    				</tr>
                    <tr>
    					<td class="text-main">
    						Order Type
    					</td>
    					<td class="text-right">
    						{{ json_decode($order->shipping_address)->checkout_type }}
    					</td>
    				</tr>
                     <tr>
    					<td class="text-main">
    						Order Source
    					</td>
    					<td class="text-right">
    						{{ @$order->order_source }}
    					</td>
    				</tr>
                    <tr>
    					<td class="text-main">
    						Payment Type
    					</td>
    					<td class="text-right">
    						{{ $order->payment_type }}
    					</td>
    				</tr>
    				<tr>
    					<td class="text-main">
    						{{__('Delivery Status')}}
    					</td>
                        @php
                            $status = $order->first()->delivery_status;
                        @endphp
    					<td class="text-right">
                            @if($status == 'delivered')
                                <span class="badge badge-success">{{ $order->delivery_status }}</span>
                            @else
                                <span class="badge badge-info">{{ $order->delivery_status }}</span>
                            @endif
    					</td>
    				</tr>
    				<tr>
    					<td class="text-main">
    						{{__('Order Date')}}
    					</td>
    					<td class="text-right">
    						{{ date('d-m-Y H:m A', $order->date) }}
    					</td>
    				</tr>
                    <tr>
    					<td class="text-main">
    						{{__('Total amount')}}
    					</td>
    					<td class="text-right">
    						<!--{{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')) }}-->
    						{{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax') + $order->shipping_cost-$order->discount-$order->paid_amount) }}
    					</td>
    				</tr>

    				</tbody>
    				</table>
    			</div>
    		</div>
    		<hr class="new-section-sm bord-no">
    		<div class="row">
    			<div class="col-lg-12 table-responsive">
    				<table class="table table-bordered invoice-summary">
        				<thead>
            				<tr class="bg-trans-dark">
                                <th class="min-col">#</th>
            					<th class="text-uppercase">
            						{{__('Description')}}
            					</th>
            					<th class="min-col text-center text-uppercase">
            						{{__('Qty')}}
            					</th>
            					<th class="min-col text-center text-uppercase">
            						{{__('Price')}}
            					</th>
            					<th class="min-col text-right text-uppercase">
            						{{__('Total')}}
            					</th>
            				</tr>
        				</thead>
        				<tbody>
                            @foreach ($order->orderDetails as $key => $orderDetail)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                					<td>
                						<strong>
                                            @if($orderDetail->product_id!=0)
                                            <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank">{{ $orderDetail->product->name }}</a>
                                            @else
{{ $orderDetail->custom_product_name }}
                                            @endif

                                        </strong>
                						<small>{{ $orderDetail->variation }}</small>
                					</td>
                					<td class="text-center">
                						{{ $orderDetail->quantity }}
                					</td>
                					<td class="text-center">
                						{{ single_price($orderDetail->price/$orderDetail->quantity) }}
                					</td>
                                    <td class="text-center">
                						{{ single_price($orderDetail->price) }}
                					</td>
                				</tr>
                            @endforeach
        				</tbody>
    				</table>
    			</div>
    		</div>
    		<div class="clearfix">
    			<table class="table invoice-total">
    			<tbody>
    			<tr>
    				<td>
    					<strong>{{__('Sub Total')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($order->orderDetails->sum('price')) }}
    				</td>
    			</tr>
				@if($order->orderDetails->sum('tax')!=0)
    			<tr>
    				<td>
    					<strong>{{__('Tax')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($order->orderDetails->sum('tax')) }}
    				</td>
    			</tr>
				@endif
                <tr>
    				<td>
    					<strong>{{__('Shipping')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($order->shipping_cost) }}
    				</td>
    			</tr>
				<tr>
    				<td>
    					<strong>{{__('Discount')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($order->discount) }}
    				</td>
    			</tr>


    			<tr>
    				<td>
    					<strong>{{__('Total')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax') + $order->shipping_cost - $order->discount) }}
    				</td>
    			</tr>
                  @if($order->paid_amount!=0)
                <tr>
    				<td>
    					<strong>{{__('Paid')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($order->paid_amount) }}
    				</td>
    			</tr>
                	<tr>
    				<td>
    					<strong>{{__(' Due')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax') + $order->shipping_cost - $order->discount-$order->paid_amount) }}
    				</td>
    			</tr>
                @endif
    			</tbody>
    			</table>
                <hr>
                <p><strong>Note : </strong>{{ $order->note }} </p>
    		</div>
    		<div class="text-right no-print">
                @if($delivery_status!='delivered')
                <a href="{{ route('orders.edit', encrypt($order->id)) }}"><i class="fa fa-edit"></i></a>
                @endif
    			<a href="{{ route('customer.invoice.download', $order->id) }}" class="btn btn-default"><i class="demo-pli-printer icon-lg"></i></a>
    		</div>
    	</div>
    </div>

	{{-- new  --}}

	@if ($order->delivery_status == "complain")
	<div class="panel">
    	<div class="panel-body">
    		<div class="invoice-masthead">
    			<div>
    				<h3 class="h1 text-primary">{{ __('Order Complain') }}</h3>
    			</div>
    		</div>

			<div class="row">

				<p>{{ $order->complain }}</p>

			</div>

    	</div>
    </div>
	@endif


@endsection

@section('script')
    <script type="text/javascript">
       $('#update_delivery_status').on('change', function () {
    var status = $(this).val();

    if (status === 'rejected') {
        $('#rejectModal').modal('show');
        return; // 🚨 AJAX stop here
    }

    updateDeliveryStatus(status);
});
function updateDeliveryStatus(status, reason = '') {
    var order_id = {{ $order->id }};
    var price = {{ $orderDetail->price }};

    $.post('{{ route('orders.update_delivery_status') }}', {
        _token: '{{ csrf_token() }}',
        order_id: order_id,
        price: price,
        status: status,
        reject_reason: reason
    }, function (data) {
        showAlert('success', 'Delivery status has been updated');
        location.reload();
    });
}
$('#saveReject').on('click', function () {
    let reason = $('input[name="reject_reason"]').val();

    if (reason === '') {
        alert('Please enter reject reason');
        return;
    }

    $('#rejectModal').modal('hide');

    // এখন API call
    updateDeliveryStatus('rejected', reason);
});

         $('#update_payment_status').on('change', function(){
            var order_id = {{ $order->id }};
            // var user_id = {{ $order->user_id }};
            var status = $('#update_payment_status').val();
			// console.log(status);
            $.post('{{ route('orders.update_payment_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
                showAlert('success', 'Payment status has been updated');
                //console.log(data);
				 location.reload();
            });
        });
    </script>
    <script>
    $('#update_delivery_status').on('change', function () {
        let value = $(this).val();

        if (value === 'rejected') {
            $('#rejectModal').modal('show');
        }
    });
</script>
@endsection
