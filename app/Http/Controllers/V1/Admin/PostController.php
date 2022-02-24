<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Traits\ApiResponser;
use Illuminate\Support\Str;

class PostController extends Controller
{
  
	use ApiResponser;

	public function __construct(){
		$this->middleware('auth.admin',['except'=>['getPosts','getPost']]);
	}

	/**
	 * Create post
	 */

		 /**
 * @OA\Post(
 *     path="/api/v1/post/create",
 *   	 tags={"Posts"},
 *   	 summary="create Post",
 *   	 operationId="create-post",
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
 *        description = "create a new post",
 *        @OA\JsonContent(
 *             type="object",
 *            @OA\Property(
 *                property="metadata",
 *                type="array",
 *                example={
 *										"author": "string",
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
	public function create(PostRequest $request){
		Post::create([
			'title'=>$request->title,
			'slug'=>Str::slug($request->title),
			'content'=>$request->content,
			'metadata'=>$request->metadata
		]);

		return $this->successResponse('Post created successfully');
	}

	/**
	 * Update post
	 */
			 /**
 * @OA\Put(
 *     path="/api/v1/post/{uuid}",
 *   	 tags={"Posts"},
 *   	 summary="update Post",
 *   	 operationId="update-post",
 *     @OA\Parameter(
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
 *        description = "Update existung post",
 *        @OA\JsonContent(
 *             type="object",
 *            @OA\Property(
 *                property="metadata",
 *                type="array",
 *                example={
 *										"author": "string",
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
	public function edit(PostRequest $request, $uuid){

		$post = Post::where('uuid', $uuid)->first();

		if(!$post){
			return $this->errorResponse('Post not found', 404);
		}

		$post->update([
			'title'=>$request->title,
			'slug'=>Str::slug($request->title),
			'content'=>$request->content,
			'metadata'=>$request->metadata
		]);

		return $this->successResponse('Post updated successfully');
	}



	/**
	 * Get posts
	 */

	 /**
		 * @OA\Get(
		 *      path="/api/v1/posts",
		 *      operationId="getPosts",
		 *      tags={"Posts"},
		 *      summary="Get posts",
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
	public function getPosts(){

		$posts = Post::latest('created_at')->paginate(20);

		return $this->successResponse($posts);
	}


	/**
	 * Get post
	 */

	 /**
		 * @OA\Get(
		 *      path="/api/v1/post/{uuid}",
		 *      operationId="getPost",
		 *      tags={"Posts"},
		 *      summary="Get post",
		 *    @OA\Parameter(
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
	public function getPost($uuid){

		$post = Post::where('uuid', $uuid)->first();

		if(!$post){
			return $this->errorResponse('Post not found', 404);
		}

		return $this->successResponse($post);
	}


	/**
	 * Delete post
	 */
/**
		 * @OA\Delete(
		 *      path="/api/v1/post/{uuid}",
		 *      operationId="getPost",
		 *      tags={"Posts"},
		 *      summary="Get post",
		 *    @OA\Parameter(
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

		$post = Post::where('uuid', $uuid)->first();

		if(!$post){
			return $this->errorResponse('Post not found', 404);
		}

		$post->delete();

		return $this->successResponse('Post deleted successfully');
	}

}
