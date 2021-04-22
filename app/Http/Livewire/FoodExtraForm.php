<?php

namespace App\Http\Livewire;

use App\Models\FoodCategory;
use App\Models\FoodExtra;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class FoodExtraForm extends Component
{
    use AuthorizesRequests;

    public $foodExtra;
    public $state = [
        'limit' => 1,
        'active' => true,
    ];
    public $confirmingDelete = false;

    public function save()
    {
        $data = $this->state;
        if (isset($data['price'])) {
            $data['price'] = FoodExtra::priceToFloat($data['price']);
        }

        Validator::make($data, [
            'name' => ['required', 'max:100'],
            'category_id' => ['required', 'exists:food_categories,id'],
            'limit' => ['required', 'min:1'],
            'price' => ['required', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'active' => ['nullable', 'boolean'],
        ])->validate();

        if (!$this->foodExtra) {
            $this->authorize('foodExtra:create');
            FoodExtra::create($data);
            session()->flash('flash.banner', __('Food Extra successfully created!'));
        } else {
            $this->authorize('foodExtra:update');
            $this->foodExtra->update($data);
            session()->flash('flash.banner', __('Food Extra successfully updated!'));
        }

        return redirect()->route("foodExtra.index");
    }

    public function delete()
    {
        $this->authorize('foodExtra:delete');
        $this->foodExtra->delete();
        session()->flash('flash.banner', __('Food Extra successfully deleted!'));
        return redirect()->route("foodExtra.index");
    }

    public function mount()
    {
        if ($this->foodExtra) {
            $this->state = [
                'name' => $this->foodExtra->name,
                'limit' => $this->foodExtra->limit,
                'category_id' => $this->foodExtra->category_id,
                'active' => $this->foodExtra->getRawOriginal('active'),
                'price' => $this->foodExtra->price,
            ];
        } else {
            $this->state['category_id'] = FoodCategory::first()->id ?? null;
        }
    }

    public function updated($field)
    {
        if ($field == "state.price") {
            $this->state['price'] = FoodExtra::floatToPrice(FoodExtra::priceToFloat($this->state['price']));
        }
    }

    public function render()
    {
        return view('food_extras.food-extra-form');
    }
}
