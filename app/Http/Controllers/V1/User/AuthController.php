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
		$this->middleware('auth.user', ['except' => ['login']]);
	}

	/**
	 * Authentication user
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
	public function logout(){

		auth()->logout();
		return $this->successResponse('Successfully logged out');

	}


	/**
	 * Forgot password
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
