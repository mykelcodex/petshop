<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, UsesUuid;

		protected $fillable = [
			'user_id',
			'order_status_id',
			'payment_id',
			'uuid',
			'products',
			'address',
			'delivery_fee',
			'amount',
			'shipped_at'
    ];



		protected $casts = [
			'products'=>'json',
			'address'=>'json'
		];
}
