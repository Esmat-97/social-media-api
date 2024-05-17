<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\CommentsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::post('/password/email', [ResetPasswordController::class, 'sendResetLinkEmail']);
// Route::post('/password/reset', [ResetPasswordController::class, 'reset']);









Route::post('/register', [AuthController:: class ,"register"] );                  /*  */
Route::post('/login', [AuthController:: class ,"login"] );                        /*  */
Route::post('/logout', [AuthController:: class ,"logout"] )->middleware('auth');





Route::get('/users/not/{id}', [UserController::class, 'index']);                    /*  */
Route::get('/users/search/{letter}', [UserController::class, 'search']);            /*  */
Route::get('/users/{id}', [UserController::class, 'show']);                         /*  */
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);




Route::get('/posts/count/{user_id}', [PostController::class, 'count']);         /*  */
Route::get('/posts/select/{id}', [PostController::class, 'select']) ;           /*  */
Route::get('/posts/allposts', [PostController::class, 'allposts']);             /*  */
Route::get('/posts/detail/{id}', [PostController::class, 'detail']);            /*  */
Route::post('/posts', [PostController::class, 'store']);                        /*  */
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);               /*  */





Route::get('/comments/{post_id}', [CommentsController::class, 'index']);             /*  */
Route::get('/comments/count/{post_id}', [CommentsController::class, 'count']);       /*  */
Route::get('/comments/{id}', [CommentsController::class, 'show']);
Route::post('/comments', [CommentsController::class, 'store']);                      /*  */
Route::put('/comments/{id}', [CommentsController::class, 'update']);
Route::get('/comments', [CommentsController::class, 'get']);
Route::delete('/comments/{id}', [CommentsController::class, 'destroy']);             /* */


