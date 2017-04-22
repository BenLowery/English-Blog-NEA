<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where outes that are handled, they're are 4 main options a 
| route can take. These are based on what type of request is sent to the 
| server. Get is the most common one and used when retrieving data from the
| server when the route is accessed. post is best used when a form is sent off
| from the client, this post request is then handled appropriately. Others include,
| put and delete but these functions can also be handled with a post request so
| i will not use them for the time being.
|
*/


// Default routes of pages
Route::get('/', 'HomeController@displayPosts');
Route::get('/about', 'HomeController@displayAbout');
Route::get('/post/{slug}', 'postController@display');
Route::post('/post/{slug}', 'postController@addComment');

// Search routes
Route::get('/author/{name}', 'postController@author');
Route::get('/tag/{id}', 'postController@tags');
Route::get('/search', 'searchController@display');
Route::post('/search', 'searchController@showResults');


// Only allow logged in users on this route
Route::get('/create', 'createController@editor')->middleware('login:allow');
Route::post('/create', 'createController@publishPending');
Route::get('/dashboard', 'adminController@dashboard')->middleware('login:allow');

// Admin middleware makes sure we are just dealing with teachers (called admin here)
Route::group(['middleware' => ['role:admin']], function () {
	Route::get('/admin/manage', 'adminController@manageUsers');
	Route::get('/admin/post_review', 'adminController@displayPostReview');
	Route::get('/admin/acceptPost/{id}', 'adminController@accept');
	Route::get('/admin/denyPost/{id}', 'adminController@deny');
	Route::get('/admin/settings', 'adminController@displaySettings');
	Route::post('/admin/settings', 'adminController@updateSettings');
});

// Middleware for only students being allowed in this area
Route::group(['middleware' => ['role:student']], function () {
	Route::get('/student/subscribe/{booleanVal}', 'studentController@handleSub');
	Route::get('/student/posts', 'studentController@postManagement');
});

// Routes for login
// If session is set we redirect the user to another place
Route::group(['middleware' => 'login:redirect'], function() {
	Route::get('/login', 'loginController@loginPage');
	Route::get('/login/verify/{token}', 'loginController@VerifyLogin');
	Route::post('/login', 'loginController@SendVerify');
});


Route::get('/logout', 'loginController@logout');