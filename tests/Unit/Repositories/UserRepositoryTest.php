<?php

use App\Models\User;
use App\Repositories\UserRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private UserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new UserRepository();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function should_return_array_users()
    {
        $request = new stdClass();
        $request->with = [];
        $users = $this->repository->getAll($request);
        info($users);
    }
}
