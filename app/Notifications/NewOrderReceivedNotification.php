<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderReceivedNotification extends Notification
{
    use Queueable;

    public function __construct(protected Order $order)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Order Received',
            'message' => "New order {$this->order->order_number} received.",
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'buyer_name' => $this->order->buyer->name ?? 'Customer',
        ];
    }
}
