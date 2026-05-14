<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Support\OrderStatusFlow;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->updateStatusColumn('orders', OrderStatusFlow::orderStatuses(), Order::STATUS_PENDING);
        $this->updateStatusColumn('order_items', OrderStatusFlow::itemStatuses(), OrderItem::STATUS_PENDING);
    }

    public function down(): void
    {
        DB::table('orders')
            ->whereIn('status', [
                Order::STATUS_PREPARING,
                Order::STATUS_SHIPPING,
                Order::STATUS_DELIVERED,
            ])
            ->update(['status' => Order::STATUS_ACCEPTED]);

        DB::table('order_items')
            ->whereIn('status', [
                OrderItem::STATUS_PREPARING,
                OrderItem::STATUS_SHIPPING,
                OrderItem::STATUS_DELIVERED,
            ])
            ->update(['status' => OrderItem::STATUS_ACCEPTED]);

        $this->updateStatusColumn('orders', [
            Order::STATUS_PENDING,
            Order::STATUS_ACCEPTED,
            Order::STATUS_REJECTED,
            Order::STATUS_PARTIALLY_ACCEPTED,
        ], Order::STATUS_PENDING);

        $this->updateStatusColumn('order_items', [
            OrderItem::STATUS_PENDING,
            OrderItem::STATUS_ACCEPTED,
            OrderItem::STATUS_REJECTED,
        ], OrderItem::STATUS_PENDING);
    }

    /**
     * Extend status storage safely on production MySQL while keeping tests runnable on SQLite.
     *
     * @param array<int, string> $statuses
     */
    protected function updateStatusColumn(string $table, array $statuses, string $default): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            $enumValues = implode(', ', array_map(
                static fn (string $status): string => "'" . $status . "'",
                $statuses
            ));

            DB::statement(sprintf(
                'ALTER TABLE `%s` MODIFY COLUMN `status` ENUM(%s) NOT NULL DEFAULT %s',
                $table,
                $enumValues,
                "'" . $default . "'"
            ));

            return;
        }

        Schema::table($table, function (Blueprint $table) use ($default): void {
            $table->string('status')->default($default)->change();
        });
    }
};
