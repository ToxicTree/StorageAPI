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

    public function tableStore_(Request $request)
    {
        if (!$request->has('tablename'))
            return abort(400, "No tablename given.");

        $tableName = $request->tablename;

        if (!$request->has('columns'))
            return abort(400, "No columns given.");

        $structure = array();
        $structure['id'] = "increments";
        
        foreach ($request->columns as $column => $type) {

            if ($column != "id")                        // Don´t use these
                if ($type=="text" || $type=="integer")  // Enabled types
                    $structure[$column] = $type;

        }

        return TableController::tableStore($tableName,$structure);
    }

    public function rowStore_($tableName, Request $request)
    {
        if (!TableController::tableExists($tableName))
            return abort(404, "Table '$tableName' don´t exist.");
        
        $row = array();

        foreach ($request->input() as $column => $value) {

            if ($column != "id") // Don´t use these
                $row[$column] = $value;

        }

        $id = RowController::rowStore($tableName,$row);

        return RowController::rowGet($tableName,$id);
    }

    public function tableUpdate_($tableName, Request $request)
    {
        if (!$request->has('columns'))
            return abort(400, "No columns given.");

        $structure = array();
        $structure[] = array('originalName' => 'id', 'originalType' => "increments");

        $columns =  $request->input('columns');
        
        foreach ($columns as $columnNew){

            if ($columnNew['originalName'] != "id")                                        // Don´t use these
                if (strtoupper($columnNew['originalType'])=="TEXT" || strtoupper($columnNew['originalType'])=="INTEGER")  // Enabled types
                    $structure[] = $columnNew;

        }

        return TableController::tableUpdate($tableName,$structure);
    }

    public function rowUpdate_($tableName, $id, Request $request)
    {
        if (!TableController::tableExists($tableName))
            return abort(404, "Table '$tableName' don´t exist.");
        
        $row = array();
        $row['id'] = $id;

        foreach ($request->input() as $column => $value) {

            if ($column != "id") // Don´t use these
                $row[$column] = $value;

        }

        return RowController::rowUpdate($tableName,$row);
    }

}
