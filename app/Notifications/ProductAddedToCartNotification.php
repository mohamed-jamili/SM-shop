<?php

namespace App\Notifications;

use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductAddedToCartNotification extends Notification
{
    use Queueable;

    public function __construct(protected User $buyer, protected Product $product)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Cart Activity',
            'message' => "Client {$this->buyer->name} added {$this->product->name} to cart.",
            'buyer_name' => $this->buyer->name,
            'product_name' => $this->product->name,
            'product_id' => $this->product->id,
            'order_id' => null,
        ];
    }
}
