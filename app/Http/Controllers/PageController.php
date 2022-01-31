<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function getCSRFToken(Request $request)
    {
        return csrf_token();
    }
 
    public function showRegisterForm()
    {
        return [
            'register_route' => route('actionAddUser'),
            'csrf_token' => csrf_token(),
        ];
    }

    public function getPageEditUser()
    {
        return [
            'edit_user_route' => route('actionEditUser'),
            'csrf_token' => csrf_token(),
        ];
    }
}
