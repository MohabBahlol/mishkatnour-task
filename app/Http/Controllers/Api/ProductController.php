<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of Products.
     */
    public function index(Request $request)
    {
        return Product::query()
            ->with('category:id,name')           // minimal category data
            ->select('products.id', 'products.name', 'products.price', 'products.category_id')

            // Search
            ->when($request->search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('products.name', 'like', "%{$search}%")
                        ->orWhere('products.id', $search)           // exact for ID
                        ->orWhere('products.price', 'like', "%{$search}%")
                        ->orWhereHas(
                            'category',
                            fn($q) =>
                            $q->where('name', 'like', "%{$search}%")
                        );
                });
            })

            // Sorting
            ->when($request->sortBy === 'category.name', function ($q) use ($request) {
                $q->join('categories', 'products.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', $request->input('sortOrder', 'asc'))
                    ->select('products.*');
            }, function ($q) use ($request) {
                $allowed = ['id', 'name', 'price'];
                $sortBy = in_array($request->sortBy, $allowed) ? $request->sortBy : 'id';
                $sortOrder = in_array($request->sortOrder, ['asc', 'desc']) ? $request->sortOrder : 'desc';

                $q->orderBy($sortBy, $sortOrder);
            })

            // Pagination (5–100 items)
            ->paginate(
                min(max($request->input('perPage', 10), 5), 100)
            );
    }

    /**
     * Store a newly created Product.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $Product = Product::create($request->validated());

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($Product)
        ], 201);
    }

    /**
     * Display the specified Product.
     */
    public function show(Product $Product): ProductResource
    {
        $Product->load('category');
        return new ProductResource($Product);
    }

    /**
     * Update the specified Product.
     */
    public function update(UpdateProductRequest $request, Product $Product): JsonResponse
    {
        $Product->update($request->validated());

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new ProductResource($Product)
        ]);
    }

    /**
     * Remove the specified Product.
     */
    public function destroy(Product $Product): JsonResponse
    {
        $Product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    public function products(Request $request)
    {
        return
            Product::query()
                ->with('category:id,name')
                ->select('id', 'name', 'price', 'category_id')

                // Name search
                ->when(
                    $request->name,
                    fn($q, $name) =>
                    $q->where('name', 'like', "%{$name}%")
                )

                // Category filter
                ->when(
                    $request->category_id,
                    fn($q, $id) =>
                    $q->where('category_id', $id)
                )

                // Price conditions
                ->when(
                    $request->filled('exact_price'),
                    fn($q) =>
                    $q->where('price', $request->exact_price)
                )
                ->when(
                    $request->filled('min_price'),
                    fn($q) =>
                    $q->where('price', '>=', $request->min_price)
                )
                ->when(
                    $request->filled('max_price'),
                    fn($q) =>
                    $q->where('price', '<=', $request->max_price)
                )
                ->when(
                    $request->filled('price_greater_than'),
                    fn($q) =>
                    $q->where('price', '>', $request->price_greater_than)
                )
                ->when(
                    $request->filled('price_less_than'),
                    fn($q) =>
                    $q->where('price', '<', $request->price_less_than)
                )
                ->when(
                    $request->filled('price_from') && $request->filled('price_to'),
                    fn($q) => $q->whereBetween('price', [
                        $request->price_from,
                        $request->price_to
                    ])
                )

                // Sorting
                ->orderBy(
                    in_array($request->sort_by, ['id', 'name', 'price'])
                    ? $request->sort_by
                    : 'id',
                    in_array($request->sort_direction, ['asc', 'desc'])
                    ? $request->sort_direction
                    : 'desc'
                )

                // Pagination
                ->paginate(
                    min(max($request->integer('per_page', 12), 8), 60)
                );
    }
}
