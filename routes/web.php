<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/api/blog', ["uses" => "BlogController@index"]);
$router->get('/api/blog/{hash}', ["uses" => "BlogController@getBlogWithArticles"]);

$router->get('/api/article/{hash}', ["uses" => "BlogController@getArticle"]);
$router->get('/api/article/{hash}/comments', ["uses" => "CommentController@index"]);

$router->get('/api/comment/{hash}', ["uses" => "CommentController@getComment"]);

$router->group(["middleware" => "secureCommentMiddleware"], function ($router) {
    $router->post('/api/comment/add', ["uses" => "CommentController@addComment"]);
});

$router->group([
    "middleware" => [
        "authMiddleware",
        "secureCommentMiddleware"
    ]
], function ($router) {
    $router->put('/api/comment/edit/{hash}', ["uses" => "CommentController@editComment"]);
});

$router->group([
    "middleware" => [
        "authMiddleware",
        "secureBlogMiddleware"
    ]
], function ($router) {
    Route::post('/api/blog', 'BlogController@addBlog');
    Route::put('/api/blog', 'BlogController@editBlog');
});

$router->group(["middleware" => "authMiddleware"], function ($router) {
    Route::get('/api/comment', 'CommentController@getAllComments');
    Route::delete('/api/comment/delete/{hash}', 'CommentController@deleteComment');
    Route::delete('/api/blog/{hash}', 'BlogController@deleteBlog');
});