<?php

namespace App\Repository;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthRepository {
    public static function login($request) {
        try {
            $request->authenticate();

            $request->session()->regenerate();

            if (self::checkIsAdmin()) {
                return responseCustom("Login Success", ["redirect" => RouteServiceProvider::ADMIN] , true, 200);
            }

            return responseCustom("Login Success", ["redirect" => RouteServiceProvider::USERS] , true, 200);
        } catch (\Throwable $th) {
            return responseCustom($th->getMessage());
        }
    }

    public static function logout($request) {
        try {
            $isAdmin = self::checkIsAdmin();

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return responseCustom("Logout Success", ["redirect" => $isAdmin ? RouteServiceProvider::ADMIN : RouteServiceProvider::USERS], true, 200);
        } catch (\Throwable $th) {
            return responseCustom($th->getMessage());
        }
    }

    private static function checkIsAdmin() {
        return Auth::user()
            ->getRoleNames()
            ->isNotEmpty();
    }
}
