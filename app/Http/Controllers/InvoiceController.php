<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function generatePDF(Order $order)
    {
        $order->load('orderDetails.variant.product', 'orderDetails.variant.color', 'orderDetails.variant.size', 'voucher');

        $pdf = PDF::loadView('pdf.invoice', compact('order'))->setOptions([
            'defaultFont' => 'DejaVu Sans'
        ]);
        return $pdf->download('hoadonthanhtoan' . $order->code . '.pdf');
    }
}
