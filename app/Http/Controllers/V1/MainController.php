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
		public function getPosts(){
			$posts = Post::latest('created_at')->paginate(20);
			return $this->successResponse($posts);
		}


		/**
		 * Get Post
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
		public function getPromotions(){
			$promotions = Promotion::latest('created_at')->paginate(20);
			return $this->successResponse($promotions);
		}


}
