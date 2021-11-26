<?php

use App\Models\Brand;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BrandFilterTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Brand::factory()->count(3)->create();
    }

    /** @test */
    public function it_can_brand_by_ids()
    {
        $brand = Brand::factory()->create();
        $data = Brand::filter(['ids' => [$brand->id]])->get();
        $this->assertCount(1, $data);
    }

    /** @test */
    public function it_can_brand_by_name()
    {
        Brand::query()->update(['name' => 'Brand 1']);
        $brand = Brand::factory()->create(['name' => 'Brand 2']);
        $data = Brand::filter(['name' => $brand->name])->get();
        $this->assertCount(1, $data);
    }

}
