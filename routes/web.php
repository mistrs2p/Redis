<?php

// use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    $visits = Redis::incrBy('visits', 5);
    return view('welcome')->withVisits($visits);
});

Route::get('videos/{id}', function ($id) {
    $downlaods = Redis::get("videos.{$id}.downloads");

    return view('welcome')->withDownloads($downlaods);
});

Route::get('videos/{id}/download', function ($id) {
    // Prepare the download
    Redis::incr("videos.{$id}.downloads");
    return back();
});

Route::get('articles/{article}', function (App\Article $article) {
   return $article; 
});