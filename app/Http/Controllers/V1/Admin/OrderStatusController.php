<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStatusRequest;
use App\Models\OrderStatus;
use App\Traits\ApiResponser;

class OrderStatusController extends Controller
{

		use ApiResponser;

		public function __construct(){
			$this->middleware('auth.admin', ['except'=>['getOrderStatuses','getOrderStatus']]);
		}

		/**
		 * Get Order Statuses
		 */

		/**
		 * @OA\Get(
		 *      path="/api/v1/order-statuses",
		 *      operationId="getOrderStatuses",
		 *      tags={"Order Statuses"},
		 *      summary="Get order statuses",
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
		*     )
		*/
		public function getOrderStatuses(){
			$statuses = OrderStatus::latest('created_at')->paginate(20);
			return $this->successResponse($statuses);
		}


		/**
		 * Get Order Status
		 */
		/**
		 * @OA\Get(
		 *      path="/api/v1/order-status/{uuid}",
		 *      operationId="getOrderStatus",
		 *      tags={"Order Statuses"},
		 *      summary="Get order status",
		 * @OA\Parameter(
     *      name="uuid",
     *      in="path",
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
		*     )
		*/
		public function getOrderStatus($uuid){
			$status = OrderStatus::where('uuid', $uuid)->first();
			if(!$status){
				return $this->errorResponse('Order status not found', 404);
			}
			return $this->successResponse($status);
		}


		/**
		 * Delete Order Status
		 */
		/**
		 * @OA\Delete(
		 *      path="/api/v1/order-status/{uuid}",
		 *      operationId="deleteOrderStatus",
		 *      tags={"Order Statuses"},
		 *      summary="Delete order status",
		 * @OA\Parameter(
     *      name="uuid",
     *      in="path",
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
		public function delete($uuid){
			$status = OrderStatus::where('uuid', $uuid)->first();

			if(!$status){
				return $this->errorResponse('Order status not found', 404);
			}

			$status->delete();

			return $this->successResponse('Order status deleted successfully');
		}


		/**
		 * Create Order Status
		 */
		/**
		 * @OA\Post(
		 *      path="/api/v1/order-status/create",
		 *      operationId="createOrderStatus",
		 *      tags={"Order Statuses"},
		 *      summary="Create order status",
		 * @OA\Parameter(
     *      name="title",
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
		public function create(OrderStatusRequest $request){
			
			OrderStatus::create([
				'title'=>$request->title
			]);
			return $this->successResponse('Order status created successfully');
		}

		/**
		 * Edit Order Status
		 */
		/**
		 * @OA\Put(
		 *      path="/api/v1/order-status/{uuid}",
		 *      operationId="editOrderStatus",
		 *      tags={"Order Statuses"},
		 *      summary="Edit order status",
		 * @OA\Parameter(
     *      name="uuid",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
		 * @OA\Parameter(
     *      name="title",
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
		public function edit(OrderStatusRequest $request, $uuid){
			$status = OrderStatus::where('uuid', $uuid)->first();

			if(!$status){
				return $this->errorResponse('Order status not found', 404);
			}

			$status->update([
				'title'=>$request->title
			]);

			return $this->successResponse('Order status updated successfully');
		}

}
