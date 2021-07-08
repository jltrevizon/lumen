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
    public function it_tests_should_receive_a_200_in_home_status()
    {
        $response = $this->call('GET','/');
        $this->assertEquals(200, $response->status());
    }
}
