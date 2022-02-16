<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser{
	
	/**
	 * Build success response
	 *
	 * @param $data 
	 * @param $code 
	 *
	 * @return void
	 */
	public function successResponse($data, $code = Response::HTTP_OK){
			return response()->json([
				'data'=>$data,
				'code'=>200
			], $code);
	}
	
	/**
	 * Build error response
	 *
	 * @param $data 
	 * @param $code 
	 *
	 * @return void
	 */
	public function errorResponse($message, $code){
		return response()->json([
			'error'=>[
				'message'=>$message, 
				'code'=>$code
			]
		], $code);
	}
	
}