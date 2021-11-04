<?php

use App\Models\Color;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ColorTest extends TestCase
{
    
    use DatabaseTransactions;

    private Color $color;

    protected function setUp(): void
    {
        parent::setUp();
        $this->color = Color::factory()->create();
    }

    /** @test */
    public function it_has_many_vehicles()
    {
        $this->assertInstanceOf(HasMany::class, $this->color->vehicles());
        $this->assertInstanceOf(Vehicle::class, $this->color->vehicles()->getModel());
    }

}
