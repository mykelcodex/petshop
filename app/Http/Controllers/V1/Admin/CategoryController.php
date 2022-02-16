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
		$this->middleware('auth.admin');
	}


	/**
	 * Get categories
	 */
	 public function getCategories(){
		$brands = Category::latest('created_at')->paginate(20);
		return $this->successResponse($brands);
	 }


	 /**
	 * Create category
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
	public function getCategory($uuid){

		$brand = Category::where('uuid', $uuid)->first();

		if(!$brand){
			return $this->errorResponse('Category not found', 404);
		}

		return $this->successResponse($brand);

	 }

}
