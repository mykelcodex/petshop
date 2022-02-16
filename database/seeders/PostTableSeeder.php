<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostTableSeeder extends Seeder
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
				$title = Str::random(15);
				$file = File::inRandomOrder()->first();	
				Post::create([
					'title'=>$title,
					'slug'=>Str::slug($title),
					'content'=>$faker->sentence(),
					'metadata'=>[
						'author'=>$faker->name(),
						'image'=>$file->uuid
					],
				]);
				
			}
    }
}
