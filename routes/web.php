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

Route::get('/', 'ViewsController@index');

Route::post('/grupos/create', 'GrupoController@create')->name('grupos.create');
Route::put('/grupos/{id}', 'GrupoController@update')->name('grupos.update');
Route::delete('/grupos/{id}', 'GrupoController@delete')->name('grupos.delete');
Route::get('/grupos/{id}/editar', 'GrupoController@editar')->name('grupos.editar');

Route::post('/estudiantes/create', 'EstudianteController@create')->name('estudiantes.create');
Route::put('/estudiantes/{id}', 'EstudianteController@update')->name('estudiantes.update');
Route::get('/estudiantes/{id}/editar', 'EstudianteController@editar')->name('estudiantes.editar');
Route::delete('/estudiantes/{id}', 'EstudianteController@delete')->name('estudiantes.delete');