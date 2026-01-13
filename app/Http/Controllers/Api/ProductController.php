<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of Products.
     */
    public function index(): AnonymousResourceCollection
    {
        $Products = Product::with([
            'category:id,name'
        ])->get();
        return ProductResource::collection($Products);
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
}
