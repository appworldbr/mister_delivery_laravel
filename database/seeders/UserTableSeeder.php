<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "admin",
            'email' => "admin@admin.com",
            'password' => Hash::make('password'),
            'is_admin'=> true,
        ]);

        User::create([
            'name'=> "user",
            'email'=> "user@user.com",
            'password' => Hash::make('password'),
        ]);
    }
}
