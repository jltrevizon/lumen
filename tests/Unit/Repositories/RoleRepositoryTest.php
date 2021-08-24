<?php

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RoleRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new RoleRepository();
    }

    /** @test */
    public function it_can_create_a_role_correctly()
    {
        $role = Role::factory()->create();
        $request = new Request();
        $request->replace(['description' => $role['description']]);
        $result = $this->createRole($request);
        $this->assertEquals($role['description'], $result['description']);
    }

    /** @test */
    public function should_return_a_role_by_id()
    {
        $role = Role::factory()->create();

        $result = $this->repository->getById($role->id);

        $this->assertEquals($role['description'], $result['description']);
    }

    /** @test */
    public function should_updated_a_role_correctly()
    {
        $description = 'Prueba Update Role';
        $role = Role::factory()->create();
        $request = new Request();
        $request->replace(['description' => $description]);

        $updateCompany = $this->repository->update($request, $role->id);

        $this->assertEquals($description, $updateCompany['role']['description']);
    }

    /** @test */
    public function should_delete_a_role_correctly()
    {
        $role = Role::factory()->create();
        $result = $this->repository->delete($role->id);
        $this->assertEquals('Role deleted', $result['message']);
    }

    private function createRole($data)
    {
        return $this->repository->create($data);
    }

}
