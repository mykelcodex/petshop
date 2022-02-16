<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
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
				Category::create([
					'title'=>$title,
					'slug'=>Str::slug($title)
				]);
			}

    }
}
