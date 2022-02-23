<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Promotion;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class MainController extends Controller
{
	
		use ApiResponser;

		/**
		 * Get Posts
		 */

		/**  @OA\Get(
	 *      path="/api/v1/main/blog",
	 *      operationId="getPosts",
	 *      tags={"MainPage"},
	 *      summary="Get posts",
	 *      description="Fetch all posts",
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
		 * Get Post
		 */

		/**  @OA\Get(
		 *      path="/api/v1/main/blog/{uuid}",
		 *      operationId="getPost",
		 *      tags={"MainPage"},
		 *      summary="Get post",
		 *      description="Fetch individual post",
		 * 			@OA\Parameter(
		*  			    name="uuid",
		*  			    in="path",
		*  			    required=true,
		*  			    @OA\Schema(
		*  			         type="string"
		*  			    )
		*  			 ),
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
		 * Get Promotions
		 */

		/**  @OA\Get(
	 *      path="/api/v1/main/promotions",
	 *      operationId="getPromotions",
	 *      tags={"MainPage"},
	 *      summary="Get Promotions",
	 *      description="Fetch all promotions",
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


}
