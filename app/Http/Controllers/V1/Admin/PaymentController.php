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

	/**
	 * @OA\Get(
	 *      path="/api/v1/payments",
	 *      operationId="getPayments",
	 *      tags={"Payments"},
	 *      summary="Get payments",
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
	public function getPayments(){
		$payments = Payment::latest('created_at')->paginate(20);
		return $this->successResponse($payments);
	}

	/**
	 * Get Payment
	 */

	/**
	 * @OA\Get(
	 *      path="/api/v1/payment/{uuid}",
	 *      operationId="getPayment",
	 *      tags={"Payments"},
	 *      summary="Get payment",
	 * 			@OA\Parameter(
   * 			     name="uuid",
   * 			     in="path",
   * 			     required=true,
   * 			     @OA\Schema(
   * 			         type="string"
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

	 /**
	 * @OA\Delete(
	 *      path="/api/v1/payment/{uuid}",
	 *      operationId="deletePayment",
	 *      tags={"Payments"},
	 *      summary="Delete payment",
	 * 			@OA\Parameter(
   * 			     name="uuid",
   * 			     in="path",
   * 			     required=true,
   * 			     @OA\Schema(
   * 			         type="string"
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
		$payment = Payment::where('uuid', $uuid)->first();

		if(!$payment){
			return $this->errorResponse('Payment not found', 404);
		}

		$payment->delete();
		
		return $this->successResponse('Payment deleted successfully');
	}

}

