<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;

class Controller extends BaseController
{

    public function tableGetAll_()
    {
        return TableController::tableGet(false);
    }

    public function tableGet_($tableName)
    {
        return TableController::tableGet($tableName);
    }

    public function rowGet_($tableName,$id)
    {
        return RowController::rowGet($tableName,$id);
    }


    public function tableRemove_($tableName)
    {
        TableController::tableRemove($tableName);

        return TableController::tableGet(false);
    }

    public function rowRemove_($tableName,$id)
    {
        RowController::rowRemove($tableName,$id);

        return TableController::tableGet($tableName);
    }

}
