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
                  ->orWhereHas('category', fn($q) =>
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

    public function shop(Request $request)
    {
        $query = Product::query()
            ->with('category:id,name')
            ->select('id', 'name', 'price', 'category_id');

        // 1. Name search
        if ($search = trim($request->query('name'))) {
            $query->where('name', 'like', "%{$search}%");
        }

        // 2. Category filter
        if ($categoryId = $request->query('category_id')) {
            $query->where('category_id', $categoryId);
        }

        // 3. Price filters - all possible variations
        if ($request->filled('exact_price')) {
            $query->where('price', $request->exact_price);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('price_greater_than')) {
            $query->where('price', '>', $request->price_greater_than);
        }

        if ($request->filled('price_less_than')) {
            $query->where('price', '<', $request->price_less_than);
        }

        // Range between (from-to)
        if ($request->filled('price_from') && $request->filled('price_to')) {
            $query->whereBetween('price', [
                $request->price_from,
                $request->price_to
            ]);
        }

        // 4. Sorting (optional - you can add later)
        $sortBy = $request->query('sort_by', 'id');
        $sortDirection = $request->query('sort_direction', 'desc');

        $allowedSort = ['id', 'name', 'price'];
        $sortBy = in_array($sortBy, $allowedSort) ? $sortBy : 'id';

        $query->orderBy($sortBy, $sortDirection);

        // 5. Pagination
        $perPage = min(max($request->query('per_page', 12), 8), 60);

        $products = $query->paginate($perPage);

        return $products;
    }
}
