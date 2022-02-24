<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Traits\ApiResponser;

class ProductController extends Controller
{

	use ApiResponser;

	public function __construct(){
		$this->middleware('auth.admin', ['except'=>['getProducts','getProduct']]);
	}

	/**
	 * Get all products
	 */

	
	/**
	 * @OA\Get(
	 *      path="/api/v1/products",
	 *      operationId="getProducts",
	 *      tags={"Products"},
	 *      summary="Get Products",
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
	public function getProducts(){
		$products = Product::latest('created_at')->paginate();
		return $this->successResponse($products);
	}


	/**
	 * Get product
	 */
	/**
	 * @OA\Get(
	 *      path="/api/v1/product/{uuid}",
	 *      operationId="getProduct",
	 *      tags={"Products"},
	 *      summary="Get product",
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
	public function getProduct($uuid){
		$product = Product::where('uuid', $uuid)->first();

		if(!$product){
			return $this->errorResponse('Product not found', 404);
		}
	
		return $this->successResponse($product);
	}


	/**
	 * Create product
	 */

	/**
 * @OA\Post(
 *     path="/api/v1/product/create",
 *   	 tags={"Products"},
 *   	 summary="create product",
 *   	 operationId="create-product",
*			@OA\Parameter(
*   		   name="category_id",
*   		   in="query",
*   		   required=true,
*   		   @OA\Schema(
*   		        type="integer"
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
*   		   name="price",
*   		   in="query",
*   		   required=true,
*   		   @OA\Schema(
*   		        type="string"
*   		   )
*   		),
*				@OA\Parameter(
*   		   name="description",
*   		   in="query",
*   		   required=true,
*   		   @OA\Schema(
*   		        type="string"
*   		   )
*   		),
 *     @OA\RequestBody(
 *        required = true,
 *        description = "create new product",
 *        @OA\JsonContent(
 *             type="object",
 *            @OA\Property(
 *                property="metadata",
 *                type="array",
 *                example={
 *										"brand": "string",
 *										"image": "string"
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
	public function create(ProductRequest $request){
		Product::create([
			'category_id'=>$request->category_id,
			'title'=>$request->title,
			'price'=>$request->price,
			'description'=>$request->description,
			'metadata'=>$request->metadata
		]);
		return $this->successResponse('Product created');
	}


	/**
	 * Edit product
	 */

/**
 * @OA\Put(
 *     path="/api/v1/product/{uuid}",
 *   	 tags={"Products"},
 *   	 summary="update product",
 *   	 operationId="update-product",
 *     @OA\Parameter(
*   		   name="uuid",
*   		   in="path",
*   		   required=true,
*   		   @OA\Schema(
*   		        type="string"
*   		   )
*   		),
*			@OA\Parameter(
*   		   name="category_id",
*   		   in="query",
*   		   required=true,
*   		   @OA\Schema(
*   		        type="integer"
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
*   		   name="price",
*   		   in="query",
*   		   required=true,
*   		   @OA\Schema(
*   		        type="string"
*   		   )
*   		),
*				@OA\Parameter(
*   		   name="description",
*   		   in="query",
*   		   required=true,
*   		   @OA\Schema(
*   		        type="string"
*   		   )
*   		),
 *     @OA\RequestBody(
 *        required = true,
 *        description = "Update existung products",
 *        @OA\JsonContent(
 *             type="object",
 *            @OA\Property(
 *                property="metadata",
 *                type="array",
 *                example={
 *										"brand": "string",
 *										"image": "string"
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
	public function edit(ProductRequest $request, $uuid){
		$product = Product::where('uuid', $uuid)->first();

		if(!$product){
			return $this->errorResponse('Product not found', 404);
		}
		$product->update([
			'category_id'=>$request->category_id,
			'title'=>$request->title,
			'price'=>$request->price,
			'description'=>$request->description,
			'metadata'=>$request->metadata
		]);
		return $this->successResponse('Product updated successfully');
	}



	/**
	 * Delete product
	 */
	/**
	 * Get product
	 */
	/**
	 * @OA\Delete(
	 *      path="/api/v1/product/{uuid}",
	 *      operationId="deleteProduct",
	 *      tags={"Products"},
	 *      summary="Delete product",
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
		$product = Product::where('uuid', $uuid)->first();
		$product->delete();
		return $this->successResponse('Product deleted successfully');
	}


}
