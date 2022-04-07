<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class OrderController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        foreach ($request->get('products') as $product) {
            $dbProduct = Product::findOrFail($product['id']);
            $remainsQuantity = $dbProduct->quantity - $product['quantity'];

            if($remainsQuantity < 0) {
                $error_message = "only $dbProduct->quantity of $dbProduct->name are available";
                return response(['errors' => ['invalid' => $error_message]], 422);
            }

            $dbProduct->quantity = $remainsQuantity;

            $dbProduct->save();
        }

        $orderParams = $request->only('name', 'email', 'address');

        $bearerToken = $request->bearerToken();

        if($bearerToken) {
            $token = PersonalAccessToken::findToken($bearerToken);
            $user = $token->tokenable;
            $orderParams['user_id'] = $user->id;
        }

        $newOrder = Order::create($orderParams);

        $newOrder->products()->attach(collect($request->get('products'))->pluck('id')->toArray());

        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
