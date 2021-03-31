<?php

namespace Database\Seeders;

use App\Models\UserAddress;
use Illuminate\Database\Seeder;

class UserAdressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserAddress::create([
            'user_id'=>'1',
            'name' => "Casa",
            'zip' => "00000-000",
            'state' => "MG",
            'city' => "Macaé",
            'district' => "Macaé",
            'address' => "Rua Leopodina Araujo",
            'number' => "862",
            'complement' => "Rua atras ao pavani",
            'is_default' => true,
            
        ]);
        UserAddress::create([
            'user_id'=>'1',
            'name' => "Trabalho",
            'zip' => "00000-000",
            'state' => "MG",
            'city' => "Macaé",
            'district' => "Macaé",
            'address' => "Rua Leopodina Araujo",
            'number' => "862",
            'complement' => "Rua atras ao pavani",
            'is_default' => true,
            
        ]);
    }
}
