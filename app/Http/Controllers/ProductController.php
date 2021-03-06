<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Filters\ProductsFilter;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ids) {
           return Product::whereIn('id', $request->ids)->with(['category', 'images'])->get();
        }

        return Product::get();
    }

    /**
     * Display a list of products.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $filter = new ProductsFilter($request->query());

        if ($request->query('limit') && is_numeric($request->query('limit'))) {
            return Product::filter($filter)->with(['category', 'images'])
                ->paginate($request->query('limit'));
        }

        $positions = Product::filter($filter)->paginate(6);


        return Product::filter($filter)->with(['category', 'images'])
            ->get();
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
     * Display a list of categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function count()
    {
        return Product::count();
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
     * Display comments of products.
     *
     * @return \Illuminate\Http\Response
     */
    public function comments(Request $request, Product $product)
    {
        $limit = $request->input('limit') ?? 6;
        return $product->comments()->paginate($limit);
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

