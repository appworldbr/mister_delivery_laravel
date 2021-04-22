<?php

namespace App\Http\Livewire;

use App\Models\Food;
use App\Models\FoodCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class FoodForm extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $food;
    public $image;

    public $state = [
        'active' => true,
    ];
    public $confirmingDelete = false;

    public function saveFood()
    {
        $validatorImage = $this->food
        ? ['nullable', 'mimes:jpg,jpeg,png', 'max:1024']
        : ['required', 'mimes:jpg,jpeg,png', 'max:1024'];

        Validator::make(array_merge($this->state, ['image' => $this->image]), [
            'image' => $validatorImage,
            'name' => ['required', 'max:100'],
            'description' => ['required', 'max:300'],
            'category_id' => ['required', 'exists:food_categories,id'],
            'active' => ['nullable', 'boolean'],
        ])->validate();

        if (!$this->food) {
            $this->authorize('food:create');
            $this->food = Food::create($this->state);
        } else {
            $this->authorize('food:update');
            $this->food->update($this->state);
        }

        if (isset($this->image)) {
            $this->food->updateImage($this->image);
        }

        return redirect()->route("food.index");
    }

    public function delete()
    {
        $this->authorize('food:delete');
        $this->food->delete();
        return redirect()->route("food.index");
    }

    public function updated($field)
    {
        if ($field == "state.price") {
            $this->state['price'] = Food::floatToPrice(Food::priceToFloat($this->state['price']));
        }
    }

    public function mount()
    {
        if ($this->food) {
            $this->state = [
                'name' => $this->food->name,
                'description' => $this->food->description,
                'category_id' => $this->food->category_id,
                'active' => $this->food->getRawOriginal('active'),
                'price' => $this->food->price,
            ];
        } else {
            $this->state['category_id'] = FoodCategory::first()->id ?? null;
        }
    }

    public function render()
    {
        return view('food.food-form');
    }
}
