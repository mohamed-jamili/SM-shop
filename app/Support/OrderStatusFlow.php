<?php

namespace App\Support;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Collection;

class OrderStatusFlow
{
    public const TRACKING_STEPS = [
        Order::STATUS_PENDING,
        Order::STATUS_ACCEPTED,
        Order::STATUS_PREPARING,
        Order::STATUS_SHIPPING,
        Order::STATUS_DELIVERED,
    ];

    /**
     * Allowed statuses for the parent orders table.
     *
     * @return array<int, string>
     */
    public static function orderStatuses(): array
    {
        return [
            Order::STATUS_PENDING,
            Order::STATUS_ACCEPTED,
            Order::STATUS_REJECTED,
            Order::STATUS_PARTIALLY_ACCEPTED,
            Order::STATUS_PREPARING,
            Order::STATUS_SHIPPING,
            Order::STATUS_DELIVERED,
        ];
    }

    /**
     * Allowed statuses for order_items.
     *
     * @return array<int, string>
     */
    public static function itemStatuses(): array
    {
        return [
            OrderItem::STATUS_PENDING,
            OrderItem::STATUS_ACCEPTED,
            OrderItem::STATUS_PREPARING,
            OrderItem::STATUS_SHIPPING,
            OrderItem::STATUS_DELIVERED,
            OrderItem::STATUS_REJECTED,
        ];
    }

    /**
     * UI metadata for a given status value.
     *
     * @return array{label:string,badge:string,icon:string,description:string}
     */
    public static function meta(string $status): array
    {
        return match ($status) {
            Order::STATUS_PENDING => [
                'label' => 'Pending',
                'badge' => 'pending',
                'icon' => 'clock-3',
                'description' => 'Waiting for seller validation.',
            ],
            Order::STATUS_ACCEPTED => [
                'label' => 'Accepted',
                'badge' => 'accepted',
                'icon' => 'shield-check',
                'description' => 'The seller accepted the order.',
            ],
            Order::STATUS_PREPARING => [
                'label' => 'Preparing',
                'badge' => 'preparing',
                'icon' => 'package',
                'description' => 'The order is being prepared.',
            ],
            Order::STATUS_SHIPPING => [
                'label' => 'Shipping',
                'badge' => 'shipping',
                'icon' => 'truck',
                'description' => 'Delivery is currently in progress.',
            ],
            Order::STATUS_DELIVERED => [
                'label' => 'Delivered',
                'badge' => 'delivered',
                'icon' => 'check',
                'description' => 'Delivered successfully.',
            ],
            Order::STATUS_REJECTED => [
                'label' => 'Rejected',
                'badge' => 'rejected',
                'icon' => 'x-circle',
                'description' => 'The order was rejected by the seller.',
            ],
            Order::STATUS_PARTIALLY_ACCEPTED => [
                'label' => 'Partially Accepted',
                'badge' => 'partial',
                'icon' => 'package-search',
                'description' => 'Some items were accepted while others were rejected or still awaiting confirmation.',
            ],
            default => [
                'label' => str($status)->replace('_', ' ')->title()->toString(),
                'badge' => 'pending',
                'icon' => 'package-search',
                'description' => 'Order status updated.',
            ],
        };
    }

    /**
     * Parent order status derived from item statuses.
     *
     * @param iterable<int, string> $statuses
     */
    public static function aggregate(iterable $statuses): string
    {
        $uniqueStatuses = collect($statuses)
            ->filter()
            ->values()
            ->unique()
            ->values();

        if ($uniqueStatuses->isEmpty()) {
            return Order::STATUS_PENDING;
        }

        if ($uniqueStatuses->count() === 1) {
            return $uniqueStatuses->first();
        }

        $hasPending = $uniqueStatuses->contains(OrderItem::STATUS_PENDING);
        $hasAccepted = $uniqueStatuses->contains(OrderItem::STATUS_ACCEPTED);
        $hasPreparing = $uniqueStatuses->contains(OrderItem::STATUS_PREPARING);
        $hasShipping = $uniqueStatuses->contains(OrderItem::STATUS_SHIPPING);
        $hasDelivered = $uniqueStatuses->contains(OrderItem::STATUS_DELIVERED);
        $hasRejected = $uniqueStatuses->contains(OrderItem::STATUS_REJECTED);

        if ($hasPending && ! ($hasAccepted || $hasPreparing || $hasShipping || $hasDelivered)) {
            return Order::STATUS_PENDING;
        }

        if ($hasPending) {
            return Order::STATUS_PARTIALLY_ACCEPTED;
        }

        $activeStatuses = $uniqueStatuses
            ->reject(fn (string $status) => $status === OrderItem::STATUS_REJECTED)
            ->values();

        if ($activeStatuses->isEmpty()) {
            return Order::STATUS_REJECTED;
        }

        if ($hasRejected && ! ($hasPreparing || $hasShipping || $hasDelivered) && $activeStatuses->contains(OrderItem::STATUS_ACCEPTED)) {
            return Order::STATUS_PARTIALLY_ACCEPTED;
        }

        $stagePriority = [
            OrderItem::STATUS_ACCEPTED => 1,
            OrderItem::STATUS_PREPARING => 2,
            OrderItem::STATUS_SHIPPING => 3,
            OrderItem::STATUS_DELIVERED => 4,
        ];

        $currentStage = $activeStatuses
            ->sortBy(fn (string $status) => $stagePriority[$status] ?? PHP_INT_MAX)
            ->first();

        return match ($currentStage) {
            OrderItem::STATUS_ACCEPTED => Order::STATUS_ACCEPTED,
            OrderItem::STATUS_PREPARING => Order::STATUS_PREPARING,
            OrderItem::STATUS_SHIPPING => Order::STATUS_SHIPPING,
            OrderItem::STATUS_DELIVERED => Order::STATUS_DELIVERED,
            default => Order::STATUS_PENDING,
        };
    }

