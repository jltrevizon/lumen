<?php

use App\Models\Region;
use App\Repositories\RegionRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RegionRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new RegionRepository();
    }

    /** @test */
    public function it_can_create_a_region_correctly()
    {
        $region = Region::factory()->create();
        $request = new Request();
        $request->replace(['name' => $region['name']]);
        $result = $this->repository->create($request);
        $this->assertEquals($region['name'], $result['name']);
    }

    /** @test */
    public function should_return_a_region_by_id()
    {
        $region = Region::factory()->create();
        $result = $this->repository->getById($region['id']);
        $this->assertEquals($region['name'], $result['name']);
        $this->assertEquals($region['id'], $result['id']);
    }

    /** @test */
    public function should_updated_a_region_correctly()
    {
        $name = 'Test Updated Region';
        $region = Region::factory()->create();
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->update($request, $region['id']);
        $this->assertEquals($name, $result['region']['name']);
    }

    /** @test */
    public function should_delete_a_region()
    {
        $region = Region::factory()->create();
        $result = $this->repository->delete($region['id']);
        $this->assertEquals('Region deleted', $result['message']);
    }

    private function createRegion($data)
    {
        return $this->repository->create($data);
    }

}
