<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionRequest;
use App\Models\Promotion;
use App\Traits\ApiResponser;

class PromotionController extends Controller
{
  
	use ApiResponser;

	public function __construct(){
		$this->middleware('auth.admin');
	}


	/**
	 * Get all promotions
	 */
	 public function getPromotions(){
			$promotions = Promotion::latest('created_at')->paginate(20);
		 	return $this->successResponse($promotions);
	 }



	 /**
		* Get Promotion
	  */
		public function getPromotion($uuid){
			$promotion = Promotion::where('uuid', $uuid)->first();
			if(!$promotion){
				return $this->successResponse('Promotion not found');
			}

			return $this->successResponse($promotion);
		}



		/**
		* Edit Promotion
	  */
		public function edit(PromotionRequest $request, $uuid){
			$promotion = Promotion::where('uuid', $uuid)->first();
			if(!$promotion){
				return $this->successResponse('Promotion not found');
			}

			$promotion->update([
				'title'=>$request->title,
				'content'=>$request->content,
				'metadata'=>$request->metadata
			]);

			return $this->successResponse('Promotion updated successfully');
		}


		
		/**
		* Create Promotion
	  */
		public function create(PromotionRequest $request){
			Promotion::create([
				'title'=>$request->title,
				'content'=>$request->content,
				'metadata'=>$request->metadata
			]);

			return $this->successResponse('Promotion created successfully');
		}




		/**
		* Delete Promotion
	  */
		public function delete($uuid){
			$promotion = Promotion::where('uuid', $uuid)->first();
			if(!$promotion){
				return $this->successResponse('Promotion not found');
			}

			$promotion->delete();

			return $this->successResponse('Promotion deleted successfully');
		}
}
