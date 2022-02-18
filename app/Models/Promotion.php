<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory, UsesUuid;

		protected $appends = ['image'];
		protected $fillable = [
			'uuid',
			'title',
			'content',
			'metadata',
    ];


		//Set image attribute
		public function getImageAttribute(){
			$image = File::where('uuid', $this->metadata['image'])->first();
			return $image;
		}

		protected $casts = [
			'metadata'=>'json'
		];
}
