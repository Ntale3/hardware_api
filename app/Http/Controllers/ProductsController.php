<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Products;
use App\Http\Requests;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //implementation with pagination
        $products = Products::paginate(15);
        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'No products found'
            ], 404);
        }
        return response()->json([
            'products' => $products
        ], 200);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //implementation
        $products = Products::all();
        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'No products found'
            ], 404);
        }
        return response()->json([
            'products' => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateRequest = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category' => 'required|max:255',
            'imagepath' => 'required|url|starts_with:https://res.cloudinary.com',
        ]);

       
        $product = Products::create([
            'name' => $validateRequest['name'],
            'description' => $validateRequest['description'],
            'price' => $validateRequest['price'],
            'quantity' => $validateRequest['quantity'],
            'category' => $validateRequest['category'],
            'imagepath' => $validateRequest['imagepath']
        ]);
        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //implementation
        $product = Products::find($id);
        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
        return response()->json([
            'product' => $product
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
       $product=Products::find($id);
       if(!$product){ return response()->json([
            'message'=>'Product not found'
        ],404);
       }
       return response()->json([
            'product'=>$product
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product=Products::find($id);
        if(!$product){ return response()->json([
            'message'=>'Product not found'
        ],404);
    }
     $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category' => 'required|max:255',
            'imagepath' => 'required|url|starts_with:https://res.cloudinary.com',
        ]);
        
       $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category' => $request->category,
            'imagepath' => $request->imagepath
        ]);
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ], 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    $product=Products::find($id);
    if(!$product){
        return response()->json(['message'=>'message not found'],404);
    }

    $product->delete();
    return response()->json(['message'=>'product deleted successfully'],200);
}
  
//return products based on category
public function getProductsByCategory($category)
{
    $products = Products::where('category', $category)->get();
    if ($products->isEmpty()) {
        return response()->json([
            'message' => 'No products found in this category'
        ], 404);
    }
    return response()->json([
        'products' => $products
    ], 200);}
    
}
