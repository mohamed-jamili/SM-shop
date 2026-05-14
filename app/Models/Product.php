<?php

namespace App\Models;

use App\Notifications\LowStockAlertNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'category_id',
        'name',
        'description',
        'sizes',
        'colors',
        'price',
        'stock',
        'minimum_stock',
        'discount',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'stock' => 'integer',
        'minimum_stock' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * The seller who owns the product
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * The category the product belongs to
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Order items containing this product
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Helper to get image URL
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    /**
     * Current price after applying the product discount.
     */
    public function getFinalPriceAttribute(): float
    {
        $price = (float) $this->price;
        $discount = min(max((float) $this->discount, 0), 100);

        return round($price - ($price * ($discount / 100)), 2);
    }

    /**
     * Human-friendly discount label such as "30" or "12.5".
     */
    public function getDiscountLabelAttribute(): string
    {
        return rtrim(rtrim(number_format((float) $this->discount, 2, '.', ''), '0'), '.');
    }

    /**
     * Whether the product currently has a discount.
     */
    public function getHasDiscountAttribute(): bool
    {
        return (float) $this->discount > 0;
    }

    /**
     * Whether stock reached or dropped below the configured alert threshold.
     */
    public function getIsLowStockAttribute(): bool
    {
        return (int) $this->stock <= (int) $this->minimum_stock;
    }

    /**
     * Send a Laravel notification to the seller when stock is low.
     */
    public function notifySellerAboutLowStock(): void
    {
        if (! $this->seller) {
            $this->loadMissing('seller');
        }

        if ($this->seller && $this->is_low_stock) {
            $this->seller->notify(new LowStockAlertNotification($this));
        }
    }
}
