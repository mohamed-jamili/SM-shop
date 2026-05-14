<?php

namespace App\Support;

use App\Models\Product;

class SessionCart
{
    public const KEY = 'cart';

    public static function items(): array
    {
        return session(self::KEY, []);
    }

    public static function add(Product $product, int $quantity = 1): void
    {
        $cart = self::items();
        $existingQuantity = (int) ($cart[$product->id]['quantity'] ?? 0);
        $finalQuantity = min($existingQuantity + $quantity, $product->stock);

        $cart[$product->id] = self::payload($product, $finalQuantity);

        session([self::KEY => $cart]);
    }

    public static function update(Product $product, int $quantity): void
    {
        $cart = self::items();

        if ($quantity <= 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = self::payload($product, min($quantity, $product->stock));
        }

        session([self::KEY => $cart]);
    }

    public static function remove(int $productId): void
    {
        $cart = self::items();
        unset($cart[$productId]);

        session([self::KEY => $cart]);
    }

    public static function clear(): void
    {
        session()->forget(self::KEY);
    }

    public static function count(): int
    {
        return array_sum(array_column(self::items(), 'quantity'));
    }

    public static function total(): float
    {
        return round(array_reduce(self::items(), function (float $carry, array $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0), 2);
    }

    protected static function payload(Product $product, int $quantity): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'category' => $product->category?->name,
            'price' => (float) $product->final_price,
            'original_price' => (float) $product->price,
            'final_price' => (float) $product->final_price,
            'discount' => (float) $product->discount,
            'has_discount' => (bool) $product->has_discount,
            'quantity' => $quantity,
            'stock' => $product->stock,
            'minimum_stock' => $product->minimum_stock,
            'seller_id' => $product->seller_id,
            'image_path' => $product->image_path,
            'image_url' => $product->image_url,
        ];
    }
}
