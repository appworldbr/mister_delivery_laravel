<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderForm extends Component
{
    public $order;

    public $confirmingChangeToAwaitingApproval = false;
    public $confirmingChangeToPreparation = false;
    public $confirmingChangeToDelivery = false;
    public $confirmingChangeToConclude = false;
    public $confirmingChangeToCancel = false;
    public $confirmingDelete = false;

    public function changeToAwaitingApproval()
    {
        $this->order->status = Order::STATUS_WAITING;
        $this->order->save();
        $this->confirmingChangeToAwaitingApproval = false;
    }

    public function changeToPreparation()
    {
        $this->order->status = Order::STATUS_PREPARATION;
        $this->order->save();
        $this->confirmingChangeToPreparation = false;
    }

    public function changeToDelivery()
    {
        $this->order->status = Order::STATUS_DELIVERY;
        $this->order->save();
        $this->confirmingChangeToDelivery = false;
    }

    public function changeToConclude()
    {
        $this->order->status = Order::STATUS_CONCLUDED;
        $this->order->save();
        $this->confirmingChangeToConclude = false;
    }

    public function changeToCancel()
    {
        $this->order->status = Order::STATUS_CANCELED;
        $this->order->save();
        $this->confirmingChangeToCancel = false;
    }

    public function delete()
    {
        $this->order->delete();
        session()->flash('flash.banner', __('Order successfully deleted!'));
        return redirect()->route("order.index");
    }

    public function render()
    {
        return view('orders.order-form');
    }
}
