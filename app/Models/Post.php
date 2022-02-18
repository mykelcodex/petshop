<?php

namespace App\Models;

use App\Traits\UsesUuid;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, UsesUuid;
		protected $appends = ['image'];

		protected $fillable = [
			'uuid',
			'title',
			'slug',
			'content',
			'metadata'
    ];

		//Set Image Attribute
		public function getImageAttribute(){
			$image = File::where('uuid', $this->metadata['image'])->first();
			return $image;
		}


		protected $casts = [
			'metadata'=>'json'
		];
}
