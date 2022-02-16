<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

		protected $fillable = [
			'uuid',
			'type',
			'details'
    ];



		protected $casts = [
			'details'=>'json'
		];
}
