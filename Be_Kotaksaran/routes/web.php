<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});



$router->post('/login', 'LoginController@login');
$router->post('/tambah-data/kotaksaran', 'KotaksaranController@store');


$router->group(['prefix' => 'api', 'middleware' => 'auth:api'], function () use ($router) {
    $router->get('/me', 'LoginController@me');
    $router->get('/refresh', 'LoginController@refresh');
    $router->post('/logout', 'LoginController@logout');

    $router->get('/data/saranall', 'KotaksaranController@index');
    $router->get('/data/chart', 'KotaksaranController@chart');
    $router->delete('/saran/delete/{id}', 'KotaksaranController@delete');

    $router->post('/tambah-data/penempatan', 'PenempatanController@store');
    $router->get('/penempatanall', 'PenempatanController@index');

    $router->post('/tambah-data/kategori', 'KategoriController@store');
    $router->get('/kategoriall', 'KategoriController@index');

    $router->post('/data/qrcode', 'QrcodeController@store');
    $router->get('/qrcode', 'QrcodeController@index');
    $router->get('/download-qrcode/{fileName}', 'QrcodeController@downloadQrCode');
});
