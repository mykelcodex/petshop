<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;

class AuthController extends Controller
{

	public function login(Request $request){
			$credentials = $request->only(['email', 'password']);

			if (!$token = JWTAuth::attempt($credentials)) {
				return 'Invalid login details';
			}

			return $token;
	}
}
