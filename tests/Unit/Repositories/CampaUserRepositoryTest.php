<?php

use App\Models\Campa;
use App\Models\CampaUser;
use App\Models\User;
use App\Repositories\CampaUserRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CampaUserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository();
        $this->repository = new CampaUserRepository($this->userRepository);
    }

    /** @test */
    public function should_create_campa_user_correctly()
    {
        $campa1 = Campa::factory()->create();
        $campa2 = Campa::factory()->create();
        $user = User::factory()->create();
        $request = new Request();
        $request->replace([
            'user_id' => $user->id,
            'campas' => [
                    $campa1->id,
                    $campa2->id
            ]
        ]);
        $result = $this->repository->create($request);
        $this->assertCount(Campa::count(), $result['campas']);
        $this->assertEquals($campa1->id, $result['campas'][0]['id']);
        $this->assertEquals($campa2->id, $result['campas'][1]['id']);
    }

    /** @test */
    public function should_delete_campa_user_correctly()
    {
        $campa1 = Campa::factory()->create();
        $campa2 = Campa::factory()->create();
        $user = User::factory()->create();
        $request = new Request();
        $request->replace([
            'user_id' => $user->id,
            'campas' => [
                    $campa1->id,
                    $campa2->id
            ]
        ]);
        $this->repository->create($request);
        $request->replace([
            'user_id' => $user->id,
            'campas' => [
                    $campa1->id
            ]
        ]);
        $result = $this->repository->delete($request);
        $this->assertEquals('campas deleted', $result['message']);
    }

}
