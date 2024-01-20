<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Repository\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('frontend.pages.login');
    }

    public function login(LoginRequest $request) {
        $response = AuthRepository::login($request);
        if(!$response["status"]) {
            alertNotify(false, $response["message"]);
            return back()
                ->withInput();
        }

        return redirect()->intended($response["data"]["redirect"]);
    }

    public function logout(Request $request) {
        return AuthRepository::logout($request);
    }
}
