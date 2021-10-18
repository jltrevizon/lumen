<?php

use App\Models\Province;
use App\Models\Region;
use App\Repositories\ProvinceRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProvinceRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ProvinceRepository();
    }

    /** @test */
    public function it_can_create_a_province_correctly()
    {
        $province = Province::factory()->create();
        $request = new Request();
        $request->replace(['name' => $province['name'], 'province_code' => $province['province_code'], 'region_id' => $province['region_id']]);
        $result = $this->createProvince($request);
        $this->assertEquals($province['name'], $result['name']);
    }

    /** @test */
    public function should_return_a_province()
    {
        $province = Province::factory()->create();
        $result = $this->repository->getById($province->id);
        $this->assertEquals($province['id'], $result['province']['id']);
        $this->assertEquals($province['name'], $result['province']['name']);
    }

    /** @test */
    public function should_updated_a_province_correctly()
    {
        $name = 'Test Update Province';
        $province = Province::factory()->create();
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->update($request, $province->id);
        $this->assertEquals($name, $result['province']['name']);
        $this->assertEquals($province['id'], $result['province']['id']);
    }

    /** @test */
    public function should_return_two_provinces()
    {
        Province::factory()->create();
        Province::factory()->create();
        $request = new Request();
        $request->with = [];
        $result = $this->repository->getAll($request);
        $this->assertCount(2, $result->items());
    }

    /** @test */
    public function should_delete_a_province()
    {
        $province = Province::factory()->create();
        $result = $this->repository->delete($province['id']);
        $this->assertEquals('Province deleted', $result['message']);
    }

    private function createProvince($data)
    {
        return $this->repository->create($data);
    }

}
