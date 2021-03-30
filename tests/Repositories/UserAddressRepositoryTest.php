<?php namespace Tests\Repositories;

use App\Models\UserAddress;
use App\Repositories\UserAddressRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserAddressRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserAddressRepository
     */
    protected $userAddressRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userAddressRepo = \App::make(UserAddressRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_address()
    {
        $userAddress = UserAddress::factory()->make()->toArray();

        $createdUserAddress = $this->userAddressRepo->create($userAddress);

        $createdUserAddress = $createdUserAddress->toArray();
        $this->assertArrayHasKey('id', $createdUserAddress);
        $this->assertNotNull($createdUserAddress['id'], 'Created UserAddress must have id specified');
        $this->assertNotNull(UserAddress::find($createdUserAddress['id']), 'UserAddress with given id must be in DB');
        $this->assertModelData($userAddress, $createdUserAddress);
    }

    /**
     * @test read
     */
    public function test_read_user_address()
    {
        $userAddress = UserAddress::factory()->create();

        $dbUserAddress = $this->userAddressRepo->find($userAddress->id);

        $dbUserAddress = $dbUserAddress->toArray();
        $this->assertModelData($userAddress->toArray(), $dbUserAddress);
    }

    /**
     * @test update
     */
    public function test_update_user_address()
    {
        $userAddress = UserAddress::factory()->create();
        $fakeUserAddress = UserAddress::factory()->make()->toArray();

        $updatedUserAddress = $this->userAddressRepo->update($fakeUserAddress, $userAddress->id);

        $this->assertModelData($fakeUserAddress, $updatedUserAddress->toArray());
        $dbUserAddress = $this->userAddressRepo->find($userAddress->id);
        $this->assertModelData($fakeUserAddress, $dbUserAddress->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_address()
    {
        $userAddress = UserAddress::factory()->create();

        $resp = $this->userAddressRepo->delete($userAddress->id);

        $this->assertTrue($resp);
        $this->assertNull(UserAddress::find($userAddress->id), 'UserAddress should not exist in DB');
    }
}
