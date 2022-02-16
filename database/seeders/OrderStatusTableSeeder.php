<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			
			$statuses = ['Open','Pending payment','paid','Shipped','Canceled'];
			foreach($statuses as $status){
				OrderStatus::create([
					'title'=>$status
				]);
			}

    }
}
