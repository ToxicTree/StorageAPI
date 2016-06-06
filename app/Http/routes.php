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

$app->get   ('/',            'Controller@t_showAll');
$app->get   ('/{tableName}', 'Controller@t_show');
$app->post  ('/',            'Controller@t_store');
$app->delete('/{tableName}', 'Controller@t_remove');
