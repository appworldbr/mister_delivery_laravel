<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\FoodExtra;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->clear();
        $this->categories();
        $this->foods();
        $this->extras();
    }

    protected function clear()
    {        
        FoodExtra::query()->delete();
        Food::query()->delete();
        FoodCategory::query()->delete();
    }

    protected function extras()
    {
        $hamburguer = FoodCategory::where('icon', 'hamburguer')->first();

        FoodExtra::create([
            'name' => 'Carne',
            'price' => 4,
            'limit' => 3,
            'category_id' => $hamburguer->id,
        ]);

        FoodExtra::create([
            'name' => 'Catupiry',
            'price' => 3,
            'limit' => 1,
            'category_id' => $hamburguer->id,
        ]);

        FoodExtra::create([
            'name' => 'Cheddar',
            'price' => 4.2,
            'limit' => 1,
            'category_id' => $hamburguer->id,
        ]);

        FoodExtra::create([
            'name' => 'Calabresa',
            'price' => 2,
            'limit' => 1,
            'category_id' => $hamburguer->id,
            'active' => false,
        ]);

        FoodExtra::create([
            'name' => 'Frango Desfiado',
            'price' => 3.8,
            'limit' => 1,
            'category_id' => $hamburguer->id,
        ]);        
    }

    protected function foods()
    {
        $hamburguer = FoodCategory::where('icon', 'hamburguer')->first();

        Food::create([
            'name' => 'X-Tudo',
            'price' => 12,
            'description' => 'Carne, Ovo, Alface, Bacon, Calabresa, Tomate, Presunto, Queijo, Frango',
            'category_id' => $hamburguer->id,
        ]);

        Food::create([
            'name' => 'X-Picanha',
            'price' => 15,
            'description' => 'Carne de Picanha, Ovo, Bacon, Calabresa, Presunto, Queijo',
            'category_id' => $hamburguer->id,
        ]);

        Food::create([
            'name' => 'X-Frangão',
            'price' => 11.5,
            'description' => 'Batata Palha, Ovo, Alface, Tomate, Presunto, Queijo, Frango',
            'category_id' => $hamburguer->id,
        ]);

        Food::create([
            'name' => 'X-Nada',
            'price' => 10,
            'description' => 'Carne, Presunto, Queijo',
            'category_id' => $hamburguer->id,
            'active' => false,
        ]);

        $drink = FoodCategory::where('icon', 'drink')->first();

        Food::create([
            'name' => 'Coca-Cola Lata',
            'price' => 5,
            'category_id' => $drink->id,
        ]);

        Food::create([
            'name' => 'Coca-Cola 2L',
            'price' => 10,
            'category_id' => $drink->id,
        ]);

        Food::create([
            'name' => 'Suco de Laranja',
            'price' => 8,
            'category_id' => $drink->id,
        ]);

        $candy = FoodCategory::where('icon', 'candy')->first();

        Food::create([
            'name' => 'Churros',
            'price' => 5.5,
            'description' => 'Churros com Doce de Leite',
            'category_id' => $candy->id,
        ]);

        Food::create([
            'name' => 'Açai 500ml',
            'price' => 12,
            'category_id' => $candy->id,
        ]);
    }

    protected function categories()
    {
        /*
        Categories Available

        'hamburger',
        'food',
        'japanese',
        'pastry',
        'candy',
        'drink',
         */

        FoodCategory::create([
            'name' => 'Lanche',
            'icon' => 'hamburguer',
        ]);

        FoodCategory::create([
            'name' => 'Bebidas',
            'icon' => 'drink',
        ]);

        FoodCategory::create([
            'name' => 'Doces',
            'icon' => 'candy',
        ]);
    }

}
