<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use App\Models\File;
use App\Traits\FileUploadService;
use App\Traits\ApiResponser;

class FileController extends Controller
{
  
  use ApiResponser, FileUploadService;


  public function __construct(){
		$this->middleware('auth.admin');
	}


  /**
   * Upload file
   */
   public function upload(UploadRequest $request){
    
   $file = $this->uploadFile($request->file, 'pet-shop');
    
   $savedFile = File::create([
    'name'=>$file['name'],
    'type'=>$file['type'],
    'size'=>$file['size'],
    'path'=>$file['path']
   ]);

    return $this->successResponse(['uuid'=>$savedFile->uuid]);

   }


   /**
   * Get files
   */
   public function getFiles(){
    $files = File::latest('created_at')->paginate(20); 
    return $this->successResponse($files);
   }


   /**
   * Get file
   */
  public function getFile($uuid){
    $file = File::where('uuid', $uuid)->first();
    if(!$file){
      return $this->errorResponse('File not found', 404);
    }

    return $this->successResponse($file);
  }

}
