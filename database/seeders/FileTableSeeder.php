<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			for($i=0; $i<=50; $i++){
				File::create([
					'name'=>Str::random(36),
					'path'=>Str::random(36),
					'size'=>rand(1000, 30000),
					'type'=>'jpg',
				]);
				
			}
    }
}
