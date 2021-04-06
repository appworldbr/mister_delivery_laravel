<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FoodCategory;

class FoodCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_food_category()
    {
        $foodCategory = FoodCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/food_categories', $foodCategory
        );

        $this->assertApiResponse($foodCategory);
    }

    /**
     * @test
     */
    public function test_read_food_category()
    {
        $foodCategory = FoodCategory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/food_categories/'.$foodCategory->id
        );

        $this->assertApiResponse($foodCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_food_category()
    {
        $foodCategory = FoodCategory::factory()->create();
        $editedFoodCategory = FoodCategory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/food_categories/'.$foodCategory->id,
            $editedFoodCategory
        );

        $this->assertApiResponse($editedFoodCategory);
    }

    /**
     * @test
     */
    public function test_delete_food_category()
    {
        $foodCategory = FoodCategory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/food_categories/'.$foodCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/food_categories/'.$foodCategory->id
        );

        $this->response->assertStatus(404);
    }
}
