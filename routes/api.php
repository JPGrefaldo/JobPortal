<?php

use Illuminate\Http\Request;
use App\Http\Middleware\AuthorizeRoles;
use App\Models\Role;

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

Route::middleware('auth:api')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'test'], function () {
        Route::middleware(AuthorizeRoles::parameterize(Role::CREW))
            ->get('/rolescrew', function (\Illuminate\Http\Request $request) {
                return response()->json(true);
            });

        Route::middleware(AuthorizeRoles::parameterize(Role::ADMIN))
            ->get('/rolesadmin', function (\Illuminate\Http\Request $request) {
                return response()->json(true);
            });

        Route::middleware(AuthorizeRoles::parameterize(Role::CREW, Role::PRODUCER))
            ->get('/rolescrewproducer', function (\Illuminate\Http\Request $request) {
                return response()->json(true);
            });
    });
});
