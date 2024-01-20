<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;


class AuthBackendController extends Controller
{
    public function index() {
        return view('backend.pages.login');
    }

    public function loginPost(Request $request) {
        $auth = [
            'email'     => $request->get('email'),
            'password'  => $request->get('password')
        ];

        $user = Sentinel::authenticate($auth);
        if(!$user) {
            alertNotify(false, "Authorization Failed!");
            return redirect(url('backend/login'));
        }
        return redirect(url('/backend'));
    }

    public function logout() {
        Sentinel::logout();
        return redirect(url('/backend'));
    }

}
