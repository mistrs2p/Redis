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

// Route::get('/', function () {
//     // return view('welcome');
//     $visits = Redis::incrBy('visits', 5);
//     return view('welcome')->withVisits($visits);
// });

// Route::get('videos/{id}', function ($id) {
//     $downlaods = Redis::get("videos.{$id}.downloads");

//     return view('welcome')->withDownloads($downlaods);
// });

// Route::get('videos/{id}/download', function ($id) {
//     // Prepare the download
//     Redis::incr("videos.{$id}.downloads");
//     return back();
// });



// Route::get('articles/trending', function () {
//     $trending = Redis::zrevrange('trending_articles', 0, 2);

//     $trending = App\Article::hydrate(
//         array_map('json_decode', $trending)
//     );

//     dd($trending);
//     // return $trending;
// });

// Route::get('articles/{article}', function (App\Article $article) {
//    Redis::zincrby('trending_articles', 1, $article); // $article->id same output

//    Redis::zremrangebyrank('trending_article', 0, -4);

//    return $article; 
// });

// // Hashes

// Route::get('/hashes', function () {

//     $user1stats = [
//         'favorites' => 50,
//         'watchLaters' => 95,
//         'compelitions' => 29
//     ];

//     Redis::hmset('user.1.stats', $user1stats);

//     return Redis::hgetall('user.1.stats');

// });

// Route::get('users/{id}/stats', function ($id) {
//     return Redis::hgetall("user.{$id}.stats");
// });


// function remember($key, $minuts, $callback) {
//     if ($value = Redis::get($key)) {
//         return json_decode($value);
//     }

//     $value = $callback();

//     Redis::setex($key, $minuts, $value);

//     return $value;
// }

// Route::get('/', function () {

//     if(Redis::exists('articles.all')) {
//         return json_decode(Redis::get('articles.all'));
//     }

//     $articles = App\Article::all();

//     Redis::setex('articles.all', 10, $articles);

//     return $articles;
// });

class CashableArticles
{
    protected $articles;
    
    public function __construct ($articles) 
    {
        $this->articles = $articles;
    }

    public function all () 
    {
        return Cache::remember('articles.all', 60 * 60, function () {
            return $this->articles->all();
        });
    }
}

class Articles
{
    public function all () {
        return App\Article::all();
    }
}

Route::get('/', function (Articles $articles) {
    return $articles->all();
});