<?php

use App\Models\Order;
use App\Models\TypeModelOrder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TypeModelOrderTest extends TestCase
{

    use DatabaseTransactions;

    private TypeModelOrder $typeModelOrder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->typeModelOrder = TypeModelOrder::factory()->create();
    }

    /** @test */
    public function it_has_many_orders()
    {
        $this->assertInstanceOf(HasMany::class, $this->typeModelOrder->orders());
        $this->assertInstanceOf(Order::class, $this->typeModelOrder->orders()->getModel());
    }
}
