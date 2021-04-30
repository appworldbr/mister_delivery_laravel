<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrdersOfTheDay extends Component
{
    public $orders = [];

    public $confirmPreparationId;
    public $confirmingPreparation = false;

    public $confirmDeliveryId;
    public $confirmingDelivery = false;

    public $confirmConclusionId;
    public $confirmingConclusion = false;

    public $confirmCancelId;
    public $confirmingCancelation = false;

    // Preparation Stuffs
    public function showPreparationModal($id)
    {
        $this->confirmPreparationId = $id;
        $this->confirmingPreparation = true;
    }

    public function closePreparationModal()
    {
        $this->confirmPreparationId = null;
        $this->confirmingPreparation = false;
    }

    public function goToPreparation()
    {
        $this->updateOrderStatus($this->confirmPreparationId, Order::STATUS_PREPARATION);
        $this->confirmPreparationId = null;
        $this->confirmingPreparation = false;
    }

    // Delivery Stuffs
    public function showDeliveryModal($id)
    {
        $this->confirmDeliveryId = $id;
        $this->confirmingDelivery = true;
    }

    public function closeDeliveryModal()
    {
        $this->confirmDeliveryId = null;
        $this->confirmingDelivery = false;
    }

    public function goToDelivery()
    {
        $this->updateOrderStatus($this->confirmDeliveryId, Order::STATUS_DELIVERY);
        $this->confirmDeliveryId = null;
        $this->confirmingDelivery = false;
    }

    // Conclusion Stuffs
    public function showConclusionModal($id)
    {
        $this->confirmConclusionId = $id;
        $this->confirmingConclusion = true;
    }

    public function closeConclusionModal()
    {
        $this->confirmConclusionId = null;
        $this->confirmingConclusion = false;
    }

    public function conclude()
    {
        $this->updateOrderStatus($this->confirmConclusionId, Order::STATUS_CONCLUDED);
        $this->confirmConclusionId = null;
        $this->confirmingConclusion = false;
    }

    // Delete Modal
    public function showCancelModal($id)
    {
        $this->confirmCancelId = $id;
        $this->confirmingCancelation = true;
    }

    public function closeCancelModal()
    {
        $this->confirmCancelId = null;
        $this->confirmingCancelation = false;
    }

    public function cancel()
    {
        $this->updateOrderStatus($this->confirmCancelId, Order::STATUS_CANCELED);
        $this->confirmCancelId = null;
        $this->confirmingCancelation = false;
    }

    public function reloadOrders()
    {
        $this->orders = Order::with('food')->today()->get();
    }

    public function updateOrderStatus($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->status = $status;
        $order->save();
        $this->reloadOrders();
    }

    public function mount()
    {
        $this->reloadOrders();
    }

    public function render()
    {
        return view('orders-of-the-day.orders-of-the-day');
    }

}
