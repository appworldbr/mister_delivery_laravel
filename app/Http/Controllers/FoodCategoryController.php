<?php

namespace App\Http\Controllers;

use App\DataTables\FoodCategoryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFoodCategoryRequest;
use App\Http\Requests\UpdateFoodCategoryRequest;
use App\Repositories\FoodCategoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class FoodCategoryController extends AppBaseController
{
    /** @var  FoodCategoryRepository */
    private $foodCategoryRepository;

    public function __construct(FoodCategoryRepository $foodCategoryRepo)
    {
        $this->foodCategoryRepository = $foodCategoryRepo;
    }

    /**
     * Display a listing of the FoodCategory.
     *
     * @param FoodCategoryDataTable $foodCategoryDataTable
     * @return Response
     */
    public function index(FoodCategoryDataTable $foodCategoryDataTable)
    {
        return $foodCategoryDataTable->render('food_categories.index');
    }

    /**
     * Show the form for creating a new FoodCategory.
     *
     * @return Response
     */
    public function create()
    {
        return view('food_categories.create');
    }

    /**
     * Store a newly created FoodCategory in storage.
     *
     * @param CreateFoodCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateFoodCategoryRequest $request)
    {
        $input = $request->all();

        $foodCategory = $this->foodCategoryRepository->create($input);

        Flash::success('Food Category saved successfully.');

        return redirect(route('foodCategories.index'));
    }

    /**
     * Display the specified FoodCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $foodCategory = $this->foodCategoryRepository->find($id);

        if (empty($foodCategory)) {
            Flash::error('Food Category not found');

            return redirect(route('foodCategories.index'));
        }

        return view('food_categories.show')->with('foodCategory', $foodCategory);
    }

    /**
     * Show the form for editing the specified FoodCategory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $foodCategory = $this->foodCategoryRepository->find($id);

        if (empty($foodCategory)) {
            Flash::error('Food Category not found');

            return redirect(route('foodCategories.index'));
        }

        return view('food_categories.edit')->with('foodCategory', $foodCategory);
    }

    /**
     * Update the specified FoodCategory in storage.
     *
     * @param  int              $id
     * @param UpdateFoodCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFoodCategoryRequest $request)
    {
        $foodCategory = $this->foodCategoryRepository->find($id);

        if (empty($foodCategory)) {
            Flash::error('Food Category not found');

            return redirect(route('foodCategories.index'));
        }

        $foodCategory = $this->foodCategoryRepository->update($request->all(), $id);

        Flash::success('Food Category updated successfully.');

        return redirect(route('foodCategories.index'));
    }

    /**
     * Remove the specified FoodCategory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $foodCategory = $this->foodCategoryRepository->find($id);

        if (empty($foodCategory)) {
            Flash::error('Food Category not found');

            return redirect(route('foodCategories.index'));
        }

        $this->foodCategoryRepository->delete($id);

        Flash::success('Food Category deleted successfully.');

        return redirect(route('foodCategories.index'));
    }
}
