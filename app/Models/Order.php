<?php

namespace App\Models;

use App\Models\Product;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, UsesUuid;

		protected $with = ['order_status'];

		protected $fillable = [
			'user_id',
			'order_status_id',
			'payment_id',
			'uuid',
			'inv_no',
			'products',
			'address',
			'delivery_fee',
			'amount',
			'shipped_at'
    ];

		 /**
     * Relationships
     */

		public function user(){
			return $this->belongsTo(User::class);
		}

		public function order_status(){
			return $this->belongsTo(OrderStatus::class);
		}

		public function payment(){
			return $this->belongsTo(Payment::class);
		}


		//Get total price of products
		public function getTotalProductPrice($products){
			$prices = [];

			foreach($products as $product){
				array_push($prices, $product['product']['price'] * $product['quantity']);
			}

			$price = array_sum($prices);
			
			return $price;

		}

		protected $casts = [
			'products'=>'json',
			'address'=>'json'
		];
}
