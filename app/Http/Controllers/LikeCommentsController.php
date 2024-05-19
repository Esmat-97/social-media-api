<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\likeComment;
use App\Models\User;


class LikeCommentsController extends Controller
{
    //

    public function count($comment_id)
    {
        $count = likeComment::where('comment_id', $comment_id)->count();
        return response()->json(['count' => $count]);
    }




    public function userLikes($user_id)
    {
        $likes = Like::where('user_id', $user_id)->count();
        return response()->json(['count' => $likes]);
    }




    public function allLikes()
    {
        $likes = likeComment::all();
        return response()->json($likes);
    }




    public function detail($id)
    {
        $like = likeComment::find($id);
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
        'comment_id' => 'required|integer'
    ]);

    // Check if the like already exists
    $existingLike = likeComment::where('user_id', $request->user_id)
                        ->where('post_id', $request->post_id)
                        ->where('comment_id', $request->comment_id)
                        ->first();

    if ($existingLike) {
        return response()->json(['message' => 'User has already liked this post'], 409);
    }

    // Create a new like if it does not exist
    $like = new likeComment;
    $like->user_id = $request->user_id;
    $like->post_id = $request->post_id;
    $like->comment_id = $request->comment_id;
    $like->save();

    return response()->json(['message' => 'Like added successfully', 'like' => $like]);
}




/*    */



public function check(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'post_id' => 'required|integer',
            'comment_id' => 'required|integer'
        ]);
    
        $likeExists = likeComment::where('user_id', $request->user_id)
                          ->where('post_id', $request->post_id)
                        ->where('comment_id', $request->comment_id)
                          ->exists();
    
        return response()->json(['exists' => $likeExists]);
    }



      /*    */


public function destroy(Request $request)
{
    // Validate the request data
    $request->validate([
        'user_id' => 'required|integer',
        'post_id' => 'required|integer',
        'comment_id' => 'required|integer'
    ]);

    // Find the like
    $like = likeComment::where('user_id', $request->user_id)
                ->where('post_id', $request->post_id)
                ->where('comment_id', $request->comment_id)
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
