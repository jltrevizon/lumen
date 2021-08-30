<?php

use App\Models\DefleetVariable;
use App\Models\User;
use App\Repositories\DefleetVariableRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DefleetVariableRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository();
        $this->repository = new DefleetVariableRepository($this->userRepository);
    }

    /** @test */
    public function it_can_create_a_defleet_variable_correctly()
    {
        $kms = 120000;
        $years = 6;
        $user = User::factory()->create();
        $this->actingAs($user);
        $request = new Request();
        $request->replace(['kms' => $kms, 'years' => $years]);
        $result = $this->repository->createVariables($request);
        $this->assertEquals($user['company_id'], $result['company_id']);
        $this->assertEquals($kms, $result['kms']);
        $this->assertEquals($years, $result['years']);
        $this->assertInstanceOf(DefleetVariable::class, $result);
    }

    /** @test */
    public function should_return_a_defleet_variable()
    {
        $user = User::factory()->create();
        $defleetVariable = DefleetVariable::factory()->create(['company_id' => $user['company_id']]);
        $this->actingAs($user);
        $request = new Request();
        $result = $this->repository->getVariables($request);
        $this->assertEquals($defleetVariable['company_id'], $result['company_id']);
        $this->assertEquals($defleetVariable['kms'], $result['kms']);
        $this->assertEquals($defleetVariable['years'], $result['years']);
        $this->assertInstanceOf(DefleetVariable::class, $result);
    }

    /** @test */
    public function should_return_a_defleet_variable_by_company()
    {
        $user = User::factory()->create();
        $defleetVariable = DefleetVariable::factory()->create(['company_id' => $user['company_id']]);
        $this->actingAs($user);
        $result = $this->repository->getVariablesByCompany($user['company_id']);
        $this->assertEquals($defleetVariable['id'], $result['id']);
        $this->assertEquals($defleetVariable['company_id'], $result['company_id']);
        $this->assertEquals($defleetVariable['kms'], $result['kms']);
        $this->assertEquals($defleetVariable['years'], $result['years']);
        $this->assertInstanceOf(DefleetVariable::class, $result);
    }

    /** @test */
    public function should_updated_a_defleet_variable_correctly()
    {
        $user = User::factory()->create();
        $kms = 150000;
        $years = 10;
        $defleetVariable = DefleetVariable::factory()->create(['company_id' => $user['company_id']]);
        $this->actingAs($user);
        $request = new Request();
        $request->replace(['kms' => $kms, 'years' => $years]);
        $result = $this->repository->updateVariables($request);
        $this->assertEquals($defleetVariable['id'], $result['variables']['id']);
        $this->assertEquals($defleetVariable['company_id'], $result['variables']['company_id']);
        $this->assertEquals($kms, $result['variables']['kms']);
        $this->assertEquals($years, $result['variables']['years']);
    }
}
