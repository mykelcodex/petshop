<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
	
	use ApiResponser;

	public function __construct(){
		$this->middleware('auth.admin', ['except'=>['getBrands','getBrand']]);
	}


	/**
	 * Get brands
	 */

	 /**
	 * @OA\Get(
	 *      path="/api/v1/brands",
	 *      operationId="getBrands",
	 *      tags={"Brands"},
	 *      summary="Get brands",
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

	 public function getBrands(){
		$brands = Brand::latest('created_at')->paginate(20);
		return $this->successResponse($brands);
	 }


	 /**
	 * Create brand
	 */

	/**
	 * @OA\Post(
	 *      path="/api/v1/brand/create",
	 *      operationId="createBrand",
	 *      tags={"Brands"},
	 *      summary="Create brand",
	 *   @OA\Parameter(
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
	public function create(BrandRequest $request){

		Brand::create([
			'title'=>$request->title,
			'slug'=>Str::slug($request->title)
		]);

		return $this->successResponse('Brand created successfully');

	 }


	 /**
	 * Edit brand
	 */

	/**
	 * @OA\Put(
	 *      path="/api/v1/brand/{uuid}",
	 *      operationId="editBrand",
	 *      tags={"Brands"},
	 *      summary="Edit brand",
	 *   @OA\Parameter(
   *      name="uuid",
   *      in="path",
   *      required=true,
   *      @OA\Schema(
   *           type="string"
   *      )
   *   ),
	 *  @OA\Parameter(
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
	public function edit(BrandRequest $request, $uuid){

		$brand = Brand::where('uuid', $uuid)->first();

		if(!$brand){
			return $this->errorResponse('Brand not found', 404);
		}

		$brand->update([
			'title'=>$request->title,
			'slug'=>Str::slug($request->title)
		]);

		return $this->successResponse('Brand updated successfully');

	 }


	 /**
	 * Delete brand
	 */

	/**
	 * @OA\Delete(
	 *      path="/api/v1/brand/{uuid}",
	 *      operationId="deleteBrand",
	 *      tags={"Brands"},
	 *      summary="Delete brand",
	 * 	@OA\Parameter(
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

		$brand = Brand::where('uuid', $uuid)->first();

		if(!$brand){
			return $this->errorResponse('Brand not found', 404);
		}

		$brand->delete();

		return $this->successResponse('Brand deleted successfully');

	 }

	 /**
	 * Get brand
	 */
	/**
	 * @OA\Get(
	 *      path="/api/v1/brand/{uuid}",
	 *      operationId="getBrand",
	 *      tags={"Brands"},
	 *      summary="Get brand",
	 *    @OA\Parameter(
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
	public function getBrand($uuid){

		$brand = Brand::where('uuid', $uuid)->first();

		if(!$brand){
			return $this->errorResponse('Brand not found', 404);
		}

		return $this->successResponse($brand);

	 }


}
