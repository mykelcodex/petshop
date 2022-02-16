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
		$this->middleware('auth.admin');
	}


	/**
	 * Get brands
	 */
	 public function getBrands(){
		$brands = Brand::latest('created_at')->paginate(20);
		return $this->successResponse($brands);
	 }


	 /**
	 * Create brand
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
	public function getBrand($uuid){

		$brand = Brand::where('uuid', $uuid)->first();

		if(!$brand){
			return $this->errorResponse('Brand not found', 404);
		}

		return $this->successResponse($brand);

	 }


}
