<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, UsesUuid;

		protected $fillable = [
			'category_id',
			'title',
			'uuid',
			'price',
			'description',
			'metadata',
			'deleted_at'
    ];

		protected $casts = [
			'metadata'=>'json'
		];
}
