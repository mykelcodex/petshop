<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
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
}