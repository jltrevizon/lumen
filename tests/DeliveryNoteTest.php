<?php

use App\Models\DeliveryNote;
use App\Models\TypeDeliveryNote;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DeliveryNoteTest extends TestCase
{

    use DatabaseTransactions;

    private DeliveryNote $deliveryNote;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deliveryNote = DeliveryNote::factory()->create();
    }

    /** @test */
    public function it_belongs_to_type_delivery_note()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->deliveryNote->typeDeliveyNote());
        $this->assertInstanceOf(TypeDeliveryNote::class, $this->deliveryNote->typeDeliveyNote()->getModel());
    }

}
