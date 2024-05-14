<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //


    public function index($id)
    {
          // Retrieve expenses associated with the specified user letter
          $expenses = User::whereNotIn('id', [$id])->get();

    
          // Check if any expenses were found
          if ($expenses->isEmpty()) {
              return response()->json(['message' => 'No expenses found for the user'], 404);
          }
      
          // Return the expenses as a JSON response
          return response()->json($expenses, 200);
    }



    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['user' => $user]);
    }




    
    public function search($letter)
    {
        // Retrieve expenses associated with the specified user letter
        $expenses = User::where('name', 'like', $letter . '%')->get();
    
        // Check if any expenses were found
        if ($expenses->isEmpty()) {
            return response()->json(['message' => 'No expenses found for the user'], 404);
        }
    
        // Return the expenses as a JSON response
        return response()->json($expenses, 200);
    }
    





    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'image' => 'required', // Validate image file
    ]);

    // Create user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'image' =>  $request->image, // Save image path to database
    ]);

    return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
}





    
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
