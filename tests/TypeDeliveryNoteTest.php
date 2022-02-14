<?php

use App\Models\DeliveryNote;
use App\Models\TypeDeliveryNote;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TypeDeliveryNoteTest extends TestCase
{
    
    use DatabaseTransactions;

    private TypeDeliveryNote $typeDeliveryNote;

    protected function setUp(): void
    {
        parent::setUp();
        $this->typeDeliveryNote = TypeDeliveryNote::factory()->create();
    }

    /** @test */
    public function it_has_many_delivery_notes()
    {
        $this->assertInstanceOf(HasMany::class, $this->typeDeliveryNote->deliveryNotes());
        $this->assertInstanceOf(DeliveryNote::class, $this->typeDeliveryNote->deliveryNotes()->getModel());
    }

}
