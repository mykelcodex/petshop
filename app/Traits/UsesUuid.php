<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;


trait UsesUuid{
    protected static function bootUsesUuid(){
			static::creating(function($model) {
				$model->uuid = Uuid::uuid4();
			});
    }
}