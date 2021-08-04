<?php
use App\Models\Campa;
use App\Models\Role;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->campa = Campa::factory()->create();
        $this->role = Role::factory()->create();
        $this->user = $this->signIn();
    }

    /**test */
    public function testGetAll()
    {
        $response = $this->json('GET', 'api/users/getall');
        $response->assertResponseStatus(200);
    }

    /**test */
    public function testGetUserByid()
    {
        $user = User::factory()->create();
        $response = $this->json('GET', 'api/users/'.$user->id);
        $response->assertResponseStatus(200);
    }

    /**test */
    public function testCreateUser()
    {
        $response = $this->json('POST', 'api/users', [
            'name' => 'prueba',
            'email' => 'prueba@mail.com',
            'password' => 'password'
        ]);
        $response->assertResponseStatus(201);
    }

    /**test */
    public function testCreateUserWithoutPassword()
    {
        $response = $this->json('POST', 'api/users/create-without-password', [
            'name' => 'prueba',
            'email' => 'prueba@mail.com',
        ]);
        $response->assertResponseStatus(201);
    }

    /**@test */
    public function testUpdateUser()
    {
        $response = $this->json('PUT', 'api/users/update/'.$this->user->id, [
            'name' => 'Testing update',
        ])->assertResponseStatus(200);

        $this->assertEquals('Testing update', $this->user->fresh()->name);
        $this->seeInDatabase('users', ['name'=>'Testing update']);
    }

    /**@test */
    public function testDeleteuser()
    {
        $user = User::factory()->create();
        $response = $this->json('DELETE', 'api/users/delete/'.$user->id)->assertResponseStatus(200);
        $this->assertNull($user->fresh());
    }

    /**@test */
    public function testGetUsersByCampa()
    {
        $response = $this->json('GET', 'api/users/campa/'.$this->campa->id)->assertResponseStatus(200);
    }

    /**@test */
    public function testGetUsersByRole()
    {
        $response = $this->json('POST', 'api/users/role/1')->assertResponseStatus(200);
    }

    /**@test */
    public function testGetUsersActive()
    {
        $response = $this->json('POST', 'api/users/active',[
            'campa_id' => $this->campa->id
        ])->assertResponseStatus(200);
    }

    /**@test */
    public function testGetUsersByEmail()
    {
        $response = $this->json('POST', 'api/users/by-email',[
            'email' => 'admin@mail.com',
        ])->assertResponseStatus(200);
    }

    /**@test */
    public function testUsersAssignCampa()
    {
        $response = $this->json('POST', 'api/users/assign-campa',[
            'campas' => [$this->campa->id],
            'user_id' => $this->user->id
        ])->assertResponseStatus(201);
    }

    /**@test */
    public function testUsersDeleteCampa()
    {
        $response = $this->json('POST', 'api/users/delete-campa',[
            'campas' => [$this->campa->id],
            'user_id' => $this->user->id
        ])->assertResponseStatus(200);

    }
}

