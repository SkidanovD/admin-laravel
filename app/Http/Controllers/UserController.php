<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    public function getAuthUser(Request $request)
    {
        $auth_user = Auth::user();
        return $auth_user;
    }

    public function actionAddUser(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }
        if ($auth_user->role !== 'admin') {
            return [
                'status' => 'error',
                'message' => trans('error.authorization'),
            ];
        }
        $validator =  Validator::make($request->all(), [
            'photo' => 'image|nullable|max:2048',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'messages' => $validator->messages(),
                'form_field' => $request->all()
            ];
        }

        if($request->hasFile('photo')) {
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('photo')->getClientOriginalExtension();
            $fileNameToStore = "photo".DIRECTORY_SEPARATOR.$filename."_".time().".".$extention;
            $path = $request->file('photo')->storeAs('public', $fileNameToStore);
            $finalPath = '/storage/photo/' .$filename."_".time().".".$extention;
        }
        
        $hash_password = Hash::make($request->password);
        $user = User::create([
            'first_name' => !empty($request->first_name) ? $request->first_name : '',
            'last_name' => !empty($request->last_name) ? $request->last_name : '',
            'photo' => !empty($finalPath) ? $finalPath : '',
            'user_post' => !empty($request->user_post) ? $request->user_post : '',
            'email' => $request->email,
            'role' => !empty($request['role']) ? $request['role'] : 'user',
            'password' => $hash_password,
        ]);
    
        return [
            'status' => 'success',
            'message' => trans('success.added', ['model' => 'User']),
            'user' => $user,
        ];
    }

    public function actionEditUser(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }
        $user_old_data = User::find($request->id, ['first_name', 'last_name', 'photo', 'user_post', 'email', 'role']);
        $query_data = [];
        $query_validator = [
            'first_name' => 'string|nullable|max:255',
            'last_name' => 'string|nullable|max:255',
            'photo' => 'image|nullable|max:2048',
            'user_post' => 'string|nullable|max:255',
            'email' => 'nullable|string|email|max:255',
            'role' => 'nullable|string|max:255',
        ];
        foreach ($request->all() as $key => $item) {
            if ($item === null) {
                $item = '';
            }
            if (isset($user_old_data->$key) && $user_old_data->$key !== $item) {
                $query_data[$key] = $item;
            }
        }

        if (!empty($request->password)) {
            $query_data['password'] = $request->password;
            $query_data['password_confirmation'] = $request->password_confirmation;
            $query_validator['password'] = 'required|string|min:8|confirmed';
        }
        if (empty($query_data)) {
            return [
                'status' => 'error',
                'messages' => trans('error.notChanged'),
                'form_field' => $request->all(),
            ];
        }
        $validator = Validator::make($query_data, $query_validator);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'messages' => $validator->messages(),
                'form_field' => $request->all()
            ];
        }

        if($request->hasFile('photo')) {
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('photo')->getClientOriginalExtension();
            $fileNameToStore = "photo".DIRECTORY_SEPARATOR.$filename."_".time().".".$extention;
            $path = $request->file('photo')->storeAs('public', $fileNameToStore);
        }
        if (!empty($path)) {
            $query_data['photo'] = '/storage/photo/' .$filename."_".time().".".$extention;
        }

        if (!empty($query_data['password'])) {
            $query_data['password'] = Hash::make($query_data['password']);
            unset($query_data['password_confirmation']);
        }

        $now_time = Carbon::now();
        $query_data['updated_at'] = $now_time->toDateTimeString();

        $user = User::where('id', $request->id)->update($query_data);
        $user_new = User::find($request->id);
        return [
            'status' => 'success',
            'message' => trans('success.update'),
            'form_field' => $user_new,
        ];
    }

    public function actionDeleteUser(Request $request)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }
        if ($auth_user->role !== 'admin') {
            return [
                'status' => 'error',
                'message' => trans('error.authorization'),
            ];
        }
        $user = User::find($request->id);
        if (empty($user)) {
            return [
                'status' => 'error',
                'message' => trans('error.notId', ['model' => 'user']),
            ];
        }
        $result = $user->delete();
        if (empty($result)) {
            return [
                'status' => 'error',
                'message' => trans('error.notDelete', ['model' => 'user']),
            ];
        }
        return [
            'status' => 'success',
            'message' => trans('succes.delete', ['model' => 'User']),
        ];
    }

    public function getAllUsers()
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }
        if ($auth_user->role !== 'admin') {
            return [
                'status' => 'error',
                'message' => trans('error.authorization'),
            ];
        }
        $all_users = User::all();
        if (empty($all_users->all())) {
            return [
                'status' => 'error',
                'message' => trans('error.notFound', ['model' => 'Users']),
            ];
        }
        return [
            'status' => 'success',
            'all_users' => $all_users->all(),
        ];

    }

    public function getUser($id)
    {
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            return [
                'status' => 'error',
                'message' => trans('error.authentication'),
            ];
        }
        $user = User::find($id);
        
        if (empty($user)) {
            return [
                'status' => 'error',
                'message' => trans('error.notFound', ['model' => 'User']),
            ];
        }
        return [
            'status' => 'success',
            'user' => $user,
        ];
    }
}
