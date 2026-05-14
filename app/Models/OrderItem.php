<?php

namespace App\Models;

use App\Support\OrderStatusFlow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    // Status Constants
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_PREPARING = 'preparing';
    public const STATUS_SHIPPING = 'shipping';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'order_id',
        'product_id',
        'seller_id',
        'quantity',
        'unit_price',
        'status',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
    ];

    /**
     * The parent order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * The product being ordered
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * The seller who owns this product
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Accessor for item subtotal
     */
    public function getSubtotalAttribute(): float
    {
        return (float) ($this->quantity * $this->unit_price);
    }

    /**
     * Human-readable status label for seller and buyer screens.
     */
    public function getStatusLabelAttribute(): string
    {
        return OrderStatusFlow::meta($this->status)['label'];
    }

    /**
     * Status metadata for seller UI controls.
     *
     * @return array{label:string,badge:string,icon:string,description:string}
     */
    public function getStatusMetaAttribute(): array
    {
        return OrderStatusFlow::meta($this->status);
    }

    public function canTransitionTo(string $status): bool
    {
        return OrderStatusFlow::canTransitionItem($this->status, $status);
    }
}
