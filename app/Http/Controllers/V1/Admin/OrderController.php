<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Traits\ApiResponser;
use Barryvdh\DomPDF\Facade as PDF;

class OrderController extends Controller
{
	
	public function __construct(){
		$this->middleware('auth.admin');
	}

	use ApiResponser;

	/**
	 * Get Orders
	 */

	 /**
	 * Get brands
	 */

	 /**
	 * @OA\Get(
	 *      path="/api/v1/orders",
	 *      operationId="getOrders",
	 *      tags={"Orders"},
	 *      summary="Get Orders",
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
		$orders = Order::latest('created_at')->paginate(20);
		return $this->successResponse($orders);
	}


	/**
	 * Create Order
	 */

	/**
     * @OA\Post(
     * path="/api/v1/order/create",
     *   tags={"Orders"},
     *   summary="Create Order",
     *   operationId="create-order",
	 *	  @OA\Parameter(
     *      name="order_status_uuid",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *  	    )
     *  	 ),
	 *  	@OA\Parameter(
     *  	    name="payment_uuid",
     *  	    in="query",
     *  	    required=true,
     *  	    @OA\Schema(
     *  	         type="string"
     *  	    )
     *  	 ),
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
	public function create(OrderRequest $request){

		$products  = [];

		foreach($request->products as $item){
			$instance = Product::where('uuid', $item['product'])->first();
			array_push($products, ['product'=>$instance,'quantity'=>$item['quantity']]);
		}

		$order = Order::create([
			'user_id'=>$request->user_id,
			'order_status_id'=>$request->order_status_id,
			'payment_id'=>$request->payment_id,
			'products'=>$products,
			'address'=>$request->address,
			'delivery_fee'=>$request->delivery_fee ?? null,
			'amount'=>$request->amount,
			'inv_no'=>'#'.str_pad($this->randNum() + 1, 8, "0", STR_PAD_LEFT)
		]);

		return $this->successResponse($order);
	}


	/**
	 * Get Order
	 */

		/**
	 * @OA\Get(
	 *      path="/api/v1/order/{uuid}",
	 *      operationId="getOrder",
	 *      tags={"Orders"},
	 *      summary="Get Order",
	 * 			@OA\Parameter(
   * 			     name="uuid",
   * 			     in="path",
   * 			     required=true,
   * 			     @OA\Schema(
   * 			          type="string"
   * 			     )
   * 			  ),
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
	public function getOrder($uuid){
		$order = Order::where('uuid', $uuid)->first();
		
		if(!$order){
			return $this->errorResponse('Order not found', 404);
		}

		return $this->successResponse($order);
	}






	/**
	 * Edit Order
	 */

	 /**
     * @OA\Put(
     * path="/api/v1/order",
     *   tags={"Orders"},
     *   summary="Update Order",
     *   operationId="update-order",
		 *  @OA\Parameter(
     *      name="order_status_uuid",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
		 *  @OA\Parameter(
     *      name="payment_uuid",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
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

	public function edit(OrderRequest $request, $uuid){
		$order = Order::where('uuid', $uuid)->first();
		
		if(!$order){
			return $this->errorResponse('Order not found', 404);
		}

		$order->update([
			'order_status_id'=>$request->order_status_id,
			'payment_id'=>$request->payment_id,
			'products'=>$request->products,
			'address'=>$request->address,
			'delivery_fee'=>$request->delivery_fee ?? null,
			'amount'=>$request->amount
		]);

		return $this->successResponse('Order updated successfully');
	}


	/**
	 * Delete Order
	 */
		/**
	 * @OA\Delete(
	 *      path="/api/v1/order/{uuid}",
	 *      operationId="deleteOrder",
	 *      tags={"Orders"},
	 *      summary="Delete Order",
	 * 			@OA\Parameter(
   * 			     name="uuid",
   * 			     in="path",
   * 			     required=true,
   * 			     @OA\Schema(
   * 			          type="string"
   * 			     )
   * 			  ),
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
	public function delete($uuid){
		$order = Order::where('uuid', $uuid)->first();
		
		if(!$order){
			return $this->errorResponse('Order not found', 404);
		}

		$order->delete();

		return $this->successResponse('Order deleted successfully');
	}
	

	/**
	 * Download Order
	 */

	 	/**
	 * @OA\Get(
	 *      path="/api/v1/order/{uuid}/download",
	 *      operationId="downlaodOrder",
	 *      tags={"Orders"},
	 *      summary="Download Order",
	 * 			@OA\Parameter(
   * 			     name="uuid",
   * 			     in="path",
   * 			     required=true,
   * 			     @OA\Schema(
   * 			          type="string"
   * 			     )
   * 			  ),
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


	public function download($uuid){
		$order = Order::with(['user','payment'])->where('uuid', $uuid)->first();
		
		if(!$order){
			return $this->errorResponse('Order not found', 404);
		}

		$pdf = PDF::loadView('pdf.invoice',['order'=>$order]);

    return $pdf->download($order->order_uuid.'.pdf');


	}

	//Geneate random invoice number
	public static function randNum($length = 10){
			$pool = '0123456789';

			return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
	}

}
