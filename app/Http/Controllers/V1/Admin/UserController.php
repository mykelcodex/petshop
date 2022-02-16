<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\AdminCreateUserRequest;
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
	public function create(AdminCreateUserRequest $request){
		
		$user = User::create([
			'firstname'=>$request->firstname,
			'lastname'=>$request->lastname,
			'email'=>$request->email,
			'password'=>$request->password ? bcrypt($request->password) : bcrypt(Str::random(10)),
			'address'=>$request->address,
			'phone_number'=>$request->phone_number
		]);
		
		return $this->successResponse($user);

	}

	/**
	 * List all users
	 */
	public function userListing(){
		$users = User::latest('created_at')->paginate(20);
		return $this->successResponse($users);
	}
		


}
