<?php

use App\Http\Controllers\tasklist\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'task-mgmt'], function () {
//    http://localhost/task-mgmt-api/public/api/v1/task-mgmt/task


    //api resource here
    Route::apiResources(
        [
            'task' => TaskController::class,  //GET. POST, PATCH, UPDATE , DELETE
        ]
    );


    // Mark task complete/incomplete
    Route::post('markTaskAsCompleteOrIncomplete', [TaskController::class, 'markTaskAsCompleteOrIncomplete']);


    Route::get('testlang', function () {
        return [
            'testlang' => 'This is a test.',
        ];
    });

});
