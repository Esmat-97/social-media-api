<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;


class LikePostController extends Controller
{
    //

    public function count($post_id)
    {
        $count = Like::where('post_id', $post_id)->count();
        return response()->json(['count' => $count]);
    }


    public function userLikes($user_id)
    {
        $likes = Like::where('user_id', $user_id)->count();
        return response()->json(['count' => $likes]);
    }




    public function allLikes()
    {
        $likes = Like::all();
        return response()->json($likes);
    }




    public function detail($id)
    {
        $like = Like::find($id);
        if ($like) {
            return response()->json($like);
        }
        return response()->json(['message' => 'Like not found'], 404);
    }











    /*   */

    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'user_id' => 'required|integer',
        'post_id' => 'required|integer',
    ]);

    // Check if the like already exists
    $existingLike = Like::where('user_id', $request->user_id)
                        ->where('post_id', $request->post_id)
                        ->first();

    if ($existingLike) {
        return response()->json(['message' => 'User has already liked this post'], 409);
    }

    // Create a new like if it does not exist
    $like = new Like;
    $like->user_id = $request->user_id;
    $like->post_id = $request->post_id;
    $like->save();

    return response()->json(['message' => 'Like added successfully', 'like' => $like]);
}



public function check(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'post_id' => 'required|integer',
        ]);
    
        $likeExists = Like::where('user_id', $request->user_id)
                          ->where('post_id', $request->post_id)
                          ->exists();
    
        return response()->json(['exists' => $likeExists]);
    }




public function destroy(Request $request)
{
    // Validate the request data
    $request->validate([
        'user_id' => 'required|integer',
        'post_id' => 'required|integer',
    ]);

    // Find the like
    $like = Like::where('user_id', $request->user_id)
                ->where('post_id', $request->post_id)
                ->first();

    if ($like) {
        $like->delete();
        return response()->json(['message' => 'Like removed successfully']);
    }

    return response()->json(['message' => 'Like not found'], 404);
}



/*    */












    public function update(Request $request, $id)
    {
        $like = Like::find($id);
        if ($like) {
            $like->user_id = $request->user_id;
            $like->post_id = $request->post_id;
            $like->save();

            return response()->json(['message' => 'Like updated successfully', 'like' => $like]);
        }
        return response()->json(['message' => 'Like not found'], 404);
    }




}
