<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
	public function __construct(){
		$this->middleware('auth.user');
	}


}
