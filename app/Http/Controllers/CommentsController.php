<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;

class CommentsController extends Controller
{
    //
    public function index($post_id)
    {
        // Retrieve all comments
        $posts = Comment::with('post','user')->where('post_id', $post_id)->get();

        // Check if any posts were found
        if ($posts->isEmpty()) {
            return response()->json(['message' => 'No posts found'], 404);
        }

        // Return the posts as a JSON response
        return response()->json($posts, 200);
    }






    public function count($post_id)
    {
        // Retrieve the count of comments for the given post ID
        $commentCount = Comment::where('post_id', $post_id)->count();
    
        // Check if any comments were found
        if ($commentCount == 0) {
            return response()->json(['message' => 'No comments found'], 404);
        }
    
        // Return the comment count as a JSON response
        return response()->json(['comment_count' => $commentCount], 200);
    }
    



    public function show($id)
    {
        // Retrieve a specific comment by ID
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        return response()->json($comment);
    }



    
    public function store(Request $request)
    {
        // Validate and store a new comment
        $request->validate([
            'post_id' => 'required|integer',
            'content' => 'required|string',
            'user_id' => 'required|string'
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'content' => $request->content,
            'user_id' => $request->user_id
        ]);

        return response()->json($comment, 201);
    }

    public function update(Request $request, $id)
    {
        // Validate and update an existing comment
        $request->validate([
            'content' => 'sometimes|required|string',
            'author' => 'sometimes|required|string'
        ]);

        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->update($request->all());
        return response()->json($comment);
    }

    public function destroy($id)
    {
        // Delete a comment
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment deleted']);
    }
}
