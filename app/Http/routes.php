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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'TodoListController@index');

Route::get('/get-to-do-list', 'TodoListController@getTodoList');
Route::POST('/add-to-do-list', 'TodoListController@addTodoList');
Route::DELETE('/delete-to-do-list', 'TodoListController@deleteTodoList');
