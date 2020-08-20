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

Route::get('/', function () {
	$config = array();
    $config['center'] = 'New York, USA';
	$config['zoom'] = '2';
	$config['map_height'] = '500px';
	//$congig['map_width'] = '500px';
	$config['scrollwheel'] = false;

	GMaps::initialize($config);

	// $marker['position'] = 'Air Canada Center, Toronto';
	// $marker['infowindow_content'] = 'Air Canada Center';

	$map = GMaps::create_map();

    return view('welcome')->with('map', $map);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
