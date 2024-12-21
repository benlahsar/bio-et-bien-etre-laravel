<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'category' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required'],
            'quantity' => ['required'],
            'image' => ['required'],
        ]);

        $product = Product::create([
            'name' => $request->name,
            // 'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $request->image,
        ]);

        return response()->noContent();
    }

    // Fetch all products
    public function index()
    {
        $products = Product::all(); // Fetches all product records
        return response()->json($products); // Returns data as JSON
    }

    // Fetch a single product by ID
    public function show($id)
    {
        $product = Product::find($id); // Finds a product by ID
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product); // Returns data as JSON
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // 'category' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
        ]);

        // Find the product by ID
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Update the product with the validated data
        $product->update($validatedData);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
