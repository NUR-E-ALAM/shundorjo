@extends('layouts.app')

@section('content')

    <div class="panel">
    	<div class="panel-body">

            <form action="{{route('medication.user.order')}}" method="post">
                @csrf
                <input type="text" name="medication_id" id="" value="{{$medication->id}}" readonly hidden>
                <input type="text" name="city" id="" value="{{ json_decode($medication->shipping_address)->city }}" readonly hidden>
                <input type="text" name="email" id="" value="{{ json_decode($medication->shipping_address)->email }}" readonly hidden>
                <input type="text" name="name" id="" value="{{ json_decode($medication->shipping_address)->name }}" readonly hidden>
                <input type="text" name="phone" id="" value="{{ json_decode($medication->shipping_address)->phone }}" readonly hidden>
                <input type="text" name="address" id="" value="{{ json_decode($medication->shipping_address)->address }}" readonly hidden>
                <input type="text" name="postal_code" id="" value="{{ json_decode($medication->shipping_address)->city }}" readonly hidden>
                <input type="text" name="postal_code" id="" value="{{ json_decode($medication->shipping_address)->region }}" readonly hidden>
                <input type="text" name="postal_code" id="" value="{{ json_decode($medication->shipping_address)->area }}" readonly hidden>
                <input type="text" name="country" id="" value="{{ json_decode($medication->shipping_address)->post_code }}" readonly hidden>
                <input type="text" name="user_id" id="" value="{{$medication->user_id}}" readonly hidden>
                <input type="text" name="code" value="{{ $medication->code }}" id="" readonly hidden>
                <input type="text" name="total_price" value="{{$medication->medicationDetails->sum('price') + $medication->medicationDetails->sum('tax')+$medication->shipping_cost}}" id="" readonly hidden>
                <input type="text" name="date" value="{{$medication->upcoming_date}}" id="" readonly hidden>
                <input type="text" name="payment_option" id="" value="{{$medication->payment_type}}" readonly hidden>

    		<div class="invoice-masthead">
    			<div class="invoice-text">
    				<h3 class="h1 text-thin mar-no text-primary">{{ __('medication Details') }}</h3>
    			</div>
    		</div>

    		<div class="invoice-bill row">
    			<div class="col-sm-6 text-xs-center">
    				<address>
        				<strong class="text-main">{{ json_decode($medication->shipping_address)->name }}</strong><br>
                         {{ json_decode($medication->shipping_address)->email }}<br>
                         {{ json_decode($medication->shipping_address)->phone }}<br>
        				 {{ json_decode($medication->shipping_address)->address }}, {{ json_decode($medication->shipping_address)->area }},{{ json_decode($medication->shipping_address)->city }}-{{ json_decode($medication->shipping_address)->post_code }}, {{ json_decode($medication->shipping_address)->region }}
                    </address>
    			</div>
    			<div class="col-sm-6 text-xs-center">
    				<table class="invoice-details">
    				<tbody>
    				<tr>
    					<td class="text-main">
    						{{__('Medication #')}}
    					</td>
    					<td class="text-right text-info">
    						{{ $medication->code }}
    					</td>
    				</tr>
    				<tr>
    					<td class="text-main">
    						{{__('Medication Preiod')}}
    					</td>
                        @php
                            $preiod = App\Models\User::find($medication->user_id)->preiod;
                        @endphp
    					<td class="text-right">
                            {{$preiod}} Days
    					</td>
    				</tr>
    				<tr>
    					<td class="text-main">
    						{{__('Medication Date')}}
    					</td>
    					<td class="text-right">
    						{{ $medication->upcoming_date }}
    					</td>
    				</tr>
                    <tr>
    					<td class="text-main">
    						{{__('Total amount')}}
    					</td>
    					<td class="text-right">
    						<!--{{ single_price($medication->medicationDetails->sum('price') + $medication->medicationDetails->sum('tax')) }}-->
    							{{ single_price($medication->medicationDetails->sum('price') + $medication->medicationDetails->sum('tax') + $medication->shipping_cost) }}
    					</td>
    				</tr>
    				<tr>
    					<td class="text-main">
    						{{__('Delivery Status')}}
    					</td>
    					<td class="text-right">
    						<select class="form-control" data-placeholder="Select delivery status" id="delivery_status" name="delivery_status" required>
    						    <option value="">---Select status---</option>
    						    <option value="wpayment">Waiting for payment</option>
                              <option value="processing">Processing</option>
                              <option value="rejected">Rejected</option>
                              
                          </select>
    					</td>
    				</tr>
                    {{-- <tr>
    					<td class="text-main">
    						{{__('Payment method')}}
    					</td>
    					<td class="text-right">
    						{{ ucfirst(str_replace('_', ' ', $medication->payment_type)) }}
    					</td>
    				</tr> --}}
    				</tbody>
    				</table>
    			</div>
    		</div>
    		<hr class="new-section-sm bord-no">
    		<div class="row">
    			<div class="col-lg-12 table-responsive">
    				<table class="table table-bmedicationed invoice-summary">
        				<thead>
            				<tr class="bg-trans-dark"  style="border-top: 1px solid black !important;">
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
                            @foreach ($medication->medicationDetails as $key => $medicationDetail)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                					<td>
                						<strong><a href="{{ route('product', $medicationDetail->product->slug) }}" target="_blank">{{ $medicationDetail->product->name }}</a></strong>
                						<small>{{ $medicationDetail->variation }}</small>
                                        <input type="text" name="product_id[]" value="{{$medicationDetail->product->id}}" id="" readonly hidden>
                					</td>
                					<td class="text-center">
                						{{ $medicationDetail->quantity }}
                                        <input type="text" name="qty[]" value="{{$medicationDetail->quantity }}" id="" readonly hidden>
                					</td>
                					<td class="text-center">
                						{{ single_price($medicationDetail->price/$medicationDetail->quantity) }}

                					</td>
                                    <td class="text-center">
                						{{ single_price($medicationDetail->price) }}
                                        <input type="text" name="price[]" value="{{ $medicationDetail->price/$medicationDetail->quantity }}" id="" readonly hidden>
                                        <input type="text" name="shipping_cost" value="{{ $medication->shipping_cost }}" id="" readonly hidden>
                					</td>

                				</tr>
                            @endforeach
        				</tbody>
    				</table>
    			</div>
    		</div>
    		<div class="clearfix">
    			<table class="table borless invoice-total">
    			<tbody>
    			<tr>
    				<td>
    					<strong>{{__('Sub Total')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($medication->medicationDetails->sum('price')) }}
    				</td>
    			</tr>
    			<!--<tr>-->
    			<!--	<td>-->
    			<!--		<strong>{{__('Tax')}} :</strong>-->
    			<!--	</td>-->
    			<!--	<td>-->
    			<!--		{{ single_price($medication->medicationDetails->sum('tax')) }}-->
    			<!--	</td>-->
    			<!--</tr>-->
                <tr>
    				<td>
    					<strong>{{__('Shipping')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($medication->shipping_cost) }}

    				</td>
    			</tr>
    			<tr>
    				<td>
    					<strong>{{__('Total')}} :</strong>
    				</td>
    				<td>
    					{{ single_price($medication->medicationDetails->sum('price') + $medication->medicationDetails->sum('tax') + $medication->shipping_cost) }}
    				</td>
    			</tr>
    			</tbody>
    			</table>
    		</div>
    		<div class="text-right no-print">
    			{{-- <a href="{{ route('medication.invoice.download', $medication->id) }}" class="btn btn-default"><i class="demo-pli-printer icon-lg"></i></a> --}}
                <input type="submit" value="Confirm Order" class="btn btn-success">
    		</div>
           </form>
    	</div>
    </div>
@endsection


