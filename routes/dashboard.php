<?php

use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\Category\CategoryController;
use App\Http\Controllers\Dashboard\Category\SubCategoryController;
use App\Http\Controllers\Dashboard\Home\HomeController;
use App\Http\Controllers\Dashboard\Mangers\MangerController;
use App\Http\Controllers\Dashboard\Mark\MarkController;
use App\Http\Controllers\Dashboard\Merchant\MerchantController;
use App\Http\Controllers\Dashboard\Model\ModelController;
use App\Http\Controllers\Dashboard\Roles\RoleController;
use App\Http\Controllers\Dashboard\Settings\SettingController;
use App\Http\Controllers\Dashboard\Structure\HomeStructureController;
use App\Http\Controllers\Dashboard\User\UserController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', [AuthController::class, '_login'])->name('_login');

        Route::post('login', [AuthController::class, 'login'])->name('login');

        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('/');
        Route::resource('users', UserController::class);
        Route::get('merchants', [MerchantController::class,'index'])->name('merchants.index');
        Route::get('merchants/{id}/products', [MerchantController::class,'merchantsProducts'])->name('merchants.products');
        Route::get('merchants-products/{id}/create', [MerchantController::class,'create'])->name('merchants-products.create');
        Route::get('merchants-products/{id}/create-with-code', [MerchantController::class,'createWithCode'])->name('merchants-products.createWithCode');
        Route::post('merchants-products/store-with-code', [MerchantController::class,'storeWithCode'])->name('merchants-products.storeWithCode');
        Route::resource('merchants-products', MerchantController::class)->only('store','edit','update','delete');
        Route::resource('marks', MarkController::class);
        Route::get('marks/{id}/models', [MarkController::class,'getModels'])->name('marks.models');
        Route::get('marks/{id}/models/create', [ModelController::class,'create'])->name('marks.models.create');
        Route::resource('models', ModelController::class)->except('index','create');
        Route::resource('categories', CategoryController::class);
        Route::get('categories/{id}/sub-categories', [CategoryController::class,'getSubCategories'])->name('categories.sub_categories');
        Route::get('categories/{id}/sub-categories/create', [SubCategoryController::class,'create'])->name('categories.sub_categories.create');
        Route::resource('sub-categories', SubCategoryController::class)->except('index','create');
        Route::group(['prefix' => 'structures'], function () {
            Route::resource('home-content', HomeStructureController::class)->only(['index', 'store']);
        });
        Route::resource('settings' , SettingController::class)->only('edit','update');
        Route::post('update-password' , [SettingController::class,'updatePassword'])->name('update-password');
        Route::resource('roles',RoleController::class);
        Route::get('role/{id}/managers',[RoleController::class,'mangers'])->name('roles.mangers');
        Route::resource('managers',MangerController::class)->except('show','index');
    });
});
