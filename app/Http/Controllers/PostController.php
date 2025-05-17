<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "ok" => true,
            "posts" => Post::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string|max:255",
            "author" => "required|string|max:255",
            "excerpt" => "required|min:50",
            "text" => "required|min:150"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => $validator->errors()
            ], 406);
        }

        $post = Post::create($validator->safe()->all());
        return response()->json([
            "ok" => true,
            "post" => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json([
            "ok" => true,
            "post" => $post
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            "title" => "string|max:255",
            "author" => "string|max:255",
            "excerpt" => "min:50",
            "text" => "min:150"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => $validator->errors()
            ], 406);
        }

        $post->update($validator->safe()->all());
        return response()->json([
            "ok" => true,
            "post" => $post
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            "ok" => true
        ], 200);
    }
}
