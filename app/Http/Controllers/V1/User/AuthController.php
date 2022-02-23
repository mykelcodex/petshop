<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JWTAuth;

class AuthController extends Controller
{

	
	use ApiResponser;

	public function __construct(){
		$this->middleware('auth.user', ['only' => ['logout']]);
	}

	/**
	 * Authentication user
	*/

	 /**
     * @OA\Post(
     * path="/api/v1/user/login",
     *   tags={"User"},
     *   summary="Login as user",
		 *   description="Login with a valid email and password to retrieve token",
     *   operationId="login",
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
	 *      path="/api/v1/user/logout",
	 *      operationId="logout",
	 *      tags={"User"},
	 *      summary="Logout user",
	 *      description="Logout authenticated user",
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


	/**
	 * Forgot password
	 */

	/**
     * @OA\Post(
     * path="/api/v1/user/forgot-password",
     *   tags={"User"},
     *   summary="User forgot password",
		 *   description="Create token to reset password",
     *   operationId="forgot-password",
     *
     *   @OA\Parameter(
     *      name="email",
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
	 *     )
	 */

	public function forgotPassword(ForgotPasswordRequest $request){

		$user = User::where('email', $request->email)->first();

		if(!$user){
			return $this->errorResponse('User not found', 401);
		}

		$code = Str::random(6);

		$user->update([
			'code'=>$code
		]);

		/**
		 * Send email to user
		 */

		 return $this->successResponse('Check your email for further instruction');

	}


	/**
	 * Reset password
	 */

	 	/**
     * @OA\Post(
     * path="/api/v1/user/reset-password-token",
     *   tags={"User"},
     *   summary="Reset password",
		 *   description="Use created token to reset user password",
     *   operationId="reset-password",
     *
     *   @OA\Parameter(
     *      name="code",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
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
     *           type="string"
     *      )
     *   ),
		 *    @OA\Parameter(
     *      name="password_confirmation",
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
	 *     )
	 */
	public function resetPassword(ResetPasswordRequest $request){

		$user = User::where('email', $request->email)->where('code', $request->code)->first();

		if(!$user){
			return $this->errorResponse('Invalid code', 401);
		}


		$user->update([
			'code'=>null,
			'password'=>bcrypt($request->password)
		]);

		return $this->successResponse('Password successfully changed');

	}


}
