<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_let_a_user_login()
    {
        // setup
        $user = User::factory()
            ->create([
                'password' => '123'
            ]);

        // action
        $data = $this->post('api/auth/signin', [
            'password' => '123',
            'email' => $user->email
        ], ['content-type' => 'application/x-www-form-urlencoded', 'accept' => 'application/json'])->response;

        // assertion
        dd($data);
    }
}
