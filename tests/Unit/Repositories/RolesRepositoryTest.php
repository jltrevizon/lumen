<?php

use App\Models\Role;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RolesRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->role = Role::factory()->create();
        $this->user = $this->signIn();
    }

    /**@test */
    public function testGetAll()
    {
        $response = $this->json('GET', 'api/roles/getall');
        $response->assertResponseStatus(200);
    }

    /**@test */
    public function testGeRoleById()
    {
        $response = $this->json('GET', 'api/roles/'.rand(7,0));
        $response->assertResponseStatus(200);
    }

    /**@test */
    public function testCreateRole()
    {
        $response = $this->json('POST', 'api/roles',[
            'description' => 'Testing role'
        ]);
        $response->assertResponseStatus(201);
    }

     /**@test */
     public function testUpdateRole()
     {
        $response = $this->json('PUT', 'api/roles/update/'.$this->role->id,[
            'description' => 'Testing description update'
        ])->assertResponseStatus(200);

        $this->assertEquals('Testing description update', $this->role->fresh()->description);
        $this->seeInDatabase('roles', ['description'=>'Testing description update']);
     }

     /**@test */
    public function testDeleteRole()
    {
        $response = $this->json('DELETE', '/api/roles/delete/'.$this->role->id)->assertResponseStatus(200);

        $this->assertNull($this->role->fresh());
    }
}
