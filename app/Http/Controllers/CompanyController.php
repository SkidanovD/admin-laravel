<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function actionAddCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|nullable',
            'company_name' => 'required|string',
            'address' => 'string|nullable',
            'post_code' => 'string|nullable',
            'city' => 'string|nullable',
            'phone' => 'string|nullable',
            'siret' => 'numeric|nullable',
            'rcs' => 'numeric|nullable',
            'tva' => 'string|nullable',
            'note' => 'string|nullable',
        ]);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'messages' => $validator->messages(),
                'form_field' => $request->all()
            ];
        }
        
        $company = Company::create([
            'name' => !empty($request->name) ? $request->name : '',
            'company_name' => $request->company_name,
            'address' => !empty($request->address) ? $request->address : '',
            'post_code' => !empty($request->post_code) ? $request->post_code : '',
            'city' => !empty($request->city) ? $request->city : '',
            'phone' => !empty($request->phone) ? $request->phone : '',
            'siret' => !empty($request->siret) ? $request->siret : '',
            'rcs' => !empty($request->rcs) ? $request->rcs : '',
            'tva' => !empty($request->tva) ? $request->tva : '',
            'note' => !empty($request->note) ? $request->note : '',
        ]);
        
        return [
            'status' => 'success',
            'message' => 'Сompany established successfully'
        ];
    }
}
