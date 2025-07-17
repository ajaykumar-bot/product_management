<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return view('products.index');
    }

    public function getAllProducts($id=null)
    {
        try {

            if ($id) {
                $products = Product::findOrFail($id);

            } else {

                $products = Product::all();
            }
    
            return response()->json(['message' => 'Product fetched successfully.', 'products' => $products]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {

            $product = Product::create($request->all());

            return response()->json(['message' => 'Product created successfully.', 'product' => $product]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            if($product){
                $product->name = $request->name;
                $product->category = $request->category;
                $product->price = $request->price;
                
                $product->save();
     
                return response()->json(['message' => 'Product updated successfully.', 'product' => $product]);

            }
            return response()->json(['message' => 'No Product Found.'], 404);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
