<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CategorySeeder::class);

        User::factory()->seller()->create([
            'name' => 'Seller Demo',
            'email' => 'seller@example.com',
        ]);

        User::factory()->buyer()->create([
            'name' => 'Buyer Demo',
            'email' => 'buyer@example.com',
        ]);
    }
}
