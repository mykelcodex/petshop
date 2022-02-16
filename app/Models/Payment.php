<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, UsesUuid;

		protected $fillable = [
			'uuid',
			'type',
			'details'
    ];



		protected $casts = [
			'details'=>'json'
		];
}
