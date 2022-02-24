<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionRequest;
use App\Models\Promotion;
use App\Traits\ApiResponser;

class PromotionController extends Controller
{
  
	use ApiResponser;

	public function __construct(){
		$this->middleware('auth.admin',['except'=>['getPromotions','getPromotion']]);
	}


	/**
	 * Get all promotions
	 */

	 /**
		 * @OA\Get(
		 *      path="/api/v1/promotions",
		 *      operationId="getPromotions",
		 *      tags={"Promotions"},
		 *      summary="Get promotions",
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
	 public function getPromotions(){
			$promotions = Promotion::latest('created_at')->paginate(20);
		 	return $this->successResponse($promotions);
	 }



	 /**
		* Get Promotion
	  */

		/**
		 * @OA\Get(
		 *      path="/api/v1/promotion/{uuid}",
		 *      operationId="getPromotion",
		 *      tags={"Promotions"},
		 *      summary="Get promotion",
		 *      @OA\Parameter(
     *     		 name="uuid",
     *     		 in="path",
     *     		 required=true,
     *     		 @OA\Schema(
     *     		      type="string"
     *     		 )
     *   		),
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
		public function getPromotion($uuid){
			$promotion = Promotion::where('uuid', $uuid)->first();
			if(!$promotion){
				return $this->successResponse('Promotion not found');
			}

			return $this->successResponse($promotion);
		}



		/**
		* Edit Promotion
	  */

			/**
 * @OA\Put(
 *     path="/api/v1/promotion/{uuid}",
 *   	 tags={"Promotions"},
 *   	 summary="update promotion",
 *   	 operationId="update-promotion",
 * 			@OA\Parameter(
*   		   name="uuid",
*   		   in="path",
*   		   required=true,
*   		   @OA\Schema(
*   		        type="string"
*   		   )
*   		),
*			@OA\Parameter(
*   		   name="title",
*   		   in="query",
*   		   required=true,
*   		   @OA\Schema(
*   		        type="string"
*   		   )
*   		),
*				@OA\Parameter(
*   		   name="content",
*   		   in="query",
*   		   required=true,
*   		   @OA\Schema(
*   		        type="string"
*   		   )
*   		),
 *     @OA\RequestBody(
 *        required = true,
 *        description = "update existing promotion",
 *        @OA\JsonContent(
 *             type="object",
 *            @OA\Property(
 *                property="metadata",
 *                type="array",
 *                example={
 *										"valid_from": "YYYY-MM-DD",
 *										"valid_to": "YYYY-MM-DD",
 *										"image": "string",
 *									},
 *                @OA\Items(
 *                      
 *                ),
 *             ),
 * 
 *        ),
 * 			
 *     ),
 *
 *
 *     @OA\Response(
 *        response="200",
 *        description="Successful response",
 *     ),
 * 		@OA\Response(
 *        response="422",
 *        description="Unprocessable Entity",
 *     ),
 *   @OA\Response(
 *        response="403",
 *        description="Forbidden",
 *     ),
 * 		
 * 		security={{ "apiAuth": {} }}
 * )
 */
		public function edit(PromotionRequest $request, $uuid){
			$promotion = Promotion::where('uuid', $uuid)->first();
			if(!$promotion){
				return $this->successResponse('Promotion not found');
			}

			$promotion->update([
				'title'=>$request->title,
				'content'=>$request->content,
				'metadata'=>$request->metadata
			]);

			return $this->successResponse('Promotion updated successfully');
		}


		
		/**
		* Create Promotion
	  */

		/**
 * @OA\Post(
 *     path="/api/v1/promotion/create",
 *   	 tags={"Promotions"},
 *   	 summary="create promotion",
 *   	 operationId="create-promotion",
*			@OA\Parameter(
*   		   name="title",
*   		   in="query",
*   		   required=true,
*   		   @OA\Schema(
*   		        type="string"
*   		   )
*   		),
*				@OA\Parameter(
*   		   name="content",
*   		   in="query",
*   		   required=true,
*   		   @OA\Schema(
*   		        type="string"
*   		   )
*   		),
 *     @OA\RequestBody(
 *        required = true,
 *        description = "create new promotion",
 *        @OA\JsonContent(
 *             type="object",
 *            @OA\Property(
 *                property="metadata",
 *                type="array",
 *                example={
 *										"valid_from": "YYYY-MM-DD",
 *										"valid_to": "YYYY-MM-DD",
 *										"image": "string",
 *									},
 *                @OA\Items(
 *                      
 *                ),
 *             ),
 * 
 *        ),
 * 			
 *     ),
 *
 *
 *     @OA\Response(
 *        response="200",
 *        description="Successful response",
 *     ),
 * 		@OA\Response(
 *        response="422",
 *        description="Unprocessable Entity",
 *     ),
 *   @OA\Response(
 *        response="403",
 *        description="Forbidden",
 *     ),
 * 		
 * 		security={{ "apiAuth": {} }}
 * )
 */
		public function create(PromotionRequest $request){
			Promotion::create([
				'title'=>$request->title,
				'content'=>$request->content,
				'metadata'=>$request->metadata
			]);

			return $this->successResponse('Promotion created successfully');
		}




		/**
		* Delete Promotion
	  */
		/**
		 * @OA\Delete(
		 *      path="/api/v1/promotion/{uuid}",
		 *      operationId="deletePromotion",
		 *      tags={"Promotions"},
		 *      summary="Delete promotion",
		 *      @OA\Parameter(
     *     		 name="uuid",
     *     		 in="path",
     *     		 required=true,
     *     		 @OA\Schema(
     *     		      type="string"
     *     		 )
     *   		),
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
			$promotion = Promotion::where('uuid', $uuid)->first();
			if(!$promotion){
				return $this->successResponse('Promotion not found');
			}

			$promotion->delete();

			return $this->successResponse('Promotion deleted successfully');
		}
}
