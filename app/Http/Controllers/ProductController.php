<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Display a list of products.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if($request->query('limit') && is_numeric($request->query('limit'))) {
            return Product::with(['category', 'images'])->paginate($request->query('limit'));
        }

        return Product::with(['category', 'images'])->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        if($request->file('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path[] = ['product_id' => $product->id, 'image' => $imageFile->store('product_images')];
            }

             ProductImage::insert($path);
        }

        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        return Product::where('id', $product_id)->with(['category', 'images'])->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        return $product->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        return $product->delete();
    }
}
