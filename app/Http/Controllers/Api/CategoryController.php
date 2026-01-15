<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        return Category::query()
                ->select('id', 'name')
                ->when($request->search, fn($q, $s) =>
                    $q->where('name', 'like', "%{$s}%")
                      ->orWhere('id', $s)
                )
                ->orderBy(
                    in_array($request->sortBy, ['id','name']) ? $request->sortBy : 'id',
                    in_array($request->sortOrder, ['asc','desc']) ? $request->sortOrder : 'desc'
                )
                ->paginate(
                    min(max($request->perPage ?? 10, 5), 100)
                );
    }

    /**
     * Store a newly created category.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return response()->json([
            'message' => 'Category created successfully',
            'data' => new CategoryResource($category)
        ], 201);
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category): CategoryResource
    {
        //$category->load('products');
        return new CategoryResource($category);
    }

    /**
     * Update the specified category.
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => new CategoryResource($category)
        ]);
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
}
