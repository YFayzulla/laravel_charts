<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index');
    }

    public function fetchPosts()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,png,jpeg,gif'
        ]);

        $imagePath = null;
        if ($request->hasFile('file')) {
            $imagePath = $request->file('file')->store('images', 'public');


            $imagePath='salom';
        }


        $post = Post::create([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'image_path' => $imagePath ?? 'yoq' ,
        ]);

        return response()->json($post);
    }

    // Update an existing post
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

        $post = Post::findOrFail($id);

        $imagePath = $post->image_path;
        if ($request->hasFile('file')) {
            // Delete old image if it exists
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            // Store the new image and update the path
            $imagePath = $request->file('file')->store('images', 'public');
        }

        $post->update([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'image_path' => $imagePath,
        ]);

        return response()->json($post);
    }
    public function destroy(Post $post)
    {
        if ($post->file_path) {
            Storage::disk('public')->delete($post->file_path);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully.']);
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }
}
