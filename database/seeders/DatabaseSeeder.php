<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            UserTableSeeder::class,
            BrandTableSeeder::class,
            CategoryTableSeeder::class,
            OrderStatusTableSeeder::class,
            FileTableSeeder::class,
            ProductTableSeeder::class,
            PaymentTableSeeder::class,
            OrderTableSeeder::class,
            PostTableSeeder::class,
            PromotionTableSeeder::class,
        ]);
    }
}
