<?php

use App\Models\User;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }


    /**
     * Helper for signing in a user.
     *
     * @param null $user
     * @param string|null $guard
     * @return User
     */
    protected function signIn($user = null, string $guard = null) : User
    {
        /** @var User $user */
        $user = $user ?: User::factory()->create();

        $this->actingAs($user, $guard);

        return $user;
    }
}
