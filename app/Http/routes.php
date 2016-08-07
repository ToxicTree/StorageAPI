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

// Cors Fix
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE, HEAD');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Options/Preflight Fix
$app->options('/', function () { return 'OK'; });
$app->options('/{tableName}', function ($tableName) { return 'OK'; });
$app->options('/{tableName}/{id}', function ($tableName,$id) { return 'OK'; });


$app->get   ('/',            'Controller@tableGetAll_');

$app->get   ('/{tableName}', 'Controller@tableGet_');
$app->post  ('/',            'Controller@tableStore_');
$app->put   ('/{tableName}', 'Controller@tableUpdate_');
$app->delete('/{tableName}', 'Controller@tableRemove_');

$app->get   ('/{tableName}/{id}', 'Controller@rowGet_');
$app->post  ('/{tableName}',      'Controller@rowStore_');
$app->put   ('/{tableName}/{id}', 'Controller@rowUpdate_');
$app->delete('/{tableName}/{id}', 'Controller@rowRemove_');
