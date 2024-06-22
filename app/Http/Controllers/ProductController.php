<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    public function show(string $id) // $id is came from 'products/{id}' route
    {
      $product = Product::find($id); // Attempt to find a Product by its ID

      if ($product) { // Check if the product exists
        return response()->json($product, 200);
      } else {
        return response()->json(['message' => 'Product not found'], 404);
      }
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        if ($product) {
            $product->update($validated);
            return response()->json($product, 200);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function destroy(Product $product)
    {
        if ($product) {
            $product->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
}
