<?php namespace Tests\Repositories;

use App\Models\DeliveryArea;
use App\Repositories\DeliveryAreaRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class DeliveryAreaRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var DeliveryAreaRepository
     */
    protected $deliveryAreaRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->deliveryAreaRepo = \App::make(DeliveryAreaRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_delivery_area()
    {
        $deliveryArea = DeliveryArea::factory()->make()->toArray();

        $createdDeliveryArea = $this->deliveryAreaRepo->create($deliveryArea);

        $createdDeliveryArea = $createdDeliveryArea->toArray();
        $this->assertArrayHasKey('id', $createdDeliveryArea);
        $this->assertNotNull($createdDeliveryArea['id'], 'Created DeliveryArea must have id specified');
        $this->assertNotNull(DeliveryArea::find($createdDeliveryArea['id']), 'DeliveryArea with given id must be in DB');
        $this->assertModelData($deliveryArea, $createdDeliveryArea);
    }

    /**
     * @test read
     */
    public function test_read_delivery_area()
    {
        $deliveryArea = DeliveryArea::factory()->create();

        $dbDeliveryArea = $this->deliveryAreaRepo->find($deliveryArea->id);

        $dbDeliveryArea = $dbDeliveryArea->toArray();
        $this->assertModelData($deliveryArea->toArray(), $dbDeliveryArea);
    }

    /**
     * @test update
     */
    public function test_update_delivery_area()
    {
        $deliveryArea = DeliveryArea::factory()->create();
        $fakeDeliveryArea = DeliveryArea::factory()->make()->toArray();

        $updatedDeliveryArea = $this->deliveryAreaRepo->update($fakeDeliveryArea, $deliveryArea->id);

        $this->assertModelData($fakeDeliveryArea, $updatedDeliveryArea->toArray());
        $dbDeliveryArea = $this->deliveryAreaRepo->find($deliveryArea->id);
        $this->assertModelData($fakeDeliveryArea, $dbDeliveryArea->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_delivery_area()
    {
        $deliveryArea = DeliveryArea::factory()->create();

        $resp = $this->deliveryAreaRepo->delete($deliveryArea->id);

        $this->assertTrue($resp);
        $this->assertNull(DeliveryArea::find($deliveryArea->id), 'DeliveryArea should not exist in DB');
    }
}
