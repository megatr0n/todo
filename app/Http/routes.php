<?php
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->middleware('guest');

	Route::post('/update-items', 'TaskController@updateItems')->name('update.items');	
    Route::get('/tasks', 'TaskController@index');
	//Route::get('/tasks', 'TaskController@itemView');
    Route::post('/task', 'TaskController@store');
    Route::delete('/task/{task}', 'TaskController@destroy');
	
	//route drag and drop demo found here https://www.codecheef.org/article/laravel-jquery-drag-and-drop-with-sortable-data-example
	//Route::get('/', 'ItemController@itemView');
	//Route::post('/update-items', 'ItemController@updateItems')->name('update.items');
	
    Route::auth();

});
