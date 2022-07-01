<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreValidation;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        try {
            return ['message' => 'Products List', 'data' => Product::latest()->paginate()];
//            return Product::latest()->get();
        } catch (Exception $exception) {
            return ['message' => $exception->getMessage()];
        }
    }

    public function store(ProductStoreValidation $request): array
    {
        try {
            $product = Product::create($request->validated());
            return ['message' => 'Product Created', 'data' => $product];
        } catch (Exception $exception) {
            return ['message' => $exception->getMessage()];
        }
    }

    public function show($id)
    {
        try {
            return Product::findOrFail($id);
        } catch (Exception $exception) {
            return ['message' => $exception->getMessage()];
        }
    }

    public function update(ProductStoreValidation $request)
    {
        try {
            $data = $request->validated();
            $product = Product::findOrFail($data['product_id']);
            $product->update($data);
            return $product;
        } catch (Exception $exception) {
            return ['message' => $exception->getMessage()];
        }
    }

    public function delete($id)
    {

    }
}
