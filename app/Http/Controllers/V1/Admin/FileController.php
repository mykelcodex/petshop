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
		$this->middleware('auth.admin', ['except'=>['getFiles','getFile']]);
	}


  /**
   * Upload file
   */

  /**
	 * @OA\Post(
	 *      path="/api/v1/file/upload",
	 *      operationId="uploadFile",
	 *      tags={"Files"},
	 *      summary="upload file",
   *     @OA\RequestBody(
   *          required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 allOf={
    *                     @OA\Schema(
    *                         @OA\Property(
    *                             description="File",
    *                             property="file",
    *                             type="string", format="binary"
    *                         )
    *                     )
    *                 }
    *             )
    *         )
    *     ),
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

   /**
	 * @OA\Get(
	 *      path="/api/v1/files",
	 *      operationId="getFiles",
	 *      tags={"Files"},
	 *      summary="Get files",
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
   public function getFiles(){
    $files = File::latest('created_at')->paginate(20); 
    return $this->successResponse($files);
   }


   /**
   * Get file
   */

   /**
	 * @OA\Get(
	 *      path="/api/v1/file/{uuid}",
	 *      operationId="getFile",
	 *      tags={"Files"},
	 *      summary="Get file",
   *      @OA\Parameter(
   * 			     name="uuid",
   * 			     in="path",
   * 			     required=true,
   * 			     @OA\Schema(
   * 			         type="string"
   * 			     )
   * 			  ),
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
  public function getFile($uuid){
    $file = File::where('uuid', $uuid)->first();
    if(!$file){
      return $this->errorResponse('File not found', 404);
    }

    return $this->successResponse($file);
  }

}
