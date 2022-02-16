<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			for($i=0; $i<=60; $i++){
				$user = User::where('is_admin','!=', 1)->inRandomOrder()->first();	
				$orderStatus = OrderStatus::inRandomOrder()->first();	
				$payment = Payment::inRandomOrder()->first();	
				$product = Product::inRandomOrder()->first();
				$faker = \Faker\Factory::create();
	
				Order::create([
					'user_id'=>$user->id,
					'order_status_id'=>$orderStatus->id,
					'payment_id'=>$payment->id,
					'products'=>[
						'product'=>$product->uuid,
						'quantity'=>rand(1,20)
					],
					'address'=>[
						'billing'=>$faker->address(),
						'shipping'=>$faker->address()
					],
					'amount'=>rand(1000, 20000)
				]);
			}
    }
}
