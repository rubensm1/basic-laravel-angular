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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');

Route::get('/usuarios/lista', 'UsuarioController@all');
Route::get('/usuarios/simplificada', 'UsuarioController@simplificada');
Route::put('/usuarios/permissao/{usuarioId}',"UsuarioController@updatePermissao");
Route::get('/usuarios/logarcomo/{uid}',"UsuarioController@logarComo");
Route::post('/usuarios/{usuario}',"UsuarioController@atualizar");
Route::post('/eu', 'UsuarioController@admCandidato');
Route::get('/eu', 'UsuarioController@candidato');

Route::resource('usuarios', 'UsuarioController');
Route::get('/usuario/{id?}', 'UsuarioController@usuario');

Route::get('/logs/debug/{classe}/{id}/{modo}', 'LogsController@viewMailDebug');

Route::get('/base-downloads', 'ArquivosController@getPrefixoDownload');
Route::get('/files','ArquivosController@listFiles');
Route::put('/files/especificos','ArquivosController@getFilesEspecificos');
Route::get('/testar', 'HomeController@testar');
Route::resource('arquivos','ArquivosController');

Route::get('/config',"ConfiguracoesController@index");
Route::get('/config/all',"ConfiguracoesController@config");
Route::post('/config',"ConfiguracoesController@updateConfig");

Auth::routes();

Route::get('/css/{param1}', function ($param1) {
    $str = preg_replace('/\.[a-z0-9]*\./', '.', $param1);
    return Response::download("js/angular/".$str);
})->where('param1', '(primeicons.+|color.+|hue.+)');
Route::get('/{param2}', function ($param2) {
    return Response::download("js/angular/".$param2);
})->where('param2', '(open-sans-v15-latin.+|primeicons.+)');

Route::get('/home', 'HomeController@index')->name('home');
