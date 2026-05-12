<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
// use PDF; // niklasravnsborg/laravel-pdf
use Barryvdh\DomPDF\Facade\Pdf;
use Mpdf\Mpdf;


class InvoiceController extends Controller
{
    //downloads customer invoice
   public function customer_invoice_download($id)
{
    $order = Order::findOrFail($id);


$pdf = Pdf::loadView('invoices.customer_invoice', compact('order'));
           return $pdf->download('order-' . $order->code . '.pdf');


}

    //downloads seller invoice
    public function seller_invoice_download($id)
    {
        $order = Order::findOrFail($id);
        $pdf = PDF::loadView('invoices.seller_invoice', compact('order'))->setPaper('A4', 'portrait');
        return $pdf->download('order-'.$order->code.'.pdf');
    }

    // custom order
    public function customer_invoice($id)
    {
        // dd($id);
        $order = Medication::findOrFail($id);
        $pdf = PDF::loadView('invoices.customer_invoice', compact('order'));
        return $pdf->download('order-'.$order->code.'.pdf');
    }
}
