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
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }
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
            'message' => trans('success.added', ['model' => 'Company']),
            'company' => $company,
        ];
    }

    public function actionEditCompany(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }
        $company_old_data = Company::find($request->id, ['name', 'company_name', 'address', 'post_code', 'city', 'phone', 'siret', 'rcs', 'tva', 'note']);
        $query_data = [];
        foreach ($request->all() as $key => $item) {
            if ($item === null) {
                $item = '';
            }
            if (isset($company_old_data->$key) && $company_old_data->$key !== $item) {
                $query_data[$key] = $item;
            }
        }
        if (empty($query_data)) {
            return [
                'status' => 'error',
                'messages' => trans('error.notChanged'),
                'form_field' => $request->all(),
            ];
        }
        $validator = Validator::make($query_data, [
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
            'message' => trans('success.update'),
            'form_field' => $company_new,
        ];
    }

    public function actionDeleteCompany(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }
        $company = Company::find($request->id);
        if (empty($company)) {
            return [
                'status' => 'error',
                'message' => trans('error.notId', ['model' => 'company']),
            ];
        }
        $result = $company->delete();
        if (empty($result)) {
            return [
                'status' => 'error',
                'message' => trans('error.notDelete', ['model' => 'company']),
            ];
        }
        return [
            'status' => 'success',
            'message' => trans('success.delete', ['model' => 'Company']),
        ];
    }

    public function getAllCompanies()
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }
        $all_companies = Company::all();
        if (empty($all_companies->all())) {
            return [
                'status' => 'error',
                'message' => trans('error.notFound', ['model' => 'Companies']),
            ];
        }
        return [
            'status' => 'success',
            'all_companies' => $all_companies->all(),
        ];
    }

    public function getCompany($id)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication')
            ];
        }
        $company = Company::find($id);
        if (empty($company)) {
            return [
                'status' => 'error',
                'message' => trans('error.notFound', ['model' =>'Company']),
            ];
        }
        return [
            'status' => 'success',
            'company' => $company,
        ];
    }
}
