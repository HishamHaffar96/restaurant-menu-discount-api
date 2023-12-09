<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Discount\BulkDestroyDiscount;
use App\Http\Requests\Admin\Discount\DestroyDiscount;
use App\Http\Requests\Admin\Discount\IndexDiscount;
use App\Http\Requests\Admin\Discount\StoreDiscount;
use App\Http\Requests\Admin\Discount\UpdateDiscount;
use App\Models\Discount;
use App\Models\Item;
use App\Models\Category;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DiscountsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexDiscount $request
     * @return array|Factory|View
     */
    public function index(IndexDiscount $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Discount::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id','type',"amount",'discountable_id'],

            // set columns to searchIn
            ['type',"amount"],
            function ($query) use ($request) {
                $query->with(['category','item']);
            }
        );
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.discount.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.discount.create');

        return view('admin.discount.create',[
        'categories' => Category::all(),
        'items' => Item::all(),
        "types" => Discount::$types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDiscount $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreDiscount $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['type'] = $request->getType();
        if (isset($sanitized['type'])) {
            $discountType = $sanitized['type'];

            if ($discountType === "menu") {
                $this->deleteDiscountsByType('menu');
            } else {
                $this->setDiscountableAttributes($sanitized, $discountType);
                $this->deleteDiscountsByTypeAndId($discountType, $sanitized['discountable_id']);
            }
        }
        // Store the Discount
        $discount = Discount::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/discounts'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/discounts');
    }
    /**
     * Delete discounts by type.
     *
     * @param string $type
     * @return void
     */
    private function deleteDiscountsByType(string $type)
    {
        Discount::where('type', $type)->delete();
    }

    /**
     * Set discountable attributes based on discount type.
     *
     * @param array $sanitized
     * @param string $type
     * @return void
     */
    private function setDiscountableAttributes(array &$sanitized, string $type)
    {
        $sanitized['discountable_id'] = $type === "item" ? $sanitized['item_id']['id'] : $sanitized['category_id']['id'];
        $sanitized['discountable_type'] = $type === "item" ? 'App\\Models\\Item' : 'App\\Models\\Category';
    }

    /**
     * Delete discounts by type and discountable_id.
     *
     * @param string $type
     * @param int $discountableId
     * @return void
     */
    private function deleteDiscountsByTypeAndId(string $type, int $discountableId)
    {
        Discount::where('type', $type)->where('discountable_id', $discountableId)->delete();
    }


    /**
     * Display the specified resource.
     *
     * @param Discount $discount
     * @throws AuthorizationException
     * @return void
     */
    public function show(Discount $discount)
    {
        $this->authorize('admin.discount.show', $discount);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Discount $discount
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Discount $discount)
    {
        $this->authorize('admin.discount.edit', $discount);


        return view('admin.discount.edit', [
            'discount' => $discount,
            'categories' => Category::all(),
            'items' => Item::all(),
            "types" => Discount::$types
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDiscount $request
     * @param Discount $discount
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateDiscount $request, Discount $discount)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['type'] = $request->getType();

        if (isset($sanitized['type'])) {

            $discountType = $sanitized['type'];
            $discount->delete();

            if ($discountType === "menu") {
                $this->deleteDiscountsByType('menu');
            } else {
                $this->setDiscountableAttributes($sanitized, $discountType);
                $this->deleteDiscountsByTypeAndId($discountType, $sanitized['discountable_id']);
            }
        }

        // Update changed values Discount
        $discount = Discount::create($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/discounts'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/discounts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyDiscount $request
     * @param Discount $discount
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyDiscount $request, Discount $discount)
    {
        $discount->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyDiscount $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyDiscount $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Discount::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
