<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OrderCard extends Component
{
    public $order;
    public $borderOpenColor;
    public $userButtonColor;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($order, $borderOpenColor, $userButtonColor)
    {
        $this->order = $order;
        $this->borderOpenColor = $borderOpenColor;
        $this->userButtonColor = $userButtonColor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.order-card');
    }
}
