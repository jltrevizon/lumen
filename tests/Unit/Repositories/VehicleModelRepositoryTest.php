<?php

use App\Models\Brand;
use App\Models\VehicleModel;
use App\Repositories\VehicleModelRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VehicleModelRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new VehicleModelRepository();
    }

    /** @test */
    public function it_can_create_a_vehicle_model_correctly()
    {
        $brand = Brand::factory()->create();
        $model = 'Test Model';
        $result = $this->createVehicleModel($brand['id'], $model);
        $this->assertEquals($brand['id'], $result['brand_id']);
        $this->assertEquals($model, $result['name']);
    }

    /** @test */
    public function should_return_a_vehicle_model_by_name()
    {
        $model = VehicleModel::factory()->create();
        $result = $this->repository->getByNameFromExcel($model['brand_id'], $model['name']);
        $this->assertEquals($model['name'], $result['name']);
    }

    private function createVehicleModel($brandId, $modelName)
    {
        return $this->repository->create($brandId, $modelName);
    }

}
