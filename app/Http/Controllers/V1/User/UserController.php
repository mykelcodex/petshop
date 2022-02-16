<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
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
	public function getUser(){
		$user = User::find(auth()->id());
		return $this->successResponse($user);
	}


	/**
	 * Delete authenticated user
	 */
	public function deleteUser(){
		$user = User::find(auth()->id());
		$user->delete();
		return $this->successResponse('User deleted successfully');
	}


	/**
	 * Update authenticated user
	 */
	public function editUser(User $user, EditUserRequest $request){
		$user = User::find(auth()->id());
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
