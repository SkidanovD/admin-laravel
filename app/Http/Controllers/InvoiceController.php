<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceCompany;
use App\Models\InvoiceDetail;
use App\Models\User;
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

        $now_time = Carbon::now();
        $invoice_date = $now_time->toDateTimeString();
        
        $new_invoice = Invoice::create([
            'invoice_number' => 0,
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

        $all_fields = $request->all();
        $all_fields['vat'] = str_replace(',', '.', $all_fields['vat']);
        $all_fields['total_tax'] = str_replace(',', '.', $all_fields['total_tax']);
        foreach ($all_fields['details'] as $key => $detail) {
            $all_fields['details'][$key]['quantity'] = str_replace(',', '.', $detail['quantity']);
            $all_fields['details'][$key]['price'] = str_replace(',', '.', $detail['price']);
        }

        $validator = Validator::make($all_fields, [
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
            'details.*.quantity' => 'numeric|nullable',
            'details.*.price' => 'numeric|required',
            'vat' => 'numeric|required',
            'total_tax' => 'numeric|required',
        ]);
        if ($validator->fails()) {
            return [
                'status' => 'not validated',
                'messages' => $validator->messages(),
                'form_field' => $all_fields
            ];
        }

        $invoice = Invoice::find($all_fields['id']);
        if ($invoice->creation_status === 'public' && $auth_user->role !== 'admin') {
            return [
                'status' => 'error',
                'message' => trans('error.authorization'),
            ];
        }
        $invoice_company = Invoice::find($all_fields['id'])->invoiceCompany;

        if (empty($invoice_company)) {
            $new_invoice_company = new InvoiceCompany([
                'name' => !empty($all_fields['name']) ? $all_fields['name'] : '',
                'company_name' => $all_fields['company_name'],
                'address' => !empty($all_fields['address']) ? $all_fields['address'] : '',
                'post_code' => !empty($all_fields['post_code']) ? $all_fields['post_code'] : '',
                'city' => !empty($all_fields['city']) ? $all_fields['city'] : '',
                'phone' => !empty($all_fields['phone']) ? $all_fields['phone'] : '',
                'siret' => !empty($all_fields['siret']) ? $all_fields['siret'] : '',
                'rcs' => !empty($all_fields['rcs']) ? $all_fields['rcs'] : '',
                'tva' => !empty($all_fields['tva']) ? $all_fields['tva'] : '',
                'note' => !empty($all_fields['note']) ? $all_fields['note'] : '',
            ]);
            $invoice->invoiceCompany()->save($new_invoice_company);
        } else {
            $invoice->invoiceCompany()->update([
                'name' => !empty($all_fields['name']) ? $all_fields['name'] : '',
                'company_name' => $all_fields['company_name'],
                'address' => !empty($all_fields['address']) ? $all_fields['address'] : '',
                'post_code' => !empty($all_fields['post_code']) ? $all_fields['post_code'] : '',
                'city' => !empty($all_fields['city']) ? $all_fields['city'] : '',
                'phone' => !empty($all_fields['phone']) ? $all_fields['phone'] : '',
                'siret' => !empty($all_fields['siret']) ? $all_fields['siret'] : '',
                'rcs' => !empty($all_fields['rcs']) ? $all_fields['rcs'] : '',
                'tva' => !empty($all_fields['tva']) ? $all_fields['tva'] : '',
                'note' => !empty($all_fields['note']) ? $all_fields['note'] : '',
            ]);
        }

        $old_invoice_details = Invoice::find($all_fields['id'])->invoiceDetails;
        
        if (empty($old_invoice_details->all())) {
            $query_invoice_details = [];
            foreach ($all_fields['details'] as $detail) {
                $query_invoice_details[] = new InvoiceDetail([
                    'order' => $detail['order'],
                    'description' => $detail['description'],
                    'quantity' => (float) $detail['quantity'],
                    'price' => (float) $detail['price'],
                ]);
            }
            $invoice->invoiceDetails()->saveMany($query_invoice_details);
        } else {
            if (count($all_fields['details']) === count($old_invoice_details->all())) {
                foreach ($old_invoice_details->all() as $key => $old_invoice_detail) {
                    InvoiceDetail::where('id', $old_invoice_detail->id)->update([
                        'order' => (int) $all_fields['details'][$key]['order'],
                        'description' => $all_fields['details'][$key]['description'],
                        'quantity' => (float) $all_fields['details'][$key]['quantity'],
                        'price' => (float) $all_fields['details'][$key]['price'],
                    ]);
                }
            } elseif (count($all_fields['details']) > count($old_invoice_details->all())) {
                $query_invoice_details = [];
                foreach ($all_fields['details'] as $key => $detail) {
                    if (!empty($old_invoice_details->all()[$key])) {
                        InvoiceDetail::where('id', $old_invoice_details->all()[$key]->id)->update([
                            'order' => (int) $detail['order'],
                            'description' => $detail['description'],
                            'quantity' => (float) $detail['quantity'],
                            'price' => (float) $detail['price'],
                        ]);
                    } else {
                        $query_invoice_details[] = new InvoiceDetail([
                            'order' => $detail['order'],
                            'description' => $detail['description'],
                            'quantity' => (float) $detail['quantity'],
                            'price' => (float) $detail['price'],
                        ]);
                    }
                }
                $invoice->invoiceDetails()->saveMany($query_invoice_details);
            } elseif (count($all_fields['details']) < count($old_invoice_details->all())) {
                foreach ($old_invoice_details->all() as $key => $old_invoice_detail) {
                    if (!empty($all_fields['details'][$key])) {
                        InvoiceDetail::where('id', $old_invoice_detail->id)->update([
                            'order' => (int) $all_fields['details'][$key]['order'],
                            'description' => $all_fields['details'][$key]['description'],
                            'quantity' => (float) $all_fields['details'][$key]['quantity'],
                            'price' => (float) $all_fields['details'][$key]['price'],
                        ]);
                    } else {
                        $old_invoice_detail->delete();
                    }
                }
            }
        }

        Invoice::where('id', $all_fields['id'])->update([
            'invoice_number' => (int) $all_fields['invoice_number'],
            'invoice_date' => $all_fields['invoice_date'],
            'company' => $all_fields['company_name'],
            'vat' => (float) $all_fields['vat'],
            'total_tax' => (float) $all_fields['total_tax'],
        ]);

        $result = $this->getInvoice($all_fields['id']);
        $result['message'] = trans('success.update');

        return $result;

    }

    public function actionDeleteInvoice(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }

        $invoice = Invoice::find($request->id);
        if (empty($invoice)) {
            return [
                'status' => 'error',
                'message' => trans('error.notId', ['model' => 'invoice']),
            ];
        }

        if ($invoice->creation_status === 'public') {
            return [
                'status' => 'error',
                'message' => trans('error.notDeletePublic', ['model' => 'invoices']),
            ];
        }

        $result = $invoice->delete();
        if (empty($result)) {
            return [
                'status' => 'error',
                'message' => trans('error.notDelete', ['model' => 'invoice']),
            ];
        }
        return [
            'status' => 'success',
            'message' => trans('success.delete', ['model' => 'Invoice']),
        ];

    }

    public function actionPublicInvoice(Request $request)
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

        $result = Invoice::where('id', $request->id)->update([
            'invoice_number' => $invoice_number,
            'status' => 'to_be_sent',
            'creation_status' => 'public',
        ]);
        if (empty($result)) {
            return [
                'status' => 'error',
                'message' => trans('error.notUpdate', ['model' => 'Invoice creation status']),
            ];
        }
        return [
            'status' => 'success',
            'message' => trans('success.update', ['model' => 'Invoice creation status']),
            'invoice' => $this->getInvoice($request->id),
        ];
    }

    public function actionEditStatus(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }

        $validator = Validator::make($request->all(), [
            'id' => 'numeric|required',
            // 'received_date' => 'date|nullable',
            'status' => 'string|required',
        ]);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'messages' => $validator->messages(),
                'form_field' => $request->all()
            ];
        }

        $result = Invoice::where('id', $request->id)->update([
            'status' => $request->status,
            // 'received_date' => $request->received_date,
        ]);
        if (empty($result)) {
            return [
                'status' => 'error',
                'message' => trans('error.notUpdate', ['model' => 'Invoice status']),
            ];
        }

        return [
            'status' => 'success',
            'message' => trans('success.update', ['model' => 'Invoice status']),
            'invoice' => $this->getInvoice($request->id),
        ];
    }

    public function actionEditReceivedDate(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }

        $validator = Validator::make($request->all(), [
            'id' => 'numeric|required',
            'received_date' => 'date|nullable',
        ]);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'messages' => $validator->messages(),
                'form_field' => $request->all()
            ];
        }

        $result = Invoice::where('id', $request->id)->update([
            // 'status' => $request->status,
            'received_date' => $request->received_date,
        ]);
        if (empty($result)) {
            return [
                'status' => 'error',
                'message' => trans('error.notUpdate', ['model' => 'Invoice status']),
            ];
        }

        return [
            'status' => 'success',
            'message' => trans('success.update', ['model' => 'Invoice status']),
            'invoice' => $this->getInvoice($request->id),
        ];
    }

    public function getAllInvoices(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }

        $all_invoices = [];

        $order = 'invoice_number';
        if (!empty($request->sort['order'])) {
            $order = $request->sort['order'];
        }

        $orderBy = 'orderBy';
        if (!empty($request->sort['orderBy'])) {
            if ($request->sort['orderBy'] === 'asc') {
                $orderBy = 'orderBy';
            }
            if ($request->sort['orderBy'] === 'desc') {
                $orderBy = 'orderByDesc';
            }
        }

        $where_default = '';
        if (!empty($request->filter) && is_array($request->filter)) {
            $query_counter = 1;
            foreach ($request->filter as $filter_key => $filter_val) {
                if ($query_counter > 1) {
                    $where_default .= 'AND ';
                }
                if ($filter_key === 'invoice_date') {
                    $str_count = 1;
                    $where_default .= '(';
                    
                    if (!empty($filter_val['min'])) {
                        $where_default .= '`' . $filter_key . '` >= "' . $filter_val['min'] . '" ';
                    }

                    if (!empty($filter_val['min']) && !empty($filter_val['max'])) {
                        $where_default .= 'AND ';
                    }

                    if (!empty($filter_val['max'])) {
                        $where_default .= '`' . $filter_key . '` <= "' . $filter_val['max'] . '" ';
                    }

                    $where_default .= ') ';
                } else {
                    $string = '';
                    $str_count = 1;
                    foreach ($filter_val as $str_val) {
                        if ($str_count === 1) {
                            $string .= '(';
                        } elseif ($str_count > 1) {
                            $string .= 'OR ';
                        }
                        $string .= '`' . $filter_key . '` = "' . $str_val . '" ';
                        if ($str_count === count($filter_val)) {
                            $string .= ') ';
                        }
                        $str_count++;
                    }
                    $where_default .= $string;
                }
                $query_counter++;
            }
        }

        if (!empty($where_default)) {
            $all_invoices = Invoice::whereRaw($where_default)->where('creation_status', 'public')->$orderBy($order)->get();
        } else {
            $all_invoices = Invoice::where('creation_status', 'public')->$orderBy($order)->get()->toArray();
        }

        if (!count($all_invoices)) {
            return [
                'status' => 'error',
                'message' => trans('error.notFound', ['model' => 'Invoices']),
            ];
        }

        foreach ($all_invoices as $key => $invoice) {
            $all_invoices[$key]['invoice_number'] = sprintf('%03d', $invoice['invoice_number']);
            $all_invoices[$key]['invoice_date'] = Carbon::parse($invoice['invoice_date'])->format('d.m.Y');
            $all_invoices[$key]['received_date'] = Carbon::parse($invoice['received_date'])->format('d.m.Y');
            $author = User::find($invoice['author']);
            if (!empty($author)) {
                $all_invoices[$key]['author'] = $author->toArray();
            }
        }

        return [
            'status' => 'success',
            'all_invoices' => $all_invoices,
        ];
    }

    public function getDraftInvoices(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }

        $all_invoices = [];
        $all_invoices = Invoice::where('creation_status', 'draft')->get()->toArray();
        
        if (!count($all_invoices)) {
            return [
                'status' => 'error',
                'message' => trans('error.notFound', ['model' => 'Invoices']),
            ];
        }

        foreach ($all_invoices as $key => $invoice) {
            $all_invoices[$key]['invoice_number'] = sprintf('%03d', $invoice['invoice_number']);
            $author = User::find($invoice['author']);
            if (!empty($author)) {
                $all_invoices[$key]['author'] = $author->toArray();
            }
        }

        return [
            'status' => 'success',
            'all_invoices' => $all_invoices,
        ];
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

        $invoice_company = $invoice_obj->invoiceCompany;
        if (!empty($invoice_company)) {
            $invoice_company = $invoice_company->attributesToArray();
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
        } else {
            $invoice['details'] = [];
        }
        $invoice['invoice_number'] = sprintf('%03d', $invoice['invoice_number']);
        return [
            'status' => 'success',
            'invoice' => $invoice,
        ];
    }

    public function arrangeFormData(Request $request)
    {
        $data = $request->all();
        if (empty($data['invoice_date']['min']) && empty($data['invoice_date']['max'])) {
            unset($data['invoice_date']);
        }
        return $data;
    }
}
