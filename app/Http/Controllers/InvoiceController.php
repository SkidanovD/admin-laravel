<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceCompany;
use App\Models\InvoiceDetail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            $invoice_number = $invoice_max_number[0]->invoice_number + 1;
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
        $new_invoice->invoice_number =sprintf('%03d', $new_invoice->invoice_number);
        $new_invoice->invoice_date = Carbon::parse($new_invoice->invoice_date)->format('Y-m-d');
        return [
            'status' => 'success',
            'message' => trans('success.added', ['model' => 'Invoice']),
            'invoice' => $new_invoice,
        ];
    }

    public function actionEditInvoice(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }

        $validator = Validator::make($request->all(), [
            'invoice_number' => 'numeric|required',
            'invoice_date' => 'date|required',
            'name' => 'string|nullable',
            'company_name' => 'string|required',
            'address' => 'string|nullable',
            'post_code' => 'numeric|nullable',
            'city' => 'string|nullable',
            'phone' => 'string|nullable',
            'siret' => 'numeric|nullable',
            'rcs' => 'numeric|nullable',
            'tva' => 'string|nullable',
            'note' => 'string|nullable',
            'details' => 'array|required',
            'details.*.order' => 'numeric|nullable',
            'details.*.description' => 'string|required',
            'details.*.quantity' => 'string|nullable',
            'details.*.price' => 'string|required',
            'vat' => 'numeric|required',
            'total_tax' => 'numeric|required',
        ]);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'messages' => $validator->messages(),
                'form_field' => $request->all()
            ];
        }

        $invoice = Invoice::find($request->id);
        $invoice_company = Invoice::find($request->id)->invoiceCompany;

        if (empty($invoice_company)) {
            $new_invoice_company = new InvoiceCompany([
                'name' => $request->name,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'post_code' => $request->post_code,
                'city' => $request->city,
                'phone' => $request->phone,
                'siret' => $request->siret,
                'rcs' => $request->rcs,
                'tva' => $request->tva,
                'note' => $request->note,
            ]);
            $invoice->invoiceCompany()->save($new_invoice_company);
        } else {
            $invoice->invoiceCompany()->update([
                'name' => $request->name,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'post_code' => $request->post_code,
                'city' => $request->city,
                'phone' => $request->phone,
                'siret' => $request->siret,
                'rcs' => $request->rcs,
                'tva' => $request->tva,
                'note' => $request->note,
            ]);
        }

        $old_invoice_details = Invoice::find($request->id)->invoiceDetails;
        
        if (empty($old_invoice_details->all())) {
            $query_invoice_details = [];
            foreach ($request->details as $detail) {
                $query_invoice_details[] = new InvoiceDetail([
                    'order' => $detail['order'],
                    'description' => $detail['description'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price'],
                ]);
            }
            $invoice->invoiceDetails()->saveMany($query_invoice_details);
        } else {
            if (count($request->details) === count($old_invoice_details->all())) {
                foreach ($old_invoice_details->all() as $key => $old_invoice_detail) {
                    InvoiceDetail::where('id', $old_invoice_detail->id)->update([
                        'order' => (int) $request->details[$key]['order'],
                        'description' => $request->details[$key]['description'],
                        'quantity' => (int) $request->details[$key]['quantity'],
                        'price' => (int) $request->details[$key]['price'],
                    ]);
                }
            } elseif (count($request->details) > count($old_invoice_details->all())) {
                $query_invoice_details = [];
                foreach ($request->details as $key => $detail) {
                    if (!empty($old_invoice_details->all()[$key])) {
                        InvoiceDetail::where('id', $old_invoice_details->all()[$key]->id)->update([
                            'order' => (int) $detail['order'],
                            'description' => $detail['description'],
                            'quantity' => (int) $detail['quantity'],
                            'price' => (int) $detail['price'],
                        ]);
                    } else {
                        $query_invoice_details[] = new InvoiceDetail([
                            'order' => $detail['order'],
                            'description' => $detail['description'],
                            'quantity' => $detail['quantity'],
                            'price' => $detail['price'],
                        ]);
                    }
                }
                $invoice->invoiceDetails()->saveMany($query_invoice_details);
            } elseif (count($request->details) < count($old_invoice_details->all())) {
                foreach ($old_invoice_details->all() as $key => $old_invoice_detail) {
                    if (!empty($request->details[$key])) {
                        InvoiceDetail::where('id', $old_invoice_detail->id)->update([
                            'order' => (int) $request->details[$key]['order'],
                            'description' => $request->details[$key]['description'],
                            'quantity' => (int) $request->details[$key]['quantity'],
                            'price' => (int) $request->details[$key]['price'],
                        ]);
                    } else {
                        $old_invoice_detail->delete();
                    }
                }
            }
        }

        Invoice::where('id', $request->id)->update([
            'invoice_number' => (int) $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'vat' => (int) $request->vat,
            'total_tax' => (int) $request->total_tax,
        ]);

        return $this->getInvoice($request->id);

    }

    public function getInvoice($id)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication')
            ];
        }
        $delete_attrs = [
            'id',
            'invoice_id',
            'created_at',
            'updated_at',
        ];
        $invoice_obj = Invoice::find((int)$id);
        if (empty($invoice_obj)) {
            return [
                'status' => 'error',
                'message' => trans('error.notFound', ['model' => 'Invoice']),
            ];
        }

        $invoice = $invoice_obj->attributesToArray();

        $invoice_company = $invoice_obj->invoiceCompany->attributesToArray();
        if (!empty($invoice_company)) {
            foreach ($delete_attrs as $delete_attr) {
                unset($invoice_company[$delete_attr]);
            }
            $invoice = array_merge($invoice, $invoice_company);
        }

        $invoice_details = $invoice_obj->invoiceDetails->toArray();
        if (!empty($invoice_details)) {
            foreach ($invoice_details as $invoice_detail) {
                foreach ($delete_attrs as $delete_attr) {
                    unset($invoice_detail[$delete_attr]);
                }
                $invoice['details'][] = $invoice_detail;
            }
        }
        return [
            'status' => 'success',
            'invoice' => $invoice,
        ];
    }
}
