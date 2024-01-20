<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'password' => Hash::make('12345678'),
        ]);
        $role = Role::create(['name' => 'super-admin']);
        $user->assignRole($role);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $role = Role::create(['name' => 'admin']);
        $user->assignRole($role);
    }
}
