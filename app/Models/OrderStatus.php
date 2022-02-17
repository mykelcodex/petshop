<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory, UsesUuid;

    protected $fillable = [
			'uuid',
			'title',
    ];

		 /**
     * Relationships
     */

		public function orders(){
			return $this->hasMany(Order::class);
		}
}
