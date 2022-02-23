<?php

namespace Tests\Feature\Http\Controller\V1\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class AuthControllerTest extends TestCase
{
	use RefreshDatabase;

	public function test_user_can_login_with_credentials(){
		$user = User::factory()->make([
			'password' => bcrypt($password = 'password'),
		]);

		$response = $this->post('/v1/admin/login', [
				'email' => $user->email,
				'password' => $password,
		]);

		$response->assertStatus(200);
	}


}
