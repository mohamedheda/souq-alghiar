<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\Email\ChangeEmailController;
use App\Http\Controllers\Api\V1\Auth\Otp\OtpController;
use App\Http\Controllers\Api\V1\Auth\Password\PasswordController;
use App\Http\Controllers\Api\V1\Category\CategoryController;
use App\Http\Controllers\Api\V1\City\CityController;
use App\Http\Controllers\Api\V1\Mark\MarkController;
use App\Http\Controllers\Api\V1\Package\PackageController;
use App\Http\Controllers\Api\V1\Post\Comment\CommentController;
use App\Http\Controllers\Api\V1\Post\PostController;
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\Api\V1\Subscription\SubscriptionController;
use App\Http\Controllers\Api\V1\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function () {
    Route::group(['prefix' => 'sign'], function () {
        Route::post('in', 'signIn');
        Route::post('up', 'signUp');
        Route::post('out', 'signOut')->middleware('auth:api');
        Route::post('social','socialSign');
    });
    Route::get('what-is-my-platform', 'whatIsMyPlatform'); // returns 'platform: website!'
});
Route::group(['prefix' => 'profile','middleware' => ['auth:api'] , 'controller' => AuthController::class], function () {
    Route::post('/', 'updateProfileData');
    Route::get('/', 'getProfileData');
});
Route::group(['prefix' => 'otp', 'middleware' => ['auth:api']], function () {
    Route::post('/verify', [OtpController::class, 'verify']);
    Route::get('/', [OtpController::class, 'send']);
});
Route::group(['prefix' => 'email', 'middleware' => ['auth:api']], function () {
    Route::post('/change', [ChangeEmailController::class, 'sendOtp']);
    Route::post('/otp/verify', [ChangeEmailController::class, 'change']);
});

Route::group(['middleware' => 'auth:api' ], function () {
    Route::prefix('products')->group(function (){
        Route::post('/',[ProductController::class ,'store']);
        Route::post('{id}',[ProductController::class ,'update']);
        Route::delete('{id}',[ProductController::class ,'delete']);
    });
    Route::prefix('posts')->group(function (){
        Route::post('/',[PostController::class ,'store']);
        Route::post('{id}',[PostController::class ,'update']);
        Route::delete('{id}',[PostController::class ,'delete']);
    });
    Route::prefix('comments')->group(function (){
        Route::post('/',[CommentController::class ,'store']);
        Route::delete('{id}',[CommentController::class ,'delete']);
    });
    Route::prefix('subscription')->group(function (){
        Route::get('/',[SubscriptionController::class ,'index']);
        Route::post('/confirm',[SubscriptionController::class ,'confirm']);
    });
});


// General Routes
Route::get('cities',[CityController::class,'index']);
Route::get('category',[CategoryController::class,'index']);
Route::get('marks/{model_id}',[MarkController::class,'getModels']);
Route::get('marks',[MarkController::class,'index']);
Route::get('products/{id}',[ProductController::class ,'show']);
Route::get('products',[ProductController::class ,'index']);
Route::get('posts/{id}',[PostController::class ,'show']);
Route::get('posts',[PostController::class ,'index']);
Route::get('packages',[PackageController::class ,'index']);
Route::get('{user_id}/products',[ProductController::class ,'getUserProducts']);
Route::get('users/{user_name}',[UserController::class ,'getUserProfile']);
Route::group(['prefix' => 'password'], function () {
    Route::post('/forgot', [PasswordController::class, 'forgot']);
    Route::post('/verify-otp', [PasswordController::class, 'verifyOtp']);
    Route::post('/reset', [PasswordController::class, 'reset']);
    Route::post('/update', [PasswordController::class, 'updatePassword']);
});
