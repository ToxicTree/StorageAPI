<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;

class Controller extends BaseController
{

    public function databaseExists_()
    {
        if (!DatabaseController::database_exists())
            DatabaseController::database_create();

        if (DatabaseController::database_exists())
            return true;

        else
            return false;
    }


    public function tableGetAll_()
    {
        return TableController::tableGet(false);
    }

    public function tableGet_($tableName)
    {
        return TableController::tableGet($tableName);
    }

    public function tableRemove_($tableName)
    {
        TableController::tableRemove($tableName);

        return TableController::tableGet(false);
    }

    public function tableStore_()
    {
        return TableController::tableStore();
    }

    public function tableUpdate_($tableName, Request $request)
    {
        if (!$request->has('columns'))
            return abort(400, "No columns given.");

        $tableinfoNew = [
            'tablename' => $request->input('tablename'),
            'originalTablename' => $tableName,
            'columns' => [
                0 => [ 'originalName' => 'id', 'originalType' => 'increments' ]
            ]
        ];

        foreach ($request->input('columns') as $columnNew){

            if ($columnNew['originalName'] != "id")
                if (strtoupper($columnNew['originalType'])=="TEXT" || strtoupper($columnNew['originalType'])=="INTEGER")
                    $tableinfoNew['columns'][] = $columnNew;

        }

        return TableController::tableUpdate($tableName,$tableinfoNew);
    }


    public function rowGet_($tableName,$id)
    {
        return RowController::rowGet($tableName,$id);
    }

    public function rowRemove_($tableName,$id)
    {
        RowController::rowRemove($tableName,$id);

        return TableController::tableGet($tableName);
    }

    public function rowStore_($tableName)
    {
        if (!TableController::tableExists($tableName))
            return abort(404, "Table '$tableName' don´t exist.");

        return RowController::rowStore($tableName);
    }

    public function rowUpdate_($tableName, $id, Request $request)
    {
        if (!TableController::tableExists($tableName))
            return abort(404, "Table '$tableName' don´t exist.");
        
        $row = [ 'id' => $id ];

        foreach ($request->input() as $column => $value) {

            if ($column != "id")
                $row[$column] = $value;

        }

        return RowController::rowUpdate($tableName,$row);
    }

}
