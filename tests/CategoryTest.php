<?php

use App\Models\Category;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{

    use DatabaseTransactions;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function it_has_many_vehicles()
    {
        $this->assertInstanceOf(HasMany::class, $this->category->vehicles());
        $this->assertInstanceOf(Vehicle::class, $this->category->vehicles()->getModel());
    }

}
