<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/api/featured-posts', function () {
    $array = [];
    for ($i=0;$i<=10000;$i++){
        $array[$i]=['id' => 1, 'title' => 'Post One'];
    }
    return $array;
});

