<div>
    @php
    $email =\App\Models\EmailTemplete::where('templete','=', 'medication_order')->first();
    echo $email->description;
    echo $email->footer;
    @endphp
    <table> Your product list: <br>
        @foreach ($order->medicationDetails as $key => $orderDetail)
        {{ $orderDetail->product->name }} ({{ $orderDetail->variation }}) = {{ single_price($orderDetail->price+$orderDetail->tax) }} <br>
        @endforeach
    </table>
    <br> we will delivered your invoice soon.
    @php
    echo $email->footer;
    @endphp
</div>
