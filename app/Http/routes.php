<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'uses' => 'HomeController@getIndex',
    'as' => 'home',
    'middleware' => 'auth'
]);


/*
|------------------------------------------------------------------------
|Authentication
|------------------------------------------------------------------------
|
|This part consists of the get and post route fors igning up the user
|The get route simply displays the signup page, while all the real
|work like authentication and the db queries is done by post
|
*/

Route::get('/signup/', [
    'as' => 'auth.signup',
    'uses' => 'AuthController@getSignup',
    'middleware' => ['guest']
]);

Route::post('/signup/', [
    'uses' => 'AuthController@postSignup',
    'middleware' => ['guest']
    //this route shares the name with the get route above
]);

Route::get('/signin', [
    'as' => 'auth.signin',
    'uses' => 'AuthController@getSignin',
    'middleware' => ['guest']
]);

Route::post('/signin', [
    'uses' => 'AuthController@postSignin',
    'middleware' => ['guest']
]);

Route::get('/signout', [
    'uses' => 'AuthController@getSignout',
    'as' => 'auth.signout',
    'middleware' => ['auth']
]);

/*
|------------------------------------------------------------------------
|Search
|------------------------------------------------------------------------
|
|search for friends 
|
*/

Route::post('/search', [
    'uses' => 'SearchController@postIndex',
    'as' => 'search'
]);


/*
|------------------------------------------------------------------------
|event routes
|------------------------------------------------------------------------
|
|display events, add and delete them(also vote)
|
*/

Route::get('/events/show/{username}', [
    'uses' => 'EventController@getIndex',
    'as' => 'events',
]);

Route::get('/events/add', [
    'uses' => 'EventController@getAdd',
    'as' => 'events.add',
    'middleware' => 'auth'
]);


Route::post('/events/add', [
    'uses' => 'EventController@postAdd',
    'middleware' => 'auth'
]);

Route::get('/events/delete/{id}', [
    'uses' => 'EventController@getDelete',
    'as' => 'events.delete',
    'middleware' => 'auth'
]);

Route::get('/events/delete/{id}', [
    'uses' => 'EventController@getDelete',
    'as' => 'events.delete',
    'middleware' => 'auth'
]);

Route::get('/events/vote/{id}/{answer}', [
    'uses' => 'EventController@getVote',
    'as' => 'events.vote',
    'middleware' => 'auth'
]);

Route::get('/events/locking/{id}/{order}', [
    'uses' => 'EventController@getLocking',
    'as' => 'events.locking',
    'middleware' => 'auth'
]);


/*
|------------------------------------------------------------------------
|Friend routes
|------------------------------------------------------------------------
|
|display friends, add new ones, delete old ones and reply to friend requests
|
*/

//display users friends
Route::get('/friends', [
    'uses' => 'FriendController@getIndex',
    'as' => 'friends',
    'middleware' => 'auth'
]);

//send a friend request
Route::get('/friends/add/{username}', [
    'uses' => 'FriendController@getAdd',
    'as' => 'friends.add',
    'middleware' => 'auth'
]);


//accept friend request
Route::get('/friends/accept/{username}', [
    'uses' => 'FriendController@getAccept',
    'as'  => 'friends.accept',
    'middleware' => 'auth'
]);

//accept friend request
Route::get('/friends/decline/{username}', [
    'uses' => 'FriendController@getDecline',
    'as'  => 'friends.decline',
    'middleware' => 'auth'
]);


//delete a friend
Route::get('/friends/delete/{username}', [
    'uses' => 'FriendController@getDelete',
    'as'  => 'friends.delete',
    'middleware' => 'auth'
]);

