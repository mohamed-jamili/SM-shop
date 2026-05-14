<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockAlertNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Product $product,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'remaining_stock' => (int) $this->product->stock,
            'minimum_stock' => (int) $this->product->minimum_stock,
            'message' => "Product {$this->product->name} is low in stock. Remaining quantity: {$this->product->stock}",
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Low stock alert for ' . $this->product->name)
            ->line("Product {$this->product->name} is low in stock.")
            ->line('Remaining quantity: ' . $this->product->stock)
            ->line('Minimum stock threshold: ' . $this->product->minimum_stock);
    }
}
