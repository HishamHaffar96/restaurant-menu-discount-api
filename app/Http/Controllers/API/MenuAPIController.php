<?php

namespace App\Http\Controllers\API;


use App\Models\Item;
use App\Http\Controllers\Controller;
use App\Repositories\ItemRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Criteria\Menu\CategoryCriteria;
use App\Criteria\Menu\ItemCriteria;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;

/**
 * Class ItemController
 * @package App\Http\Controllers\API
 */

class MenuAPIController extends Controller
{
    /** @var  ItemRepository */
    private $itemRepository;
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(ItemRepository $itemRepo,CategoryRepository $categoryRepo)
    {
        $this->itemRepository = $itemRepo;
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Item.
     * GET|HEAD /items
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
     /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            // Apply criteria to the ItemRepository
            $this->applyItemRepositoryCriteria($request);

            // Apply criteria to the CategoryRepository
            $this->applyCategoryRepositoryCriteria($request);
        } catch (RepositoryException $e) {
            // Handle repository exceptions
            return $this->sendError($e->getMessage());
        }

        // Retrieve items with associated category
        $items = $this->itemRepository->with('category')->get(['id', 'name', 'category_id', 'price', 'description']);

        // Transform items (if needed)
        $items = $items->map(function ($item) {
            $item->discount = $item->discount;
            return $item;
        });

        // Retrieve categories with their children
        $categories = $this->categoryRepository->with('childrenCategories')->get();

        $categories = $categories->map(function ($item) {
            $item->path = $item->path;
            return $item;
        });

        // Prepare the response data
        $response = [
            'items' => $items->toArray(),
            'categories' => $categories,

        ];

        // Send a successful response
        return $this->sendResponse($response, 'Menu retrieved successfully');
    }

    /**
     * Apply criteria to the ItemRepository.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function applyItemRepositoryCriteria(Request $request)
    {
        $this->itemRepository->pushCriteria(new RequestCriteria($request));
        $this->itemRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->itemRepository->pushCriteria(new ItemCriteria($request));
    }

    /**
     * Apply criteria to the CategoryRepository.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function applyCategoryRepositoryCriteria(Request $request)
    {
        $this->categoryRepository->pushCriteria(new RequestCriteria($request));
        $this->categoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->categoryRepository->pushCriteria(new CategoryCriteria($request));
    }

}
