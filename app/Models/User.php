<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_BUYER = 'buyer';
    public const ROLE_SELLER = 'seller';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'shop_name',
        'phone',
        'address',
        'city',
        'postal_code',
        'country',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user is a buyer
     */
    public function isBuyer(): bool
    {
        return $this->role === self::ROLE_BUYER;
    }

    /**
     * Check if user is a seller
     */
    public function isSeller(): bool
    {
        return $this->role === self::ROLE_SELLER;
    }

    /**
     * Products owned by the seller
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    /**
     * Orders placed by the buyer
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    /**
     * Order items assigned to the seller (cached for easy dashboard access)
     */
    public function sellerOrderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'seller_id');
    }
}
