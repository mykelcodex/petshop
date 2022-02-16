<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RoleAuthorization
{
		use ApiResponser;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){			

			try {

        //Access token from the request        
					$token = JWTAuth::parseToken();

				//Try authenticating user       
				$user = $token->authenticate();

			} catch (TokenExpiredException $e) {

					//Thrown if token has expired   
					return $this->errorResponse('Your token has expired. Please, login again.', 400);     

			} catch (TokenInvalidException $e) {

					//Thrown if token invalid
					return $this->errorResponse('Your token is invalid. Please, login again.', 400);     

			}catch (JWTException $e) {
					//Thrown if token was not found in the request.
					return $this->errorResponse('Please, attach a Bearer Token to your request', 400);
			}

			//If user was authenticated successfully and user is in one of the acceptable roles, send to next request.
			if ($user && $user->is_admin) {
				return $next($request);
			}

			return $this->errorResponse('You are unauthorized to access this resource', 403);


		}

		
}
