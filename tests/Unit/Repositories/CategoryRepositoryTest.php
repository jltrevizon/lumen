<?php

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CategoryRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CategoryRepository();
    }

    /** @test */
    public function it_can_create_a_category_correctly()
    {
        $name = 'Test category';
        $description = 'Test category';
        $request = new Request();
        $request->replace(['name' => $name, 'description' => $description]);
        $result = $this->createCategory($request);
        $this->assertEquals($result['name'], $name);
        $this->assertEquals($result['description'], $description);
    }

    /** @test */
    public function should_return_two_categories()
    {
        Category::factory()->create();
        Category::factory()->create();
        $request = new Request();
        $request->with = [];
        $result = $this->repository->getAll($request);
        $this->assertCount(2, $result->items());
    }

    /** @test */
    public function should_return_zero_categories()
    {
        $request = new Request();
        $request->with = [];
        $result = $this->repository->getAll($request);
        $this->assertCount(0, $result->items());
    }

    /** @test */
    public function should_return_a_category_by_name()
    {
        $category = Category::factory()->create();
        $result = $this->repository->searchCategoryByName($category['name']);
        $this->assertEquals($category['id'], $result['id']);
        $this->assertEquals($category['name'], $result['name']);
        $this->assertEquals($category['description'], $result['description']);
    }

    /** @test */
    public function should_return_a_category_by_id()
    {
        $category = Category::factory()->create();
        $result = $this->repository->getById($category['id']);
        $this->assertEquals($category['id'], $result['id']);
        $this->assertEquals($category['name'], $result['name']);
        $this->assertEquals($category['description'], $result['description']);
    }

    /** @test */
    public function should_updated_a_category_correctly()
    {
        $name = 'Test Update Category';
        $category = Category::factory()->create();
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->update($request, $category['id']);
        $this->assertEquals($name, $result['category']['name']);
        $this->assertNotEquals($category['name'], $result['category']['name']);
        $this->assertEquals($category['id'], $result['category']['id']);
    }

    private function createCategory($data)
    {
        return $this->repository->create($data);
    }

}
