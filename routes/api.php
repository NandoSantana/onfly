<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('auth/login', 'App\Http\Controllers\Api\AuthController@login');

Route::group(['middleware' => ['apiJwt']], function(){
    
    Route::post('despesas/create', 'App\Http\Controllers\Api\DespesasController@createDespesas');
    Route::put('despesas/{id}/update', 'App\Http\Controllers\Api\DespesasController@despesasUpdate');
    Route::delete('despesas/{id}/delete', 'App\Http\Controllers\Api\DespesasController@despesasDelete');
    Route::get('despesas/show', 'App\Http\Controllers\Api\\DespesasController@index');

    Route::post('logout', 'App\Http\Controllers\Api\\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\Api\\AuthController@refresh');
    Route::get('me', 'App\Http\Controllers\Api\\AuthController@me');

});
