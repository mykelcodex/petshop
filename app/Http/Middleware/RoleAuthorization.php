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
    public function handle(Request $request, Closure $next, $roles)
    {
      
			try {
        
				//Access token from the request        
        $token = JWTAuth::parseToken();

				//Try authenticating user       
				$user = $token->authenticate();

			} catch (TokenExpiredException $e) {

				//Thrown if token has expired    
				return $this->errorResponse('Your token has expired. Please, login again.', $e->getStatusCode());    

			} catch (TokenInvalidException $e) {

				//Thrown if token invalid
				return $this->errorResponse('Your token is invalid. Please, login again.', $e->getStatusCode());    

			}catch (JWTException $e) {

				//Thrown if token was not found in the request.
				return $this->errorResponse('Please, attach a Bearer Token to your request', $e->getStatusCode());    
					
			}
			
			//If user was authenticated successfully and user is in one of the acceptable roles, send to next request.
			if ($user && in_array($user->is_admin, $roles)) {
				return $next($request);
			}

			return $this->errorResponse('Your token is invalid. Please, login again.', 403);    
		}

		
}
