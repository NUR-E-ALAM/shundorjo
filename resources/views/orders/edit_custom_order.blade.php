@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 text-center">📝 Edit Custom Order</h3>

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- Customer Info --}}
            <div class="col-md-8">
                <div class="card p-3 shadow-sm">
                    <h5 class="mb-3">Customer Info</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">User Name</label>
                            <input type="text" class="form-control" name="name" value="{{ json_decode($order->shipping_address)->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone No</label>
                            <input type="text" class="form-control" name="phone" value="{{ json_decode($order->shipping_address)->phone }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" value="{{ json_decode($order->shipping_address)->address }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <input type="text" class="form-control" name="note" value="{{ $order->note }}">
                    </div>
                </div>
            </div>

            {{-- Order Info --}}
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <h5 class="mb-3">Order Info</h5>
                    <div class="mb-3">
                        <label class="form-label">Invoice #</label>
                        <input type="text" name="order_id" class="form-control" value="{{ $order->code }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ \Carbon\Carbon::parse($order->date)->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order Source</label>
                        <select name="order_source" class="form-control">
                            <option value="facebook" {{ $order->order_source=='facebook'?'selected':'' }}>Facebook</option>
                            <option value="whatsapp" {{ $order->order_source=='whatsapp'?'selected':'' }}>WhatsApp</option>
                            <option value="website" {{ $order->order_source=='website'?'selected':'' }}>website</option>
                        </select>
                    </div>
                    <input type="hidden" name="payment_option" value="{{ $order->payment_option }}">
                </div>
            </div>
        </div>

        {{-- Product Table --}}
        <div class="card p-3 mt-4 shadow-sm">
            <h5 class="mb-3">Products</h5>
            <table class="table table-bordered align-middle" id="productTable">
                <thead class="table-light text-center">
                    <tr>
                        <th>Product Name</th>
                        <th width="100">Qty</th>
                        <th width="120">Price</th>
                        <th width="120">Subtotal</th>
                        <th width="70">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td><input name="product_name[]" class="form-control" placeholder="Product name" value="{{ $detail->product_id != 0 ? optional($detail->product)->name : $detail->custom_product_name }}" required></td>
                        <td><input name="quantity[]" type="number" min="1" class="form-control qty text-end" value="{{ $detail->quantity }}" required></td>
                        <td><input name="price[]" type="number" step="0.01" min="0" class="form-control price text-end" value="{{ $detail->price }}" required></td>
                        <td><input name="subtotal[]" type="number" step="0.01" class="form-control subtotal text-end" readonly value="{{ $detail->price }}"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm removeRow">✕</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <button type="button" id="addMore" class="btn btn-secondary btn-sm">
                    ➕ Add More Product
                </button>
            </div>

            {{-- Summary Table --}}
            <div class="d-flex justify-content-end mt-4">
                <table class="table table-bordered table-striped align-middle w-50 shadow-sm">
                    <tbody>
                        <tr>
                            <th class="text-end align-middle bg-light" style="width: 80%; text-align:right;">Subtotal</th>
                            <td class="text-end">
                                <input type="text" id="subtotalAmount" class="form-control text-end bg-white" readonly value="{{ $order->subtotal }}">
                            </td>
                        </tr>
                        <tr>
                            <th class=" bg-light" style="text-align:right;">
                                <label for="deliveryCharge" class="mb-0">Delivery Charge</label>
                            </th>
                            <td>
                                <input type="number" name="delivery_charge" id="deliveryCharge" class="form-control text-end" value="{{ $order->shipping_cost }}" min="0">
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light" style="text-align:right;">
                                <label for="discount" class="mb-0">Discount</label>
                            </th>
                            <td>
                                <input type="number" name="discount" id="discount" class="form-control text-end" value="{{ $order->discount }}" min="0">
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light" style="text-align:right;">
                                <label for="paidAmount" class="mb-0">Paid Amount</label>
                            </th>
                            <td>
                                <input type="number" name="paid" id="paidAmount" class="form-control text-end" value="{{ $order->paid_amount }}" min="0">
                            </td>
                        </tr>
                        <tr>
                            <th class=" bg-light fw-bold" style="text-align:right;">
                                <label for="dueAmount" class="mb-0">Amount Due</label>
                            </th>
                            <td>
                                <input type="text" id="dueAmount" class="form-control text-end bg-light fw-bold" readonly value="{{ $order->grand_total }}">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success px-5 py-2">
                ✅ Update Order
            </button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // === Auto calculate subtotal ===
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('qty') || e.target.classList.contains('price')) {
            let row = e.target.closest('tr');
            let qty = parseFloat(row.querySelector('.qty').value) || 0;
            let price = parseFloat(row.querySelector('.price').value) || 0;
            row.querySelector('.subtotal').value = (qty * price).toFixed(2);
            updateTotals();
        }

        if (['deliveryCharge', 'discount', 'paidAmount'].includes(e.target.id)) {
            updateTotals();
        }
    });

    // === Add more product rows ===
    document.getElementById('addMore').addEventListener('click', function() {
        let table = document.querySelector('#productTable tbody');
        let newRow = table.rows[0].cloneNode(true);
        newRow.querySelectorAll('input').forEach(i => i.value = '');
        table.appendChild(newRow);
    });

    // === Remove product row ===
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            let rows = document.querySelectorAll('#productTable tbody tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                updateTotals();
            } else {
                alert('At least one product is required!');
            }
        }
    });

    // === Update total logic ===
    function updateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.subtotal').forEach(el => {
            subtotal += parseFloat(el.value) || 0;
        });

        document.getElementById('subtotalAmount').value = subtotal.toFixed(2);

        let delivery = parseFloat(document.getElementById('deliveryCharge').value) || 0;
        let discount = parseFloat(document.getElementById('discount').value) || 0;
        let paid = parseFloat(document.getElementById('paidAmount').value) || 0;

        let total = subtotal + delivery - discount;
        let due = total - paid;

        document.getElementById('dueAmount').value = due.toFixed(2);
    }

    // Initial calculation on page load
    updateTotals();
});
</script>
@endsection
