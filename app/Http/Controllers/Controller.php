<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;

class Controller extends BaseController
{
    /**
     * Retrieve all tables.
     *
     * @return Response
     */
    public function t_showAll()
    {
        return TableController::table_showAll();
    }

    /**
     * Retrieve all rows in table with the given name.
     *
     * @param  string $tableName
     * @return Response
     */
    public function t_show($tableName)
    {
        return TableController::table_show($tableName);
    }

    /**
     * Retrieve info about table with the given name.
     *
     * @param  string $tableName
     * @return Response
     */
    public function t_showInfo($tableName)
    {
        return TableController::table_showInfo($tableName);
    }

    /**
     * Retrieve row from table with the given id.
     *
     * @param  string $tableName
     * @param  int $id
     * @return Response
     */
    public function r_show($tableName,$id)
    {
        if (!TableController::table_exists($tableName))
            return abort(404, "Table '$tableName' don´t exist.");

        return RowController::row_show($tableName,$id);
    }

    /**
     * Create/Replace table.
     *
     * @param  Request $request
     * @return Response
     */
    public function t_store(Request $request)
    {
        if (!$request->has('tablename'))
            return abort(400, "No tablename given.");

        $tableName = $request->tablename;

        $table = array();
        $table['id'] = "increments";
        
        foreach ($request->input() as $column => $type) {
            if ($column != "id" && $column != "tablename") // Don´t use these
                if ($type=="text" || $type=="integer")     // Enabled types
                	$table[$column] = $type;
        }

        if (TableController::table_exists($tableName))
            return abort(500, "Table '$tableName' allready exists.");

        if (!TableController::table_store($tableName,$table))
        	return abort(500, "Failed to create Table '$tableName'");

        // Summary of the created table
        echo "<pre>";
        echo "CREATE TABLE '$tableName'\n";
        echo "(\n";
        foreach ($table as $column => $type) {
            echo "    '$column' $type\n";
        }
        echo ")</pre>";

        return "";
    }

    /**
     * Create/Replace row.
     *
     * @param  string $tableName
     * @param  Request $request
     * @return Response
     */
    public function r_store($tableName, Request $request)
    {
        if (!TableController::table_exists($tableName))
            return abort(404, "Table '$tableName' don´t exist.");
        
        $row = array();
        foreach ($request->input() as $column => $value) {
            if ($column != "id") // Don´t use these
                $row[$column] = $value;
        }

        $id = RowController::row_store($tableName,$row);

        if (!$id)
            return abort(500, "Failed to create row in '$tableName'");

        return RowController::row_show($tableName,$id);
    }

    /**
     * Update table.
     *
     * @param  Request $request
     * @return Response
     */
    public function t_update(Request $request)
    {
        if (!$request->has('tablename'))
            return abort(400, "No tablename given.");

        $tableName = $request->tablename;

        $table = array();
        $table['id'] = "increments";
        
        foreach ($request->input() as $column => $type) {
            if ($column != "id" && $column != "tablename") // Don´t use these
                if ($type=="text" || $type=="integer")     // Enabled types
                	$table[$column] = $type;
        }

        if (!TableController::table_update($tableName,$table))
        	return abort(500, "Failed to update Table '$tableName'");

        // Summary of the updated table
        echo "<pre>";
        echo "CREATE TABLE '$tableName'\n";
        echo "(\n";
        foreach ($table as $column => $type) {
            echo "    '$column' $type\n";
        }
        echo ")</pre>";

        return "";
    }

    /**
     * Update row.
     *
     * @param  string $tableName
     * @param  int $id
     * @param  Request $request
     * @return Response
     */
    public function r_update($tableName, $id, Request $request)
    {
        if (!TableController::table_exists($tableName))
            return abort(404, "Table '$tableName' don´t exist.");
        
        $row = array();
        foreach ($request->input() as $column => $value) {
            if ($column != "id") // Don´t use these
                $row[$column] = $value;
        }

        if (!RowController::row_update($tableName,$id,$row))
            return abort(500, "Failed to update row $id in '$tableName'");

        return RowController::row_show($tableName,$id);
    }

    /**
     * Remove table.
     *
     * @param  string $tableName
     * @return Response
     */
    public function t_remove($tableName)
    {
        if (!TableController::table_remove($tableName))
            return abort(500, "Failed to remove Table '$tableName'");

        return TableController::table_showAll();
    }

    /**
     * Remove row.
     *
     * @param  string $tableName
     * @param  int $id
     * @return Response
     */
    public function r_remove($tableName,$id)
    {
        if (!TableController::table_exists($tableName))
            return abort(404, "Table '$tableName' don´t exist.");

        if (!RowController::row_remove($tableName,$id))
            return abort(500, "Failed to remove Row $id from '$tableName'");

        return TableController::table_show($tableName);
    }

}
