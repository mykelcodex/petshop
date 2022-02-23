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


	/**
	 * @OA\Get(
	 *      path="/api/v1/user/orders",
	 *      operationId="getOrders",
	 *      tags={"User"},
	 *      summary="Retrieve all user orders",
	 *      description="Retrive all user orders",
		*      @OA\Response(
		*          response=200,
		*          description="Successful operation",
		*       ),
		*      @OA\Response(
		*          response=401,
		*          description="Unauthenticated",
		*      ),
		*		@OA\Response(
		*          response=400,
		*          description="Bad Request",
		*      ),
	 *      @OA\Response(
	 *          response=403,
	 *          description="Forbidden"
	 *      ),
	 * 			security={{ "apiAuth": {} }}
	 *     )
	 */
	public function getOrders(){
		$orders = Order::where('user_id', auth()->id())->paginate(5);
		return $this->successResponse($orders);
	}

}
