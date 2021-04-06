<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFoodCategoryAPIRequest;
use App\Http\Requests\API\UpdateFoodCategoryAPIRequest;
use App\Models\FoodCategory;
use App\Repositories\FoodCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FoodCategoryController
 * @package App\Http\Controllers\API
 */

class FoodCategoryAPIController extends AppBaseController
{
    /** @var  FoodCategoryRepository */
    private $foodCategoryRepository;

    public function __construct(FoodCategoryRepository $foodCategoryRepo)
    {
        $this->foodCategoryRepository = $foodCategoryRepo;
    }

    /**
     * Display a listing of the FoodCategory.
     * GET|HEAD /foodCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $foodCategories = $this->foodCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($foodCategories->toArray(), 'Food Categories retrieved successfully');
    }

    /**
     * Store a newly created FoodCategory in storage.
     * POST /foodCategories
     *
     * @param CreateFoodCategoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFoodCategoryAPIRequest $request)
    {
        $input = $request->all();

        $foodCategory = $this->foodCategoryRepository->create($input);

        return $this->sendResponse($foodCategory->toArray(), 'Food Category saved successfully');
    }

    /**
     * Display the specified FoodCategory.
     * GET|HEAD /foodCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FoodCategory $foodCategory */
        $foodCategory = $this->foodCategoryRepository->find($id);

        if (empty($foodCategory)) {
            return $this->sendError('Food Category not found');
        }

        return $this->sendResponse($foodCategory->toArray(), 'Food Category retrieved successfully');
    }

    /**
     * Update the specified FoodCategory in storage.
     * PUT/PATCH /foodCategories/{id}
     *
     * @param int $id
     * @param UpdateFoodCategoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFoodCategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var FoodCategory $foodCategory */
        $foodCategory = $this->foodCategoryRepository->find($id);

        if (empty($foodCategory)) {
            return $this->sendError('Food Category not found');
        }

        $foodCategory = $this->foodCategoryRepository->update($input, $id);

        return $this->sendResponse($foodCategory->toArray(), 'FoodCategory updated successfully');
    }

    /**
     * Remove the specified FoodCategory from storage.
     * DELETE /foodCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FoodCategory $foodCategory */
        $foodCategory = $this->foodCategoryRepository->find($id);

        if (empty($foodCategory)) {
            return $this->sendError('Food Category not found');
        }

        $foodCategory->delete();

        return $this->sendSuccess('Food Category deleted successfully');
    }
}
