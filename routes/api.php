<?php

use Database\Factories\UserFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|fdsf
*/

/* Route::middleware('api-token')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::middleware('auth.basic')->get('/user-basic', function (Request $request) {
    return $request->user();

});


Route::get('/hello',function() {
    return "Merhaba API";
});



//api url başta
Route::apiResource('/productApi','App\Http\Controllers\Api\ProductController');


Route::get('categories/custom1', 'App\Http\Controllers\Api\CategoryController@custom1')->middleware('api-token');

Route::get('products/custom1', 'App\Http\Controllers\Api\ProductController@custom1');

Route::get('products/custom2', 'App\Http\Controllers\Api\ProductController@custom2');

Route::get('categories/report1', 'App\Http\Controllers\Api\CategoryController@report1');

Route::get('users/custom1', 'App\Http\Controllers\Api\UserController@custom1');


Route::get('products/custom3', 'App\Http\Controllers\Api\ProductController@custom3');

Route::get('products/listwithcategories', 'App\Http\Controllers\Api\ProductController@listWithCategories');


//toplu tanımlama

Route::apiResources([
    'products' => 'App\Http\Controllers\Api\ProductController',
    'users'=> 'App\Http\Controllers\Api\UserController',
    'categories'=> 'App\Http\Controllers\Api\CategoryController'
    
]);

//api-token BAREER TOKEN

Route::post('/auth/login', 'App\Http\Controllers\Api\AuthController@login');


Route::middleware('api-token')->group(function () {

    Route::get('/auth/token', function (Request $request) {

        
        $user = $request->user();

        
        return response()->json([
            'name' => $user->name,
            'access_token' => $user->api_token,
            'time' => time()
        ]); 
    });
});


//upload 

Route::post('/upload', 'App\Http\Controllers\Api\UploadController@upload');
