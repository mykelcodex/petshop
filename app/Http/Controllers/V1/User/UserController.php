<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Support\Str;

class UserController extends Controller
{
	use ApiResponser;

	public function __construct(){
		$this->middleware('auth.user');
	}

	/**
	 * Get authenticated user
	 */

	/**
	 * @OA\Get(
	 *      path="/api/v1/user",
	 *      operationId="getUser",
	 *      tags={"User"},
	 *      summary="View user account",
	 *      description="View user account",
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

	public function getUser(){
		$user = User::find(auth()->id());
		return $this->successResponse($user);
	}


	/**
	 * Delete authenticated user
	 */


	/**
	 * @OA\Delete(
	 *      path="/api/v1/user",
	 *      operationId="deleteUser",
	 *      tags={"User"},
	 *      summary="Delete user account",
	 *      description="Delete user account",
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
	public function deleteUser(){
		$user = User::find(auth()->id());
		$user->delete();
		return $this->successResponse('User deleted successfully');
	}



	/**
	 * User create
	 */

	/**
     * @OA\Post(
     * path="/api/v1/user/create",
     *   tags={"User"},
     *   summary="Create User",
     *   operationId="create-user",
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
			'is_admin'=> 0
		]);

		return $this->successResponse('User created successfully');

	}

	


	/**
	 * Update authenticated user
	 */

	/**
     * @OA\Put(
     * path="/api/v1/user/edit",
     *   tags={"User"},
     *   summary="Edit User",
     *   operationId="Edit-user",
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

	public function editUser(User $user, EditUserRequest $request){
		$user->update([
			'firstname'=>$request->firstname,
			'lastname'=>$request->lastname,
			'email'=>$request->email,
			'password'=>$request->password ? bcrypt($request->password) : bcrypt(Str::random(10)),
			'address'=>$request->address,
			'phone_number'=>$request->phone_number
		]);
		return $this->successResponse('User updated successfully');
	}


}
