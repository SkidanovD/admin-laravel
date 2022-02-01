<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function actionEditCompany(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => 'User not authorized'
            ];
        }
        $company_old_data = Company::find($request->id, ['name', 'company_name', 'address', 'post_code', 'city', 'phone', 'siret', 'rcs', 'tva', 'note']);
        $query_data = [];
        foreach ($request->all() as $key => $item) {
            if ($company_old_data->$key !== $item) {
                $query_data[$key] = $item;
            }
        }
        if (empty($query_data)) {
            return [
                'status' => 'error',
                'messages' => 'None of the fields have been changed.',
                'form_field' => $request->all(),
            ];
        }
        $validator = Validator::make($query_data(), [
            'name' => 'string|nullable',
            'company_name' => 'string',
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

        $now_time = Carbon::now();
        $query_data['updated_at'] = $now_time->toDateTimeString();

        $company = Company::where('id', $request->id)->update($query_data);
        $company_new = Company::find($request->id);
        return [
            'status' => 'success',
            'message' => 'Data updated successfully.',
            'form_field' => $company_new,
        ];
    }

    public function actionDeleteCompany(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => 'User not authorized'
            ];
        }
        $company = Company::find($request->id);
        if (empty($company)) {
            return [
                'status' => 'error',
                'message' => 'There is no company with this id.',
            ];
        }
        $result = $company->delete();
        if (empty($result)) {
            return [
                'status' => 'error',
                'message' => 'The company has not been deleted'
            ];
        }
        return [
            'status' => 'success',
            'message' => 'Company deleted successfully'
        ];
    }

    public function getAllCompanies()
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => 'User not authorized'
            ];
        }
        $all_companies = Company::all();
        if (empty($all_companies)) {
            return [
                'status' => 'error',
                'message' => 'Companies not found.',
            ];
        }
        return [
            'status' => 'success',
            'all_companies' => $all_companies,
        ];
    }

    public function getCompany($id)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => 'User not authorized'
            ];
        }
        $company = Company::find($id);
        if (empty($company)) {
            return [
                'status' => 'error',
                'message' => 'Company not found.',
            ];
        }
        return [
            'status' => 'success',
            'company' => $company,
        ];
    }
}
