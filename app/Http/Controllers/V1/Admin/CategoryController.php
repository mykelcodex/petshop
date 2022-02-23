<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
  
	use ApiResponser;

	public function __construct(){
		$this->middleware('auth.admin', ['except'=>['getCategories','getCategory']]);
	}


	/**
	 * Get categories
	 */

	/**
	 * @OA\Get(
	 *      path="/api/v1/categories",
	 *      operationId="getCategories",
	 *      tags={"Categories"},
	 *      summary="List all categories",
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
	
	 public function getCategories(){
		$brands = Category::latest('created_at')->paginate(20);
		return $this->successResponse($brands);
	 }


	 /**
	 * Create category
	 */

	/**
     * @OA\Post(
     * path="/api/v1/category/create",
     *   tags={"Categories"},
     *   summary="Create Category",
     *   operationId="create-category",
     *
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
	public function create(CategoryRequest $request){

		Category::create([
			'title'=>$request->title,
			'slug'=>Str::slug($request->title)
		]);

		return $this->successResponse('Category created successfully');

	 }


	 /**
	 * Edit category
	 */

	/**
     * @OA\Put(
     * path="/api/v1/category/{uuid}",
     *   tags={"Categories"},
     *   summary="Edit Category",
     *   operationId="edit-category",
     *
     *   @OA\Parameter(
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
	public function edit(CategoryRequest $request, $uuid){

		$brand = Category::where('uuid', $uuid)->first();

		if(!$brand){
			return $this->errorResponse('Category not found', 404);
		}

		$brand->update([
			'title'=>$request->title,
			'slug'=>Str::slug($request->title)
		]);

		return $this->successResponse('Category updated successfully');

	 }


	 /**
	 * Delete category
	 */

	/**
     * @OA\Delete(
     * path="/api/v1/category/{uuid}",
     *   tags={"Categories"},
     *   summary="Delete Category",
     *   operationId="delete-category",
     *
     *   @OA\Parameter(
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

		$brand = Category::where('uuid', $uuid)->first();

		if(!$brand){
			return $this->errorResponse('Category not found', 404);
		}

		$brand->delete();

		return $this->successResponse('Category deleted successfully');

	 }

	 /**
	 * Get category
	 */

	/**
	 * @OA\Get(
	 *      path="/api/v1/category/{uuid}",
	 *      operationId="getCategory",
	 *      tags={"Categories"},
	 *      summary="Fetch single category",
	 *      @OA\Parameter(
   *      name="uuid",
   *     		 in="path",
   *     		 required=true,
   *    		  @OA\Schema(
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
	public function getCategory($uuid){

		$brand = Category::where('uuid', $uuid)->first();

		if(!$brand){
			return $this->errorResponse('Category not found', 404);
		}

		return $this->successResponse($brand);

	 }

}
