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
    public function should_return_provinces_by_region()
    {
        $region1 = Region::factory()->create();
        $region2 = Region::factory()->create();
        $request = new Request();

        $request->replace(['name' => 'Test province 1', 'province_code' => 'TEST1', 'region_id' => $region1->id]);
        $this->createProvince($request);

        $request->replace(['name' => 'Test province 2', 'province_code' => 'TEST2', 'region_id' => $region1->id]);
        $this->createProvince($request);

        $request->replace(['name' => 'Test province 3', 'province_code' => 'TEST3', 'region_id' => $region2->id]);
        $this->createProvince($request);

        $request->replace(['region_id' => $region1->id]);
        $result = $this->repository->provinceByRegion($request);

        $this->assertCount(2, $result);

        $request->replace(['region_id' => $region2->id]);
        $result = $this->repository->provinceByRegion($request);

        $this->assertCount(1, $result);
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
