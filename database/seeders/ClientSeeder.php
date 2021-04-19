<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use Hash;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'user@user.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Usuário 1',
                'email' => 'user@user.com',
                'password' => Hash::make('password'),
            ]);
        }

        $address1 = UserAddress::firstOrCreate([
            'name' => 'Casa',
            'zip' => '27940862',
            'state' => 'RJ',
            'city' => 'Macaé',
            'district' => 'Sol y Mar',
            'address' => 'Rua Leopoldina Araujo',
            'number' => '862',
            'complement' => null,
            'is_default' => true,
            'user_id' => $user->id,
        ]);

        $address1 = UserAddress::firstOrCreate([
            'name' => 'Trabalho',
            'zip' => '99999999',
            'state' => 'AA',
            'city' => 'AAAAAAA',
            'district' => 'BBBBBBBB',
            'address' => 'CCCCCCCCC',
            'number' => '222',
            'complement' => 'Lorem Ipsum Dolor Amet',
            'is_default' => false,
            'user_id' => $user->id,
        ]);
    }
}
