<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use App\Support\OrderStatusFlow;
use PHPUnit\Framework\TestCase;

class OrderStatusFlowTest extends TestCase
{
    public function test_it_keeps_pending_orders_pending_until_any_item_is_accepted(): void
    {
        $status = OrderStatusFlow::aggregate([
            OrderItem::STATUS_PENDING,
            OrderItem::STATUS_REJECTED,
        ]);

        $this->assertSame(Order::STATUS_PENDING, $status);
    }

    public function test_it_marks_mixed_accepted_and_rejected_items_as_partially_accepted(): void
    {
        $status = OrderStatusFlow::aggregate([
            OrderItem::STATUS_ACCEPTED,
            OrderItem::STATUS_REJECTED,
        ]);

        $this->assertSame(Order::STATUS_PARTIALLY_ACCEPTED, $status);
    }

    public function test_it_can_progress_partially_accepted_orders_into_tracking_statuses(): void
    {
        $status = OrderStatusFlow::aggregate([
            OrderItem::STATUS_PREPARING,
            OrderItem::STATUS_REJECTED,
        ]);

        $this->assertSame(Order::STATUS_PREPARING, $status);
    }

    public function test_it_uses_the_earliest_active_tracking_step_as_the_parent_status(): void
    {
        $status = OrderStatusFlow::aggregate([
            OrderItem::STATUS_DELIVERED,
            OrderItem::STATUS_SHIPPING,
        ]);

        $this->assertSame(Order::STATUS_SHIPPING, $status);
    }
}
