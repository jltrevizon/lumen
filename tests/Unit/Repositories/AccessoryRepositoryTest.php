<?php

use App\Models\Accessory;
use App\Models\Reception;
use App\Repositories\AccessoryRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccessoryRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new AccessoryRepository();
    }

    /** @test */
    public function should_create_accessories_correctly()
    {
        $accessories = [
            ['name' => 'Accessory 1'],
            ['name' => 'Accessory 2'],
            ['name' => 'Accessory 3'],
        ];
        $reception = Reception::factory()->create();
        $result = $this->repository->create($reception->id, $accessories);
        $this->assertEquals('Accessories created!', $result['message']);
    }

    /** @test */
    public function should_two_accessories()
    {
        Accessory::factory()->create();
        Accessory::factory()->create();
        $result = $this->repository->getAll();
        $this->assertCount(2, $result);
    }
}
