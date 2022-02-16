<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
			$faker = \Faker\Factory::create();

			for($i = 1; $i <= 40; $i++){
				User::create([
					'uuid'=>(string)Str::uuid(),
					'firstname'=>$faker->firstNameMale(),
					'lastname'=>$faker->lastName(),
					'is_admin'=>rand(0,1),
					'email'=>$faker->unique()->safeEmail(),
					'password'=>bcrypt('password'),
					'address'=>$faker->streetAddress(),
					'phone_number'=>$faker->phoneNumber(),
					'is_marketing'=>rand(0,1),

				]); 
			
			}

    }
}
