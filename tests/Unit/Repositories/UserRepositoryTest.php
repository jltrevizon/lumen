<?php

use App\Models\Campa;
use App\Models\CampaUser;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new UserRepository();
    }

    /** @test */
    public function it_can_create_a_user_correctly()
    {
        $name = 'Test User';
        $email = 'testuser@mail.com';
        $password = 'test123';
        $request = new Request();
        $request->replace([
            'name' => $name,
            'password' => $password,
            'email' => $email
        ]);
        $result = $this->repository->create($request);
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($name, $result['name']);
        $this->assertEquals($email, $result['email']);
    }

    /** @test */
    public function should_return_two_users()
    {
        User::factory()->create();
        User::factory()->create();
        $request = new Request();
        $result = $this->repository->getAll($request);
        $this->assertCount(User::count(), $result);
    }

    /** @test */
    public function should_return_zero_users()
    {
        $request = new Request();
        $result = $this->repository->getAll($request);
        $this->assertCount(0, 0);
    }

    /** @test */
    public function should_return_a_user_by_id()
    {
        $user = User::factory()->create();
        $request = new Request();
        $result = $this->repository->getById($request, $user->id);
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user->id, $result['id']);
        $this->assertEquals($user->email, $result['email']);
    }

    /** @test */
    public function should_updated_a_user_correctly()
    {
        $user = User::factory()->create();
        $name = 'Test Update User';
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->update($request, $user->id);
        $this->assertInstanceOf(User::class, $result['user']);
        $this->assertEquals($name, $result['user']['name']);
        $this->assertEquals($user->email, $result['user']['email']);
        $this->assertEquals($user->id, $result['user']['id']);
    }

    /** @test */
    public function should_delete_a_user_correctly()
    {
        $user = User::factory()->create();
        $result = $this->repository->delete($user->id);
        $this->assertEquals('User deleted', $result['message']);
    }

    /** @test */
    public function should_return_users_by_role()
    {
        $campa = Campa::factory()->create();
        $role1 = Role::factory()->create();
        $role2 = Role::factory()->create();
        $user1 = User::factory()->create(['role_id' => $role1->id]);
        $user2 = User::factory()->create(['role_id' => $role1->id]);
        $user3 = User::factory()->create(['role_id' => $role2->id]);
        DB::table('campa_user')->insert(['campa_id' => $campa->id, 'user_id' => $user1->id]);
        DB::table('campa_user')->insert(['campa_id' => $campa->id, 'user_id' => $user2->id]);
        DB::table('campa_user')->insert(['campa_id' => $campa->id, 'user_id' => $user3->id]);

        $request = new Request();
        $request->replace(['campas' => [$campa->id]]);
        $result = $this->repository->getUsersByRole($request, $role1->id);
        $this->assertCount(2, $result);
        $result = $this->repository->getUsersByRole($request, $role2->id);
        $this->assertCount(1, $result);
    }

    /** @test */
    public function should_return_a_user_by_email()
    {
        $user = User::factory()->create();
        $result = $this->repository->getUserByEmail($user->email);
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user->id, $result['id']);
        $this->assertEquals($user->email, $result['email']);
    }
}
