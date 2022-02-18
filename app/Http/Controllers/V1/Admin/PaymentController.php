<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use App\Traits\ApiResponser;

class PaymentController extends Controller
{

	use ApiResponser;

  public function __construct(){
		$this->middleware('auth.admin');
	}

	/**
	 * Get Payments
	 */
	public function getPayments(){
		$payments = Payment::latest('created_at')->paginate(20);
		return $this->successResponse($payments);
	}

	/**
	 * Get Payment
	 */
	public function getPayment($uuid){
		$payment = Payment::where('uuid', $uuid)->first();

		if(!$payment){
			return $this->errorResponse('Payment not found', 404);
		}
		
		return $this->successResponse($payment);
	}

	/**
	 * Edit Payment
	 */
	public function edit(PaymentRequest $request, $uuid){

		$payment = Payment::where('uuid', $uuid)->first();

		if(!$payment){
			return $this->errorResponse('Payment not found', 404);
		}

		$payment->update([
			'user_id'=>$request->user_id,
			'type'=>$request->type,
			'details'=>$request->details
		]);
		
		return $this->successResponse('Payment updated successfully');
	}

	/**
	 * Create Payment
	 */
	public function create(PaymentRequest $request){

		Payment::create([
			'user_id'=>$request->user_id,
			'type'=>$request->type,
			'details'=>$request->details
		]);
		
		return $this->successResponse('Payment created successfully');
	}


	/**
	 * Delete Payment
	 */
	public function delete($uuid){
		$payment = Payment::where('uuid', $uuid)->first();

		if(!$payment){
			return $this->errorResponse('Payment not found', 404);
		}

		$payment->delete();
		
		return $this->successResponse('Payment deleted successfully');
	}

}

