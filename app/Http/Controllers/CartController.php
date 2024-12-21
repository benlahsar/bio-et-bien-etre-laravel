<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required'],
            'quantity' => ['required'],
            'image' => ['required'],
        ]);

        $product = Cart::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $request->image,
        ]);

        return response()->noContent();
    }

    public function index()
    {
        $products = Cart::all(); // Fetches all product records
        return response()->json($products); // Returns data as JSON
    }

    // Fetch a single product by ID
    public function show($id)
    {
        $product = Cart::find($id); // Finds a product by ID
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product); // Returns data as JSON
    }
}
