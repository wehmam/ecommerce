<?php

namespace Database\Seeders;

use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            [
                "name"      => "Users",
                "email"     => "users@gmail.com",
                "password"  => bcrypt("users"),
            ]
        ]);

        $credentials = [
            'email'    => 'admin@gmail.com',
            'password' => 'admin',
            'first_name'     => 'Super',
            'last_name' => "Admin"
        ];

        Sentinel::registerAndActivate($credentials);
    }
}
