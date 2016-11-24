<?php

// Not installed routes
Route::group(['middleware' => ['web'], 'prefix' => 'origami'], function () {
	
	Route::get('/welcome','PagesController@welcome');

	// Public routes
	Route::group(['middleware' => ['origami_check_installation']], function () {
		
		Route::get('/login','AuthController@login');
		Route::post('/login','AuthController@doLogin');
		
		// Authenticated routes
		Route::group(['middleware' => ['origami_auth', 'origami_lastseen', 'origami_cleanup']], function () {

			Route::get('/','DashboardController@dashboard');
			Route::get('/logout','AuthController@logout');
			Route::get('/entries/{module}','EntriesController@index');
			Route::get('/entries/{module}/create','EntriesController@create');
			Route::post('/entries/{module}/create','EntriesController@createEntry');
			Route::post('/entries/{module}/sort','EntriesController@sort');
			Route::any('/entries/{module}/upload','EntriesController@upload');
			Route::get('/entries/{module}/{entry}','EntriesController@edit');
			Route::post('/entries/{module}/{entry}','EntriesController@updateEntry');
			Route::get('/entries/{module}/{entry}/remove','EntriesController@remove');
			Route::get('/entries/{module}/{entry}/{field}','EntriesController@submodule');

			// Admin only routes
			Route::group(['middleware' => ['origami_admin']], function () {
				Route::get('/users','UsersController@index');
				Route::get('/users/create','UsersController@create');
				Route::post('/users/create','UsersController@createUser');
				Route::get('/users/{user}','UsersController@edit');
				Route::post('/users/{user}','UsersController@updateUser');
				Route::get('/users/{user}/remove','UsersController@remove');

				Route::get('/modules','ModulesController@index');
				Route::get('/modules/create','ModulesController@create');
				Route::post('/modules/create','ModulesController@createModule');
				Route::post('/modules/sort','ModulesController@sort');
				Route::get('/modules/{module}','ModulesController@edit');
				Route::post('/modules/{module}','ModulesController@updateModule');
				Route::get('/modules/{module}/remove','ModulesController@remove');

				Route::get('/modules/{module}/fields','FieldsController@index');
				Route::get('/modules/{module}/fields/create','FieldsController@create');
				Route::post('/modules/{module}/fields/create','FieldsController@createField');
				Route::post('/modules/{module}/fields/sort','FieldsController@sort');
				Route::get('/modules/{module}/fields/{field}','FieldsController@edit');
				Route::post('/modules/{module}/fields/{field}','FieldsController@updateField');
				Route::get('/modules/{module}/fields/{field}/remove','FieldsController@remove');
			});		

		});
		
	});

});