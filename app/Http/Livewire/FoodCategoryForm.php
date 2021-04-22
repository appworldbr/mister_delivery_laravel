<?php

namespace App\Http\Livewire;

use App\Models\FoodCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class FoodCategoryForm extends Component
{
    use AuthorizesRequests;

    public $foodCategory;
    public $state = [
        'icon' => 'hamburger',
    ];
    public $confirmingDelete = false;

    public function save()
    {
        Validator::make($this->state, [
            'name' => ['required', 'max:100'],
            'icon' => ['required',
                Rule::in([
                    'hamburger',
                    'food',
                    'japanese',
                    'pastry',
                    'candy',
                    'drink',
                ]),
            ],
        ])->validate();

        if (!$this->foodCategory) {
            $this->authorize('foodCategory:create');
            FoodCategory::create($this->state);
            session()->flash('flash.banner', __('Food Category successfully created!'));
        } else {
            $this->authorize('foodCategory:update');
            $this->foodCategory->update($this->state);
            session()->flash('flash.banner', __('Food Category successfully updated!'));
        }

        return redirect()->route("foodCategory.index");
    }

    public function delete()
    {
        $this->authorize('foodCategory:delete');
        $this->foodCategory->delete();
        session()->flash('flash.banner', __('Food Category successfully deleted!'));
        return redirect()->route("foodCategory.index");
    }

    public function mount()
    {
        if ($this->foodCategory) {
            $this->state = [
                'name' => $this->foodCategory->name,
                'icon' => $this->foodCategory->getRawOriginal('icon'),
            ];
        }
    }

    public function render()
    {
        return view('food_categories.food-category-form');
    }
}
