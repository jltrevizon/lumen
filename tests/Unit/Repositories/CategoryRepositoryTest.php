<?php

use App\Models\Category;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CategoryRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->user = $this->signIn();
    }

    /**@test */
    public function testGetAllCategory()
    {
        $response = $this->json('GET', 'api/categories/getall');
        $response->assertResponseStatus(200);
    }

    /**@test */
    public function testGetCategoryById()
    {
        $response = $this->json('GET', 'api/categories/'.$this->category->id);
        $response->assertResponseStatus(200);
    }

    /**@test */
    public function testCreateCategory()
    {
        $response = $this->json('POST', 'api/categories',[
            'name' => 'Testing',
            'description' => 'Testing'
        ]);
        $response->assertResponseStatus(201);
        $this->seeInDatabase('categories', ['name'=>'Testing']);
    }

    /**@test */
    public function testUpdateCategory()
    {
        $response = $this->json('PUT', 'api/categories/update/'.$this->category->id,[
            'name' => 'Testing update',
            'description' => 'Testing description update'
        ])->assertResponseStatus(200);
        //dd($this->category->id, $this->category->name, $this->category->fresh()->id, $this->category->fresh()->name);

        $this->assertEquals('Testing update', $this->category->fresh()->name);
        $this->seeInDatabase('categories', ['name'=>'Testing update']);
    }

    /**@test */
    public function testDeleteCampa()
    {
        $response = $this->json('DELETE', '/api/categories/delete/'.$this->category->id)->assertResponseStatus(200);

        $this->assertNull($this->category->fresh());
    }
}
