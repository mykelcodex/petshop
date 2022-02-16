<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, UsesUuid;

		protected $fillable = [
			'uuid',
			'title',
			'slug',
			'content',
			'metadata'
    ];



		protected $casts = [
			'metadata'=>'json'
		];
}
