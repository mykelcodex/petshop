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
			'user_id',
			'type',
			'details'
    ];


		/**
		 * Relationship
		 */
		public function order(){
			return $this->hasOne(Order::class);
		}

		protected $casts = [
			'details'=>'json'
		];
}
