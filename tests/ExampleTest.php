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
        // $user = User::factory()
        //     ->create([
        //         'password' => '123'
        //     ]);

        // action
        $this->get('/')
            ->equalTo('API');
        //$this->assertEquals

        // assertion

    }
}
