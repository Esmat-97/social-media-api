<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    //


    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }




    // Method to store a newly created post
    public function store(Request $request)
    {
        
        $project = Post::create($request->all());
        return response()->json($project, 201);
    }





    // Method to show a specific post
    public function show(Post $post)
    {
        return response()->json($post);
    }

    // Method to update a post
    public function update(Request $request, Post $post)
    {
        // Validation
        $request->validate([
            'post_content' => 'required',
            // Add validation rules for other fields as needed
        ]);

        // Update post
        $post->update([
            'post_content' => $request->post_content,
            'image' => $request->image,
        ]);

        return response()->json($post, 200);
    }


    

    
    // Method to delete a post
    public function destroy($id)
    {
        $user = Post::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }

}
