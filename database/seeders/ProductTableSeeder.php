<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
			for($i=0; $i<=50; $i++){
				
				$faker = \Faker\Factory::create();
				$category = Category::inRandomOrder()->first();	
				$brand = Brand::inRandomOrder()->first();	
				$file = File::inRandomOrder()->first();	
				Product::create([
					'category_id'=>$category->id,
					'title'=>Str::random(15),
					'price'=>rand(1000, 30000),
					'description'=>Str::random(20),
					'metadata'=>[
						'brand'=>$brand->uuid,
						'image'=>$file->uuid
					],
				]);
				
			}

    }
}
