<?php

use App\Models\BlogPost;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::prefix('v1')->namespace('Api\V1')->group(function () {
    Route::get('status', function () {
        BlogPost::addAllToIndex();
        return response()->json(['Status' => 'Ok']);
    });
    
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::apiResource('posts', PostController::class)->only(['index', 'show']);

        Route::get('/me', function() {
            return response()->json(['me', auth()->user()]);
        });
    });

    Route::post('login', [AuthController::class, 'login']);
});



