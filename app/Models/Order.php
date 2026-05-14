<?php

namespace App\Models;

use App\Support\OrderStatusFlow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Order extends Model
{
    use HasFactory;

    // Status Constants
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_PARTIALLY_ACCEPTED = 'partially_accepted';
    public const STATUS_PREPARING = 'preparing';
    public const STATUS_SHIPPING = 'shipping';
    public const STATUS_DELIVERED = 'delivered';

    protected $fillable = [
        'buyer_id',
        'total_amount',
        'status',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_country',
        'payment_method',
        'ordered_at',
    ];

    protected $casts = [
        'ordered_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    /**
     * The buyer who placed the order
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Items contained within this order
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Formatted status label for UI
     */
    public function getStatusLabelAttribute(): string
    {
        return OrderStatusFlow::meta($this->status)['label'];
    }

    /**
     * Status metadata for consistent badges and helper text.
     *
     * @return array{label:string,badge:string,icon:string,description:string}
     */
    public function getStatusMetaAttribute(): array
    {
        return OrderStatusFlow::meta($this->status);
    }

    /**
     * Tracking timeline progress percentage.
     */
    public function getTrackingProgressAttribute(): int
    {
        return OrderStatusFlow::progress($this->status);
    }

    /**
     * Tracking timeline steps for buyer and seller screens.
     *
     * @return array<int, array{key:string,label:string,state:string}>
     */
    public function getTrackingStepsAttribute(): array
    {
        return OrderStatusFlow::trackingSteps($this->status);
    }

    /**
     * Friendly formatted order number for UI cards.
     */
    public function getOrderNumberAttribute(): string
    {
        return 'SM' . str_pad((string) $this->id, 8, '0', STR_PAD_LEFT);
    }

    /**
     * Sync the aggregate order status from the related item statuses.
     */
    public function syncStatusFromItems(): void
    {
        $statuses = $this->items()
            ->pluck('status')
            ->all();

        $this->update([
            'status' => OrderStatusFlow::aggregate($statuses),
        ]);
    }

    /**
     * Seller-specific items already loaded for the current order.
     *
     * @return Collection<int, OrderItem>
     */
    public function sellerItems(int $sellerId): Collection
    {
        if ($this->relationLoaded('items')) {
            return $this->items
                ->where('seller_id', $sellerId)
                ->values();
        }

        return $this->items()
            ->where('seller_id', $sellerId)
            ->get();
    }

    /**
     * Aggregate status for a single seller's items within a shared order.
     */
    public function sellerStatus(int $sellerId): string
    {
        return OrderStatusFlow::aggregate(
            $this->sellerItems($sellerId)->pluck('status')
        );
    }

    /**
     * Seller-specific status metadata.
     *
     * @return array{label:string,badge:string,icon:string,description:string}
     */
    public function sellerStatusMeta(int $sellerId): array
    {
        return OrderStatusFlow::meta($this->sellerStatus($sellerId));
    }

    /**
     * Seller-specific tracking progress percentage.
     */
    public function sellerTrackingProgress(int $sellerId): int
    {
        return OrderStatusFlow::progress($this->sellerStatus($sellerId));
    }

    /**
     * Seller-specific timeline steps.
     *
     * @return array<int, array{key:string,label:string,state:string}>
     */
    public function sellerTrackingSteps(int $sellerId): array
    {
        return OrderStatusFlow::trackingSteps($this->sellerStatus($sellerId));
    }

    /**
     * Seller actions available for all of their items in this order.
     *
     * @return array<int, string>
     */
    public function sellerAvailableTransitions(int $sellerId): array
    {
        return OrderStatusFlow::availableBatchTransitions(
            $this->sellerItems($sellerId)
        );
    }
}
