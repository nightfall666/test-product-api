<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('category')) {
            $query->where('category_slug', $request->query('category'));
        }

        if ($request->has('in_stock')) {
            $inStock = filter_var($request->query('in_stock'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if (is_null($inStock)) {
                return response()->json(['error' => 'Invalid in_stock parameter'], 400);
            }
            $query->where('in_stock', $inStock);
        }

        $perPage = $request->query('per_page', 15);
        if (!is_numeric($perPage) || $perPage <= 0) {
            return response()->json(['error' => 'Invalid per_page parameter'], 400);
        }

        $products = $query->paginate($perPage);
        $totalInStock = Product::where('in_stock', true)->sum('price');

        return response()->json([
            'products' => ProductResource::collection($products),
            'total_in_stock' => $totalInStock
        ], 200);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json(new ProductResource($product), 201);
    }

    public function show($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['error' => 'Invalid product ID'], 400);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json(new ProductResource($product), 200);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['error' => 'Invalid product ID'], 400);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $product->update($request->validated());
        return response()->json(new ProductResource($product), 200);
    }

    public function destroy($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['error' => 'Invalid product ID'], 400);
        }
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
