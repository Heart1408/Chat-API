<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
})->name('rrr');

Route::post('auth/login', [RegisterController::class, 'login'])->name('login');
Route::post('auth/register', [RegisterController::class, 'register'])->name('register');

Route::middleware('auth')->group( function () {

    Route::get('/chat', function () {
        return view('main');
    });

    Route::get('check', function () {
        return view('check');
    }); 

    Route::group(['prefix' => 'chat'], function(){
        Route::get('get_conversations', [UserController::class, 'get_conversations']);
        Route::get('get_messages', [UserController::class, 'get_messages']);
        Route::get('get_conversation_data', [UserController::class, 'get_conversation_data']);
        Route::get('delete_conversation', [UserController::class, 'delete_conversation']);
        Route::post('upload_conversation_avatar', [UserController::class, 'upload_conversation_avatar']);
    });

    Route::group(['prefix' => 'user'], function(){
        Route::post('search_by_name', [UserController::class, 'search_user']);
        Route::post('upload_user_avatar', [UserController::class, 'upload_user_avatar']);
        Route::post('change_user_name', [UserController::class, 'change_user_name']);
    });

    Route::post('join_conversation', [UserController::class, 'join_conversation']);
    Route::post('add_to_conversation', [UserController::class, 'add_to_conversation']);
    Route::post('remove_from_conversation', [UserController::class, 'remove_from_conversation']);
    Route::get('leave_conversation', [UserController::class, 'leave_conversation']);
    Route::post('change_conversation_name', [UserController::class, 'change_conversation_name']);
    Route::post('create_conversation', [UserController::class, 'create_conversation']);
});
