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

$app->get   ('/',            'Controller@tableGetAll_');

$app->get   ('/{tableName}', 'Controller@tableGet_');
//$app->post  ('/',            'Controller@t_store');
//$app->put   ('/{tableName}', 'Controller@t_update');
$app->delete('/{tableName}', 'Controller@tableRemove_');

$app->get   ('/{tableName}/{id}', 'Controller@rowGet_');
//$app->post  ('/{tableName}/',     'Controller@r_store');
//$app->put   ('/{tableName}/{id}', 'Controller@r_update');
$app->delete('/{tableName}/{id}', 'Controller@rowRemove_');
