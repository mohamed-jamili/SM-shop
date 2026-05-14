<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BuyerOrderStatusNotification extends Notification
{
    use Queueable;

    public function __construct(protected Order $order, protected string $status)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Order Update',
            'message' => $this->buildMessage(),
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'status' => $this->status,
        ];
    }

    protected function buildMessage(): string
    {
        return match ($this->status) {
            'accepted' => "Your order {$this->order->order_number} has been accepted by the seller.",
            'preparing' => "Your order {$this->order->order_number} is now being prepared.",
            'shipping' => "Your order {$this->order->order_number} is now being shipped.",
            'delivered' => "Your order {$this->order->order_number} has been delivered.",
            'rejected' => "Your order {$this->order->order_number} has been rejected by the seller.",
            default => "Your order {$this->order->order_number} status has changed.",
        };
    }
}
