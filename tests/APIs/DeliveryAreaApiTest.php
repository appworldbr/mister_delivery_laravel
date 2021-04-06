<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\DeliveryArea;

class DeliveryAreaApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_delivery_area()
    {
        $deliveryArea = DeliveryArea::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/delivery_areas', $deliveryArea
        );

        $this->assertApiResponse($deliveryArea);
    }

    /**
     * @test
     */
    public function test_read_delivery_area()
    {
        $deliveryArea = DeliveryArea::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/delivery_areas/'.$deliveryArea->id
        );

        $this->assertApiResponse($deliveryArea->toArray());
    }

    /**
     * @test
     */
    public function test_update_delivery_area()
    {
        $deliveryArea = DeliveryArea::factory()->create();
        $editedDeliveryArea = DeliveryArea::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/delivery_areas/'.$deliveryArea->id,
            $editedDeliveryArea
        );

        $this->assertApiResponse($editedDeliveryArea);
    }

    /**
     * @test
     */
    public function test_delete_delivery_area()
    {
        $deliveryArea = DeliveryArea::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/delivery_areas/'.$deliveryArea->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/delivery_areas/'.$deliveryArea->id
        );

        $this->response->assertStatus(404);
    }
}
