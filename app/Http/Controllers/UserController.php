<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            $finalPath = storage_path('app'). '/' . $path;
        }
        
        $hash_password = md5($request->password);
        $user = User::create([
            'first_name' => !empty($request->first_name) ? $request->first_name : '',
            'last_name' => !empty($request->last_name) ? $request->last_name : '',
            'photo' => !empty($finalPath) ? $finalPath : '',
            'user_post' => !empty($request->user_post) ? $request->user_post : '',
            'email' => $request->email,
            'role' => !empty($data['role']) ? $data['role'] : 'user',
            'password' => $hash_password,
        ]);
    
        return ['status' => 'success'];
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
