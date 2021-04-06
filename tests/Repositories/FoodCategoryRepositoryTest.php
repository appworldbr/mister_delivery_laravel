<?php namespace Tests\Repositories;

use App\Models\FoodCategory;
use App\Repositories\FoodCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FoodCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FoodCategoryRepository
     */
    protected $foodCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->foodCategoryRepo = \App::make(FoodCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_food_category()
    {
        $foodCategory = FoodCategory::factory()->make()->toArray();

        $createdFoodCategory = $this->foodCategoryRepo->create($foodCategory);

        $createdFoodCategory = $createdFoodCategory->toArray();
        $this->assertArrayHasKey('id', $createdFoodCategory);
        $this->assertNotNull($createdFoodCategory['id'], 'Created FoodCategory must have id specified');
        $this->assertNotNull(FoodCategory::find($createdFoodCategory['id']), 'FoodCategory with given id must be in DB');
        $this->assertModelData($foodCategory, $createdFoodCategory);
    }

    /**
     * @test read
     */
    public function test_read_food_category()
    {
        $foodCategory = FoodCategory::factory()->create();

        $dbFoodCategory = $this->foodCategoryRepo->find($foodCategory->id);

        $dbFoodCategory = $dbFoodCategory->toArray();
        $this->assertModelData($foodCategory->toArray(), $dbFoodCategory);
    }

    /**
     * @test update
     */
    public function test_update_food_category()
    {
        $foodCategory = FoodCategory::factory()->create();
        $fakeFoodCategory = FoodCategory::factory()->make()->toArray();

        $updatedFoodCategory = $this->foodCategoryRepo->update($fakeFoodCategory, $foodCategory->id);

        $this->assertModelData($fakeFoodCategory, $updatedFoodCategory->toArray());
        $dbFoodCategory = $this->foodCategoryRepo->find($foodCategory->id);
        $this->assertModelData($fakeFoodCategory, $dbFoodCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_food_category()
    {
        $foodCategory = FoodCategory::factory()->create();

        $resp = $this->foodCategoryRepo->delete($foodCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(FoodCategory::find($foodCategory->id), 'FoodCategory should not exist in DB');
    }
}
