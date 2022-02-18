<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, UsesUuid;
		protected $with = ['category'];
		protected $appends = ['image','brand'];

		protected $fillable = [
			'category_id',
			'title',
			'uuid',
			'price',
			'description',
			'metadata',
			'deleted_at'
    ];
		

		//Relationship
		public function category(){
			return $this->belongsTo(Category::class);
		}

		//Set image Attribute
		public function getImageAttribute(){
			$image = File::where('uuid', $this->metadata['image'])->first();
			return $image;
		}

		//Set brand attribute
		public function getBrandAttribute(){
			$image = Brand::where('uuid', $this->metadata['brand'])->first();
			return $image;
		}

		//Cast fields
		protected $casts = [
			'metadata'=>'json'
		];
}
