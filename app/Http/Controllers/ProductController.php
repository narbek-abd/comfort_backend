<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        if ($request->query('limit') && is_numeric($request->query('limit'))) {
            return Product::with(['category', 'images'])
                ->paginate($request->query('limit'));
        }

        return Product::with(['category', 'images'])
            ->all();
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

        if ($request->file('images')) {
            self::insert_images($request->file('images'), $product);
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
        return Product::where('id', $product_id)->with(['category', 'images'])
            ->first();
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
        $product->update($request->validated());

        if ($request->file('images')) {
            self::insert_images($request->file('images') , $product);
        }

        return Product::where('id', $product->id)
            ->with(['category', 'images'])
            ->first();
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

    /**
     * Remove the iamge of product
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy_product_image(ProductImage $product_image)
    {
        $image_name = $product_image->image;

        if (Storage::exists($image_name)) {
            Storage::delete($image_name);
        }

        return $product_image->delete();
    }

    /**
     * Remove the iamge of product
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    private static function insert_images($images, $product)
    {
        foreach ($images as $imageFile)
        {
            $imagePath[] = ['product_id' => $product->id, 'image' => $imageFile->store('product_images') ];
        }

        ProductImage::insert($imagePath);
    }
}