    /**
     * Single item transition rules.
     *
     * @return array<int, string>
     */
    public static function allowedItemTransitions(string $currentStatus): array
    {
        return match ($currentStatus) {
            OrderItem::STATUS_PENDING => [
                OrderItem::STATUS_ACCEPTED,
                OrderItem::STATUS_REJECTED,
            ],
            OrderItem::STATUS_ACCEPTED => [
                OrderItem::STATUS_PREPARING,
                OrderItem::STATUS_REJECTED,
            ],
            OrderItem::STATUS_PREPARING => [
                OrderItem::STATUS_SHIPPING,
                OrderItem::STATUS_REJECTED,
            ],
            OrderItem::STATUS_SHIPPING => [
                OrderItem::STATUS_DELIVERED,
            ],
            OrderItem::STATUS_REJECTED => [
                OrderItem::STATUS_ACCEPTED,
            ],
            default => [],
        };
    }

    public static function canTransitionItem(string $currentStatus, string $newStatus): bool
    {
        return in_array($newStatus, self::allowedItemTransitions($currentStatus), true);
    }

    /**
     * Which current item statuses should be updated when the seller changes
     * the status at the order level.
     *
     * @return array<int, string>
     */
    public static function batchSourcesForTarget(string $targetStatus): array
    {
        return match ($targetStatus) {
            OrderItem::STATUS_ACCEPTED => [
                OrderItem::STATUS_PENDING,
                OrderItem::STATUS_REJECTED,
            ],
            OrderItem::STATUS_REJECTED => [
                OrderItem::STATUS_PENDING,
                OrderItem::STATUS_ACCEPTED,
                OrderItem::STATUS_PREPARING,
            ],
            OrderItem::STATUS_PREPARING => [
                OrderItem::STATUS_ACCEPTED,
            ],
            OrderItem::STATUS_SHIPPING => [
                OrderItem::STATUS_PREPARING,
            ],
            OrderItem::STATUS_DELIVERED => [
                OrderItem::STATUS_SHIPPING,
            ],
            default => [],
        };
    }

    /**
     * Order-level actions a seller can take based on their current order items.
     *
     * @param Collection<int, OrderItem> $items
     * @return array<int, string>
     */
    public static function availableBatchTransitions(Collection $items): array
    {
        $statuses = $items->pluck('status')->unique()->values();

        if ($statuses->isEmpty()) {
            return [];
        }

        $hasPending = $statuses->contains(OrderItem::STATUS_PENDING);
        $hasAccepted = $statuses->contains(OrderItem::STATUS_ACCEPTED);
        $hasPreparing = $statuses->contains(OrderItem::STATUS_PREPARING);
        $hasShipping = $statuses->contains(OrderItem::STATUS_SHIPPING);
        $hasDelivered = $statuses->contains(OrderItem::STATUS_DELIVERED);
        $hasRejected = $statuses->contains(OrderItem::STATUS_REJECTED);

        $actions = [];

        if (($hasPending || $hasRejected) && ! ($hasPreparing || $hasShipping || $hasDelivered)) {
            $actions[] = OrderItem::STATUS_ACCEPTED;
        }

        if (($hasPending || $hasAccepted || $hasPreparing) && ! ($hasShipping || $hasDelivered)) {
            $actions[] = OrderItem::STATUS_REJECTED;
        }

        if ($hasAccepted && ! $hasPending && ! ($hasShipping || $hasDelivered)) {
            $actions[] = OrderItem::STATUS_PREPARING;
        }

        if ($hasPreparing && ! ($hasPending || $hasAccepted || $hasDelivered)) {
            $actions[] = OrderItem::STATUS_SHIPPING;
        }

        if ($hasShipping && ! ($hasPending || $hasAccepted || $hasPreparing)) {
            $actions[] = OrderItem::STATUS_DELIVERED;
        }

        return collect($actions)->unique()->values()->all();
    }

    /**
     * Progress bar percentage for timelines.
     */
    public static function progress(string $status): int
    {
        return match ($status) {
            Order::STATUS_PENDING => 8,
            Order::STATUS_ACCEPTED,
            Order::STATUS_PARTIALLY_ACCEPTED => 30,
            Order::STATUS_PREPARING => 55,
            Order::STATUS_SHIPPING => 78,
            Order::STATUS_DELIVERED => 100,
            Order::STATUS_REJECTED => 8,
            default => 8,
        };
    }

    /**
     * Step state data for the tracking timeline.
     *
     * @return array<int, array{key:string,label:string,state:string}>
     */
    public static function trackingSteps(string $status): array
    {
        $effectiveStatus = match ($status) {
            Order::STATUS_PARTIALLY_ACCEPTED => Order::STATUS_ACCEPTED,
            Order::STATUS_REJECTED => Order::STATUS_PENDING,
            default => $status,
        };

        $currentIndex = collect(self::TRACKING_STEPS)->search($effectiveStatus);
        $currentIndex = $currentIndex === false ? 0 : $currentIndex;

        return collect(self::TRACKING_STEPS)
            ->map(function (string $step, int $index) use ($currentIndex): array {
                return [
                    'key' => $step,
                    'label' => self::meta($step)['label'],
                    'state' => $index < $currentIndex ? 'completed' : ($index === $currentIndex ? 'current' : 'upcoming'),
                ];
            })
            ->all();
    }
}
