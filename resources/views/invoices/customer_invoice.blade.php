<div style="margin-left:auto;margin-right:auto;">
    <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <style media="all">
   @font-face {
    font-family: 'HindSiliguri';
    font-style: normal;
    font-weight: 400;
    src: url("{{ public_path('fonts/HindSiliguri-Regular.ttf') }}") format('truetype');
  }
  @font-face {
    font-family: 'HindSiliguri';
    font-style: normal;
    font-weight: 700;
    src: url("{{ public_path('fonts/HindSiliguri-Bold.ttf') }}") format('truetype');
  }


  body, * {
    font-family: 'HindSiliguri', sans-serif !important;
    line-height: 1;
    color: #333542;
  }

            div{
                font-size: 1rem;
            }
            .gry-color *,
            .gry-color{
                color:#878f9c;
            }
            table{
                width: 100%;

            }
            table th{
                font-weight: normal;
            }
            .text-center{
                 text-align: center;
            }
            table.padding th{
                padding: .1rem .1rem;
            }
            table.padding td{
                padding: .1rem;
            }
            table.sm-padding td{
                padding: .1rem .1rem;
            }
            .border-bottom td,
            .border-bottom th{
                border-bottom:1px solid #eceff4;
            }
            .text-left{
                text-align:left;
            }
            .text-right{
                text-align:right;
            }
            .small{
                font-size: .85rem;
            }
            .strong{
                font-weight: bold;
            }
        </style>

            @php
                $generalsetting = \App\Models\GeneralSetting::first();
            @endphp

            <div style="background: #eceff4; padding: 1.5rem;">
                <table>
                    <tr>
                        <td>
                            @if($generalsetting->logo !== null)
                                <img src="{{ public_path($generalsetting->admin_logo) }}" height="70" style="display:inline-block;">
                            @else
                                <img src="{{ public_path('frontend/images/logo/logo.png') }}" height="40" style="display:inline-block;">
                            @endif
                        </td>
                        <td style="font-size: 2.5rem;" class="text-right strong">INVOICE</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="font-size: 1.2rem;" class="strong"></td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td class="gry-color small">www.shundorjo.com</td>
                        <td class="text-right"><span class="gry-color small">Order ID:</span> <span class="strong">{{ $order->code }}</span></td>
                    </tr>
                    <tr>
                        <td class="gry-color small">Email: {{ $generalsetting->email }}</td>
                        <td class="text-right small"><span class="gry-color small">Payment Type:</span> <span class="strong">{{ $order->payment_type }}</span></td>
                    </tr>
                    <tr>
                        <td class="gry-color small">Whatsapp: {{ $generalsetting->phone }}</td>
                        <td class="text-right small"><span class="gry-color small">Order Date:</span> <span class=" strong">{{ date('d-m-Y', $order->date) }}</span></td>
                    </tr>
                </table>

            </div>

            <div style="border-bottom:1px solid #eceff4; margin: 0 1.5rem;"></div>

            <div style="padding: 1.5rem;">
                <table>
                    @php
                        $shipping_address = json_decode($order->shipping_address);
                    @endphp
                    <tr><td class="strong small gry-color">Bill to:</td></tr>
                    <tr><td class="strong">{{ $shipping_address->name }}</td></tr>
                    <tr><td class="gry-color small">{{ $shipping_address->address }},
                        @if($shipping_address->area!=null)
                        {{ $shipping_address->area }}, {{ $shipping_address->city }}-{{ $shipping_address->post_code }}
                    @endif
                    </td></tr>
                    @if($shipping_address->email!=null)
  <tr><td class="gry-color small">Email: {{ $shipping_address->email }}</td></tr>
                    @endif
                    <tr><td class="gry-color small">Phone: {{ $shipping_address->phone }}</td></tr>
                </table>
            </div>
            <div style="padding: 1.5rem;">
                <table class="padding text-left small border-bottom">
                    <thead>
                        <tr class="gry-color" style="background: #eceff4;">
                            <th width="50%">Product Name</th>
                            <th width="10%">Qty</th>
                            <th width="15%">Unit Price</th>
                            <th width="15%" class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="strong">
                        @foreach ($order->orderDetails as $key => $orderDetail)
                            <tr class="text-center">
                                <td>@if($orderDetail->product_id!=0)
{{ $orderDetail->product->name }}
                                    @else
                                    {{$orderDetail->custom_product_name}}
                                    @endif
                                    </td>
                                <td class="gry-color">{{ $orderDetail->quantity }}</td>
                                <td class="gry-color">{{ $orderDetail->price/$orderDetail->quantity }}</td>
                                <td class="text-right">{{ $orderDetail->price+$orderDetail->tax }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding:0 1.5rem;">
                <table style="width: 40%;margin-left:auto;" class="text-right sm-padding small strong">
                    <tbody>
                        <tr>
                            <th class="gry-color text-left">Sub Total</td>
                            <td>{{ $order->orderDetails->sum('price') }}</td>
                        </tr>
                        <tr>
                            <th class="gry-color text-left">Shipping Cost</td>
                            <td>{{ $order->shipping_cost }}</td>
                        </tr>
                        <tr>
                            <th class="gry-color text-left">Discount</td>
                            <td>{{ $order->discount }}</td>
                        </tr>
                        <tr>
                            <th class="text-left strong">Grand Total</td>
                            <td>{{ $order->grand_total }}</td>
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
                <br>
                <p><strong>Note : </strong>{{ $order->note }}</p>
                <hr>
                Our Facebook Page : www.facebook.com/shundorjjo & www.facebook.com/shundorjocare
            </div>

        </div>
