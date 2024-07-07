<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index');
    }

    public function fetchPosts()
    {
        // Ensure there is data in the database
        $posts = Post::all();

        // Check if there are any posts
        if ($posts->isEmpty()) {
            return response()->json([], 200); // Return an empty array if no posts are found
        }

        // Return the posts as a JSON response
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $post = Post::updateOrCreate(
            ['id' => $request->post_id],
            ['title' => $request->title, 'body' => $request->body]
        );

        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->update($request->all());
        return response()->json($post);
    }


    public function destroy($id)
    {
        Post::destroy($id);
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
