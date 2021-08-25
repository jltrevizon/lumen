<?php

use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BrandRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new BrandRepository();
    }

    /** @test */
    public function it_can_create_a_brand_correctly()
    {
        $brand = Brand::factory()->create();
        $result = $this->repository->create($brand['name']);
        $this->assertEquals($brand['name'], $result['name']);
        $this->assertNotEquals($brand['id'], $result['id']);
    }

    /** @test */
    public function should_return_two_brands()
    {
        Brand::factory()->create();
        Brand::factory()->create();
        $request = new Request();
        $result = $this->repository->getAll($request);
        $this->assertCount(2, $result['brands']);
    }

    /** @test */
    public function should_return_zero_brands()
    {
        $request = new Request();
        $result = $this->repository->getAll($request);
        $this->assertCount(0, $result['brands']);
    }

    /** @test */
    public function should_return_brand_by_name()
    {
        $brand = Brand::factory()->create();
        $result = $this->repository->getByNameFromExcel($brand['name']);
        $this->assertEquals($brand['name'], $result['name']);
        $this->assertEquals($brand['id'], $result['id']);
    }

    /** @test */
    public function should_return_a_brand_by_id()
    {
        $brand = Brand::factory()->create();
        $request = new Request();
        $result = $this->repository->getById($request, $brand['id']);
        $this->assertEquals($brand['name'], $result['brand']['name']);
        $this->assertEquals($brand['id'], $result['brand']['id']);
    }

    private function createBrand($data)
    {
        return $this->repository->create($data);
    }
}
