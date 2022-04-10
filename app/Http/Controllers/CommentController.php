<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCommentRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ProductCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCommentRequest $request)
    {
        $comment = new Comment;

        $bearerToken = $request->bearerToken();

        if($bearerToken) {
            $token = PersonalAccessToken::findToken($bearerToken);
            $user = $token->tokenable;
            $comment->name = $user->name;
            $comment->email = $user->email;
            $comment->user_id = $user->id;
        } else {
            if(!$request->input('name') || !$request->input('email')) {
                return response("Login or set name and email", 400);
            }
            $comment->name = $request->input('name');
            $comment->email = $request->input('email');
        }

        $comment->text = $request->input('text');

        if($request->input('parent_id')) {
            $comment->parent_id = $request->input('parent_id');
        }

        dd($request->input('product_id'));

        $product = Product::find($request->input('product_id'));

        return $product->comments()->save($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        if($comment->user_id !== $request->user()->id) {
            return response("Unauthorized", 401);
        }

        return $comment->update(['text' => $request->input('text')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Comment $comment)
    {
        if($comment->user_id !== $request->user()->id) {
            return response("Unauthorized", 401);
        }

        return $comment->delete();
    }
}
