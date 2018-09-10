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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'ParagraphController@index')->name('p.index');

Route::get('/create', 'ParagraphController@create')->name('p.create')->middleware('can:edit-article');

Route::post('/store', 'ParagraphController@store')->name('p.store')->middleware('can:edit-article');

Route::get('/{id}/edit', 'ParagraphController@edit')->name('p.edit')->middleware('can:edit-article');

Route::put('/{id}/update', 'ParagraphController@update')->name('p.update')->middleware('can:edit-article');

Route::delete('/{id}/destroy', 'ParagraphController@destroy')->name('p.destroy')->middleware('can:edit-article');

Route::get('/{p_id}/tasks', 'TaskController@index')->name('task.index');

Route::get('/{p_id}/tasks/create', 'TaskController@create')->name('task.create')->middleware('can:edit-article');

Route::post('/{p_id}/tasks/store', 'TaskController@store')->name('task.store')->middleware('can:edit-article');

Route::get('/{p_id}/tasks/{id}/edit', 'TaskController@edit')->name('task.edit')->middleware('can:edit-article');

Route::put('/tasks/{id}/update', 'TaskController@update')->name('task.update')->middleware('can:edit-article');

Route::delete('/tasks/{id}/destroy', 'TaskController@destroy')->name('task.destroy')->middleware('can:edit-article');

Route::post('/getmsg', 'AjaxController@index');

Route::get('/tasks/{id}/questions/create', 'QuestionController@create')->name('question.create')->middleware('can:edit-article');

Route::post('/tasks/{id}/questions/store', 'QuestionController@store')->name('question.store')->middleware('can:edit-article');

Route::get('/questions/{id}/edit', 'QuestionController@edit')->name('question.edit')->middleware('can:edit-article');

Route::put('/questions/{id}/update', 'QuestionController@update')->name('question.update')->middleware('can:edit-article');

Route::delete('/questions/{id}/destroy', 'QuestionController@destroy')->name('question.destroy')->middleware('can:edit-article');

Route::post('/questions/{id}/answers/store', 'AnswerController@store')->name('answer.store')->middleware('can:edit-article');

Route::delete('/answers/{id}/destroy', 'AnswerController@destroy')->name('answer.destroy')->middleware('can:edit-article');