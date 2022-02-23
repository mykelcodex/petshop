<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\CreateUserRequest;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
	
	use ApiResponser;

	public function __construct(){
		$this->middleware('auth.admin');
	}

	/**
	 * Create a new user
	 */

	/**
     * @OA\Post(
     * path="/api/v1/admin/create",
     *   tags={"Admin"},
     *   summary="Create User by admin",
     *   operationId="create-admin-user",
     *
     *   @OA\Parameter(
     *      name="firstname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
		 * @OA\Parameter(
     *      name="lastname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
		 * @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
		 * @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
		 * @OA\Parameter(
     *      name="password_confirmation",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="avatar",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
		 * @OA\Parameter(
     *      name="address",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
		 * @OA\Parameter(
     *      name="phone_number",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
		 * @OA\Parameter(
     *      name="is_marketing",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
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
	public function create(CreateUserRequest $request){
		
		User::create([
			'firstname'=>$request->firstname,
			'lastname'=>$request->lastname,
			'email'=>$request->email,
			'password'=>$request->password ? bcrypt($request->password) : bcrypt(Str::random(10)),
			'address'=>$request->address,
			'phone_number'=>$request->phone_number,
			'is_admin'=> $request->is_admin ?? 1
		]);
		
		return $this->successResponse('User created successfully');

	}

	/**
	 * List all users
	 */

	 /**
	 * @OA\Get(
	 *      path="/api/v1/admin/user-listing",
	 *      operationId="userListing",
	 *      tags={"Admin"},
	 *      summary="List all users",
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

	public function userListing(){
		$users = User::latest('created_at')->paginate(20);
		return $this->successResponse($users);
	}
		
/**  @OA\Delete(
 *      path="/api/v1/admin/user-delete/{uuid}",
 *      operationId="deleteUserAccount",
 *      tags={"Admin"},
 *      summary="Delete user account",
 *      description="Delete user account",
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
	* 			security={{ "apiAuth": {} }}
	*     )
	*/
	
	public function deleteUserAccount($uuid){
		$user = User::where('uuid', $uuid)->first();
		if(!$user){
			return $this->successResponse('User not found');
		}

		//Delete user
		$user->delete();

		return $this->successResponse('User deleted successfully');
	}

}
