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
		$this->middleware('auth.admin');
	}

	/**
	 * Create post
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
	public function getPosts(){

		$posts = Post::latest('created_at')->paginate(20);

		return $this->successResponse($posts);
	}


	/**
	 * Get post
	 */
	public function getPost($uuid){

		$post = Post::where('uuid', $uuid)->first();

		if(!$post){
			return $this->errorResponse('Post not found', 404);
		}

		return $this->successResponse($post);
	}


	/**
	 * Get post
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
