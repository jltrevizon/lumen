<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{

    private User $user;

    protected function setUp(): void
    {

    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function tests_should_return_token()
    {
        $response = $this->call('POST', '/api/auth/signin', ['email' => 'admin@mail.com', 'passsword' => 'password']);
        $this->assertEquals(200, $response->status());
    }
}
