@extends('layouts.app')

@section('content')

    <div class="panel">
    	<div class="panel-body">
    		<div class="invoice-masthead">
    			<div class="invoice-text">
    				<h3 class="h1 text-thin mar-no text-primary">{{ __('Withdraw Details') }}</h3>
    			</div>
    		</div>
            <div class="row">
                @php
                    $delivery_status = $withdraws->first()->delivery_status;
                    $payment_status = $withdraws->first()->payment_status;

                @endphp
                <div class="col-lg-offset-6 col-lg-3">
                    <label for=update_payment_status"">{{__('Payment Status')}}</label>
                    <select class="form-control demo-select2"  data-minimum-results-for-search="Infinity" id="update_payment_status">
                        <option value="paid" @if ($payment_status == 'paid') selected @endif>{{__('Paid')}}</option>
                        <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>{{__('Unpaid')}}</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for=update_delivery_status"">{{__('Delivery Status')}}</label>
						<select class="form-control demo-select2"  data-minimum-results-for-search="Infinity" id="update_delivery_status">
							<option value="on_processing" @if ($delivery_status == 'on_processing') selected @endif>{{__('On processing')}}</option>
							<option value="Payment" @if ($delivery_status == 'Payment') selected @endif>{{__('Payment')}}</option>
                                <option value="rejected" @if ($delivery_status == 'rejected') selected @endif>{{__('Rejected')}}</option>
						</select>

                </div>
            </div>
            <hr>
    		<div class="invoice-bill row">
    			
    		</div>
    		<hr class="new-section-sm bord-no">
    		<div class="row">
    			<div class="col-lg-12 table-responsive">
    				<table class="table table-bordered invoice-summary">
        				<thead>
            				<tr class="bg-trans-dark">
                                <th class="min-col">#</th>
            					<th class="min-col text-center text-uppercase">
            						{{__('Name')}}
            					</th>
            					<th class="min-col text-center text-uppercase">
            						{{__('Withdraw Type')}}
            					</th>
            					<th class="min-col text-center text-uppercase">
            						{{__('Amount')}}
            					</th>
            				</tr>
        				</thead>
        				<tbody>
                            @foreach ($data as $withdraw)
                                <tr>
                                    <td>{{ $withdraw->id }}</td>
                					<td class="text-center">
                						{{ $withdraw->user->name }}
                					</td>
                					<td class="text-center">
                						{{ $withdraw->withdraw_type }}
                					</td>
                                    <td class="text-center">
                						{{ $withdraw->amount }}
                					</td>
                				</tr>
                            @endforeach
        				</tbody>
    				</table>
    			</div>
    		</div>
    		
    		
    	</div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#update_delivery_status').on('change', function(){
            var withdraw_id = {{ $withdraws->id }};
			//alert(order_id);
            var status = $('#update_delivery_status').val();
			//alert(status);
            $.post('{{ route('withdraw.update_delivery_status') }}', {_token:'{{ @csrf_token() }}',withdraw_id:withdraw_id,status:status}, function(data){
                showAlert('success', 'Delivery status has been updated');
				location.reload();
            });
        });

        $('#update_payment_status').on('change', function(){
            var withdraw_id = {{ $withdraws->id }};
            var status = $('#update_payment_status').val();

            $.post('{{ route('withdraw.update_payment_status') }}', {_token:'{{ @csrf_token() }}',withdraw_id:withdraw_id,status:status}, function(data){
                showAlert('success', 'Payment status has been updated');
                //console.log(data);
				 location.reload();
            });
        });
    </script>
@endsection
