<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			$faker = \Faker\Factory::create();


      for($i=0; $i<=50; $i++){

				$user = User::where('is_admin','!=', 1)->inRandomOrder()->first();	
				Payment::create([
					'user_id'=>$user->id,
					'type'=>'credit_card',
					'details'=>[
						"holder_name"=>$faker->name(),
						"number"=> $faker->phoneNumberWithExtension(),
						"ccv"=> $faker->buildingNumber(),
						"expire_date"=> $faker->date('Y-m-d')
					]
				]);
			}
    }
}
