<?php

namespace App\Observers;

use App\Models\OrderItem;

class OrderItemObserver
{
    public function updated(OrderItem $orderItem): void
    {
        if ($orderItem->wasChanged('status') && $orderItem->status === 'served') {
            $orderItem->order->checkAndCompleteOrder();
        }
    }
}
