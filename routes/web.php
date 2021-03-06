<?php

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

Route::get('admin',['middleware'=>'auth:admin',function(){
    return 'admin dashboard';
}]);


//Route::prefix( '{lang?}' )->middleware( 'locale' )->group( function () {

Route::group(['middleware'=>'auth'],function(){
    Route::get('/', 'PostController@index')->name('home');
    //Route::get('user/{id}', 'UserController@show');
    //Route::get('tag/{id}', 'TagController@show');
    //  Route::get('download/{id}/{name}', 'FileController@download');
    //  file
    Route::get( '/removefile/{id}/{name}/{fileid}', 'FileController@removeFile' );       //remove files from post
    Route::get( '/removecover/{id}/{filename}', 'FileController@removeCover' );            //remove cover from post
    //user
    Route::resource('user','UserController',['only' => ['show','edit','update']]);

    //comment
    Route::resource('post/comment','CommentController',['only' => ['show','store']]);


    //post resource
    Route::resource('post','PostController',['except' => ['show','index']]);
    Route::get('post/{post}/delete',['as' => 'post.delete', 'uses'=> 'PostController@delete']);
    Route::get('post/{slug}',['as' => 'post.show', 'uses'=> 'PostController@show']);
    //Route::get('user/{name}',['as' => 'user.show', 'uses'=> 'UserController@show']);
    //tag
    Route::get('tag/{tags}', [ 'as' => 'tag.show', 'uses' => 'TagController@show' ] );
	Route::get('export',  'PostController@export' );

});
Auth::routes();


//oauth
Route::get('login/{service}', 'Auth\LoginController@redirectToProvider')
->where('service', '(github|facebook)');
Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('lang/{lang}', 'Auth\LoginController@setLanguage');

Route::get('/instagram', 'UserController@redirectToProvider');
Route::get('/instagram/callback', 'UserController@handleProviderCallback');
//});
