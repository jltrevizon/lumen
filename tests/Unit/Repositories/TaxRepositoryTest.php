<?php

use App\Models\Tax;
use App\Repositories\TaxRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TaxRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new TaxRepository();
    }

    /** @test */
    public function should_return_a_tax_by_id()
    {
        $tax = Tax::factory()->create();
        $result = $this->repository->byId($tax->id);
        $this->assertInstanceOf(Tax::class, $result);
        $this->assertEquals($tax->id, $result['id']);
    }
}
