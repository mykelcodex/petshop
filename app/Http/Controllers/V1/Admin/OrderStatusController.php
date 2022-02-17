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
			$this->middleware('auth.admin');
		}

		/**
		 * Get Order Statuses
		 */
		public function getOrderStatuses(){
			$statuses = OrderStatus::latest('created_at')->paginate(20);
			return $this->successResponse($statuses);
		}


		/**
		 * Get Order Status
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
		public function create(OrderStatusRequest $request){
			
			OrderStatus::create([
				'title'=>$request->title
			]);
			return $this->successResponse('Order status created successfully');
		}

		/**
		 * Edit Order Status
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
