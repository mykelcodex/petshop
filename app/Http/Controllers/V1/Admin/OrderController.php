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
	public function getOrders(){
		$orders = Order::latest('created_at')->paginate(20);
		return $this->successResponse($orders);
	}


	/**
	 * Create Order
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
	public function getOrder($uuid){
		$order = Order::where('uuid', $uuid)->first();
		
		if(!$order){
			return $this->errorResponse('Order not found', 404);
		}

		return $this->successResponse('Order created successfully');
	}


	/**
	 * Edit Order
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
	 * Get Order
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
