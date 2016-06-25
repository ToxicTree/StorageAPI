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

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, OPTIONS, PUT, PATCH');
header("Access-Control-Allow-Headers: Authorization, X-Requested-With,  Content-Type, Accept");

$app->get   ('/',            'Controller@t_showAll');
$app->get   ('/{tableName}/info', 'Controller@t_showInfo');

$app->get   ('/{tableName}', 'Controller@t_show');
$app->post  ('/',            'Controller@t_store');
$app->put   ('/{tableName}', 'Controller@t_update');
$app->patch ('/{tableName}', 'Controller@t_update');
$app->delete('/{tableName}', 'Controller@t_remove');

$app->get   ('/{tableName}/{id}', 'Controller@r_show');
$app->post  ('/{tableName}/',     'Controller@r_store');
$app->put   ('/{tableName}/{id}', 'Controller@r_update');
$app->patch ('/{tableName}/{id}', 'Controller@r_update');
$app->delete('/{tableName}/{id}', 'Controller@r_remove');
