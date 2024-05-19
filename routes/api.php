<?php

    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\EstateAgentController;
    use App\Http\Controllers\UserController;
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

    Route::post('/login', [AuthController::class, "login"]);
    Route::post('/register', [UserController::class, "register"]);

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::group(['prefix' => 'user'], function () {

            Route::get('/list', [UserController::class, "index"]);
        });

        Route::group(['prefix' => 'estateagent'], function () {

            Route::post('/store', [EstateAgentController::class, "store"]);
            Route::get('/list/{page}', [EstateAgentController::class, "index"]);
            Route::get('/show/{id}', [EstateAgentController::class, "show"]);
        });
    });
