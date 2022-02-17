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
		$this->middleware('auth.admin');
	}

	/**
	 * Get all products
	 */
	public function getProducts(){
		$products = Product::latest('created_at')->paginate();
		return $this->successResponse($products);
	}

	
	/**
	 * Get product
	 */
	public function getProduct($uuid){
		$product = Product::where('uuid', $uuid)->first();

		if($product){
			return $this->errorResponse('Product not found', 404);
		}
	
		return $this->successResponse($product);
	}


	/**
	 * Create product
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
	public function edit(ProductRequest $request, $uuid){
		$product = Product::where('uuid', $uuid)->first();

		if(!$product){
			return $this->errorResponse('Product not found', 404);
		}
		$product->update([
			'category_uuid'=>$request->category_uuid,
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
	public function delete($uuid){
		$product = Product::where('uuid', $uuid)->first();
		$product->delete();
		return $this->successResponse('Product deleted successfully');
	}


}
