<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class OrderController extends Controller
{

	use ApiResponser;

	public function __construct(){
		$this->middleware('auth.user');
	}


	/**
	 * Get user orders
	 */
	public function getOrders(){
		$orders = Order::where('user_id', auth()->id())->paginate(5);
		return $this->successResponse($orders);
	}

}
