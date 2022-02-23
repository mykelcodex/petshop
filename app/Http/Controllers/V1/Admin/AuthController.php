<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use JWTAuth;

class AuthController extends Controller
{
	use ApiResponser;

	public function __construct(){
		$this->middleware('auth.admin', ['except' => ['login']]);
	}
	
	/**
	 * Authentication user
	*/

	/**
	 * Authentication user
	*/

	 /**
     * @OA\Post(
     * path="/api/v1/admin/login",
     *   tags={"Admin"},
     *   summary="Login as admin",
		 *   description="Login with a valid email and password to retrieve token",
     *   operationId="admin-login",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
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
	 *     )
	 */
	public function login(Request $request){
		$credentials = $request->only(['email', 'password']);

		if (!$token = JWTAuth::attempt($credentials)) {
			return $this->errorResponse('Invalid login details', 400);
		}

		return $this->respondWithToken($token);
	}


	
	/**
	 * Format and respond with token info
	 */
	protected function respondWithToken($token){
		$data = [
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth()->factory()->getTTL() * 60
		];

		return $this->successResponse($data);
	}

	/**
	 * Logout 
	 */

	
	/**
	 * @OA\Get(
	 *      path="/api/v1/admin/logout",
	 *      operationId="admin-logout",
	 *      tags={"Admin"},
	 *      summary="Logout admin",
	 *      description="Logout authenticated admin",
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
	 * 				security={{ "apiAuth": {} }}

	 *     )
	 */
	public function logout(){

			auth()->logout();
			return $this->successResponse('Successfully logged out');

	}
}
