<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', ['as' => 'index', 'uses' => 'MainController@index']);
$router->get('/product/{productId}', ['as' => 'product', 'uses' => 'MainController@product']);
$router->post('/addcart', ['as' => 'addcart', 'uses' => 'MainController@addcart']);
$router->get('/cart', ['as' => 'cart', 'uses' => 'MainController@cart']);
$router->post('/checkout', ['as' => 'checkout', 'uses' => 'MainController@checkout']);
$router->post('/updateCart', ['as' => 'updateCart', 'uses' => 'MainController@updateCart']);
