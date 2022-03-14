<?php

use App\Models\Category;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CategoryFilterTest extends TestCase
{
    
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Category::factory(3)->create();
    }

    /** @test */
    public function it_can_filter_by_ids()
    {
        $category = Category::factory()->create();
        $categories = Category::filter(['ids' => [$category->id]])->get();
        $this->assertCount(1, $categories);
    }

    /** @test */
    public function it_can_filter_by_name()
    {
        Category::query()->update(['name' => 'Category 1']);
        $category = Category::factory()->create(['name' => 'Category 2']);
        $categories = Category::filter(['name' => $category->name])->get();
        $this->assertCount(1, $categories);
    }

}
