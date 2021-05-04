<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartExtra;
use App\Models\DayOff;
use App\Models\DeliveryArea;
use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\FoodExtra;
use App\Models\Order;
use App\Models\OrderExtra;
use App\Models\OrderFood;
use App\Models\User;
use App\Models\WorkSchedule;
use Arr;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->categories();
        $this->food();
        $this->extras();
        $this->workSchedule();
        $this->dayOffs();
        $this->deliveryArea();
        $this->cart();
        $this->orders();
    }

    protected function categories()
    {
        FoodCategory::query()->delete();
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

    protected function food()
    {
        Food::query()->delete();
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

    protected function extras()
    {
        FoodExtra::query()->delete();
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

    protected function workSchedule()
    {
        WorkSchedule::query()->delete();

        for ($i = 0; $i <= 6; $i++) {
            WorkSchedule::create([
                'weekday' => $i,
                'start' => '00:00',
                'end' => '23:59',
            ]);
        }
    }

    protected function dayOffs()
    {
        DayOff::query()->delete();

        DayOff::create([
            'day' => Carbon::tomorrow(),
            'start' => '00:00',
            'end' => '23:59',
        ]);
    }

    protected function deliveryArea()
    {
        DeliveryArea::query()->delete();

        DeliveryArea::create([
            'initial' => '00000000',
            'final' => '99999999',
            'price' => 8,
            'prevent' => false,
        ]);
    }

    protected function cart()
    {
        $user = User::where('email', 'user@user.com')->first();
        Cart::currentUser($user->id)->delete();
        for ($i = 0; $i < 5; $i++) {
            $food = Food::inRandomOrder()->first();
            $cart = Cart::create([
                'user_id' => $user->id,
                'food_id' => $food->id,
                'quantity' => random_int(1, 5),
                'observation' => random_int(0, 1) ? '' : Arr::random(['Sem Cebola', 'Sem Molho', 'Capricha do Tempero', 'Bem quente']),
            ]);
            foreach ($food->extras as $extra) {
                if (random_int(0, 1)) {
                    CartExtra::create([
                        'cart_id' => $cart->id,
                        'extra_id' => $extra->id,
                        'quantity' => random_int(1, $extra->limit),
                    ]);
                }
            }
        }
    }

    protected function orders()
    {

        $user = User::where('email', 'user@user.com')->first();
        Order::currentUser($user->id)->delete();
        for ($j = 0; $j < random_int(20, 50); $j++) {
            $cart = collect();
            $randomQuantity = random_int(1, 10);
            for ($i = 0; $i < $randomQuantity; $i++) {

                $food = Food::inRandomOrder()->first();

                $cartItem = [
                    'food' => $food,
                    'quantity' => random_int(1, 5),
                    'observation' => random_int(0, 1) ? '' : Arr::random(['Sem Cebola', 'Sem Molho', 'Capricha do Tempero', 'Bem quente']),
                    'extras' => [],
                ];

                foreach ($food->extras as $extra) {
                    if (random_int(0, 1)) {
                        $cartItem['extras'][] = ['extra' => $extra, 'quantity' => random_int(1, $extra->limit)];
                    }
                }

                $cart->push($cartItem);
            }

            $address = $user->address()->inRandomOrder()->first();
            $deliveryArea = DeliveryArea::validationZip($address->zip);

            $cartTotal = round(collect($cart)->map(function ($cartItem) {
                $foodSum = $cartItem['quantity'] * (float) $cartItem['food']->getRawOriginal('price');
                $extraSum = collect($cartItem['extras'])->map(function ($extraItem) {
                    return $extraItem['quantity'] * (float) $extraItem['extra']->getRawOriginal('price');
                })->sum();
                return round($foodSum + $extraSum, 2);
            })->sum(), 2);

            $paymentType = Arr::random(['cash', 'cards']);

            switch ($paymentType) {
                case 'cash':
                    $paymentDetails = [
                        'value' => $cartTotal,
                    ];
                    break;
                case 'cards':
                    $qtyCards = random_int(1, 3);

                    $paymentDetails = [
                        'cards' => [],
                    ];

                    $cardIndividualPrice = round($cartTotal / $qtyCards, 2);
                    for ($i = 0; $i < $qtyCards; $i++) {
                        $paymentDetails['cards'][] = [
                            'value' => $cardIndividualPrice,
                        ];
                    }

                    break;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'zip' => $address->zip,
                'state' => $address->state,
                'city' => $address->city,
                'district' => $address->district,
                'address' => $address->address,
                'number' => $address->number,
                'complement' => $address->complement,
                'status' => random_int(0, 4),
                'delivery_fee' => round($deliveryArea->getRawOriginal('price'), 2),
                'payment_type' => $paymentType,
                'payment_details' => json_encode($paymentDetails),
            ]);

            foreach (collect($cart) as $item) {
                $orderFood = OrderFood::create([
                    'order_id' => $order->id,
                    'name' => $item['food']->name,
                    'price' => round($item['food']->getRawOriginal('price'), 2),
                    'observation' => $item['observation'],
                    'quantity' => $item['quantity'],
                ]);

                if ($item['extras']) {
                    foreach ($item['extras'] as $extraItem) {
                        OrderExtra::create([
                            'order_food_id' => $orderFood->id,
                            'name' => $extraItem['extra']->name,
                            'quantity' => $extraItem['quantity'],
                            'price' => round($extraItem['extra']->getRawOriginal('price'), 2),
                        ]);
                    }
                }
            }
        }
    }
}
