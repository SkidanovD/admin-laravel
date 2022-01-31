<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            // $finalPath = storage_path('app'). '/' . $path;
            $finalPath = '/storage/photo/' .$filename."_".time().".".$extention;
        }
        
        $hash_password = md5($request->password);
        $user = User::create([
            'first_name' => !empty($request->first_name) ? $request->first_name : '',
            'last_name' => !empty($request->last_name) ? $request->last_name : '',
            'photo' => !empty($finalPath) ? $finalPath : '',
            'user_post' => !empty($request->user_post) ? $request->user_post : '',
            'email' => $request->email,
            'role' => !empty($request['role']) ? $request['role'] : 'user',
            'password' => $hash_password,
        ]);
    
        return ['status' => 'success'];
    }

    public function actionEditUser(Request $request)
    {
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
            if (!empty($user_old_data->$key) && $item !== $user_old_data->$key) {
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
                'messages' => 'None of the fields have been changed.',
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
            $query_data['password'] = md5($query_data['password']);
            unset($query_data['password_confirmation']);
        }

        $now_time = Carbon::now();
        $query_data['updated_at'] = $now_time->toDateTimeString();

        $user = User::where('id', $request->id)->update($query_data);
        $user_new = User::find($request->id);
        return [
            'status' => 'success',
            'form_field' => $user_new,
        ];
    }

    public function getAllUsers()
    {
        $auth_user = Auth::user();
        if (!empty($auth_user) && $auth_user->role === 'admin') {
            return User::all();
        }

    }

    public function getUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found',
            ])->setStatusCode(404);
        }
        return $user;

    }
}
