<?php

use App\Models\Transport;
use App\Repositories\TransportRepository;
use Illuminate\Http\Request;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TransportRepositoryTest extends TestCase
{

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new TransportRepository();
    }

    /** @test */
    public function it_can_create_a_transport_correctly()
    {
        $name = 'Test Transport';
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->create($request);
        $this->assertInstanceOf(Transport::class, $result);
        $this->assertEquals($name, $result['name']);
    }

    /** @test */
    public function should_return_a_transport_by_id()
    {
        $transport = Transport::factory()->create();
        $result = $this->repository->getById($transport->id);
        $this->assertEquals($transport->id, $result['transport']['id']);
        $this->assertEquals($transport->name, $result['transport']['name']);
    }

    /** @test */
    public function should_updated_a_transport_correctly()
    {
        $transport = Transport::factory()->create();
        $name = 'Test Update Transport';
        $request = new Request();
        $request->replace(['name' => $name]);
        $result = $this->repository->update($request, $transport->id);
        $this->assertEquals($transport->id, $result['transport']['id']);
        $this->assertNotEquals($transport->name, $result['transport']['name']);
        $this->assertEquals($name, $result['transport']['name']);
    }

    /** @test */
    public function should_return_delete_a_transport_correctly()
    {
        $transport = Transport::factory()->create();
        $result = $this->repository->delete($transport->id);
        $this->assertEquals('Transport deleted', $result['message']);
    }

}
