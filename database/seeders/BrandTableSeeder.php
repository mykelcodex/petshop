<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			for($i=0; $i<=60; $i++){
				$title = Str::random(15);
				Brand::create([
					'title'=>$title,
					'slug'=>Str::slug($title)
				]);
			}
    }
}
