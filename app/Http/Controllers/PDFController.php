<?php

namespace App\Http\Controllers;


use App\Http\Controllers\InvoiceController;
use Carbon\Carbon;
use PDF;

class PDFController extends Controller
{
    public function preview($id)
    {
        $result = InvoiceController::getInvoice($id);
        if ($result['status'] = 'success') {
            $invoice = $result['invoice'];
            $invoice['invoice_date'] = Carbon::parse($invoice['invoice_date'])->format('d.m.Y');
            $total = 0;
            foreach ($invoice['details'] as $detail) {
                $total += $detail['price'];
            }
            $invoice['total'] = $total;
            $invoice['vat_qty'] = $invoice['total_tax'] - $total;
        } else {
            $invoice = false;
        }

        return view('pdf/preview', ['invoice' => $invoice]);
    }

    public function generatePDF($id)
    {
        $result = InvoiceController::getInvoice($id);
        if ($result['status'] = 'success') {
            $invoice = $result['invoice'];
            $invoice['invoice_date'] = Carbon::parse($invoice['invoice_date'])->format('d.m.Y');
            $total = 0;
            foreach ($invoice['details'] as $detail) {
                $total += $detail['price'];
            }
            $invoice['total'] = $total;
            $invoice['vat_qty'] = $invoice['total_tax'] - $total;
        } else {
            $invoice = false;
        }

        $pdf = PDF::loadView('pdf/generate', ['invoice' => $invoice]);    
        return $pdf->download('invoice_' . $invoice['invoice_number'] . '.pdf');
    }
}
