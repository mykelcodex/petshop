<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, UsesUuid;
		protected $with = ['category'];

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

		protected $casts = [
			'metadata'=>'json'
		];
}
