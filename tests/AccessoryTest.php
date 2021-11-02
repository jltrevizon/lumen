<?php

use App\Models\Accessory;
use App\Models\Reception;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccessoryTest extends TestCase
{
    use DatabaseTransactions;

    private Accessory $accessory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accessory = Accessory::factory()->create();
    }
}
