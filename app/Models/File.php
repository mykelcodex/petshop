<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory, UsesUuid;

		protected $fillable = [
			'uuid',
			'name',
			'path',
			'size',
			'type',
    ];
}
