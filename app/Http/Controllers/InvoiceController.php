<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function actionAddInvoice(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }

        $invoice_max_number = Invoice::orderByDesc('invoice_number')->take(1)->get();
        $invoice_number = 1;
        if (!empty($invoice_max_number->all())) {
            $invoice_number = $invoice_max_number->invoice_number + 1;
        }

        $now_time = Carbon::now();
        $invoice_date = $now_time->toDateTimeString();
        
        $new_invoice = Invoice::create([
            'invoice_number' => $invoice_number,
            'invoice_date' => $invoice_date,
            'author' => $auth_user->id,
            'vat' => 0,
            'creation_status' => 'draft',
        ]);

        if (empty($new_invoice)) {
            return [
                'status' => 'error',
                'message' => trans('error.notCreate', ['model' => 'Invoice']),
            ];
        }
        return [
            'status' => 'success',
            'message' => trans('success.added', ['model' => 'Invoice']),
            'invoice' => $new_invoice,
        ];
    }
}
