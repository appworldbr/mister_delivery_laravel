<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserAddress;

class UserAddressApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_address()
    {
        $userAddress = UserAddress::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user_addresses', $userAddress
        );

        $this->assertApiResponse($userAddress);
    }

    /**
     * @test
     */
    public function test_read_user_address()
    {
        $userAddress = UserAddress::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/user_addresses/'.$userAddress->id
        );

        $this->assertApiResponse($userAddress->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_address()
    {
        $userAddress = UserAddress::factory()->create();
        $editedUserAddress = UserAddress::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user_addresses/'.$userAddress->id,
            $editedUserAddress
        );

        $this->assertApiResponse($editedUserAddress);
    }

    /**
     * @test
     */
    public function test_delete_user_address()
    {
        $userAddress = UserAddress::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user_addresses/'.$userAddress->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user_addresses/'.$userAddress->id
        );

        $this->response->assertStatus(404);
    }
}
