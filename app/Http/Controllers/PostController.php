<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //





    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }



    
    public function select($id)
    {
        // Retrieve expenses associated with the specified user ID
        $expenses = Post::with('user')->where('user_id', $id)->get();

        // Check if any expenses were found
        if ($expenses->isEmpty()) {
            return response()->json(['message' => 'No posts found for the user'], 404);
        }

        // Return the expenses as a JSON response
        return response()->json($expenses, 200);
    }





    public function allposts()
    {
        // Retrieve all posts along with their associated users
        $posts = Post::with('user')->get();

        // Check if any posts were found
        if ($posts->isEmpty()) {
            return response()->json(['message' => 'No posts found'], 404);
        }

        // Return the posts as a JSON response
        return response()->json($posts, 200);
    }




    // Method to store a newly created post
    public function store(Request $request)
    {
        
        $project = Post::create($request->all());
        return response()->json($project, 201);
    }




    public function detail($id)
    {
           // Retrieve expenses associated with the specified user ID
           $expenses = Post::with('user')->where('id', $id)->get();

           // Check if any expenses were found
           if ($expenses->isEmpty()) {
               return response()->json(['message' => 'No posts found for the user'], 404);
           }
   
           // Return the expenses as a JSON response
           return response()->json($expenses, 200);
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
