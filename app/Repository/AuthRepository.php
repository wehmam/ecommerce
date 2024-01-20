<?php

namespace App\Repository;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;



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

    public static function register() {
        try {
            $validator = \Validator::make(request()->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()]
            ]);

            if($validator->fails()) {
                return responseCustom(implode(" - ", $validator->messages()->all()), code: 400);
            }

            $user = User::create([
                'name' => request()->name,
                'email' => request()->email,
                'password' => bcrypt(request()->password),
            ]);

            event(new Registered($user));

            Auth::login($user);

            return responseCustom("Register Success", ["redirect" => RouteServiceProvider::USERS] , true, 200);
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

    public static function checkIsAdmin() {
        return Auth::user()
            ->getRoleNames()
            ->isNotEmpty();
    }
}
