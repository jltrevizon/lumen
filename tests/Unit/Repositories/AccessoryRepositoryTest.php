<?php

use App\Models\Accessory;
use App\Models\Reception;
use App\Repositories\AccessoryRepository;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccessoryRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new AccessoryRepository();
    }

}
