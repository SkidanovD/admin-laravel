<?php

namespace App\Http\Controllers;


use App\Http\Controllers\InvoiceController;
use PDF;

class PDFController extends Controller
{
    public function preview($id)
    {
        $result = InvoiceController::getInvoice($id);
        if ($result['status'] = 'success') {
            $invoice = $result['invoice'];
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
        } else {
            $invoice = false;
        }

        $pdf = PDF::loadView('pdf/preview', ['invoice' => $invoice]);    
        return $pdf->download('demo.pdf');
    }
}
