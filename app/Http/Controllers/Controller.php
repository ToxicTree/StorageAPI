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
     * Retrieve table with the given name.
     *
     * @param  string $tableName
     * @return Response
     */
    public function t_show($tableName)
    {
        return TableController::table_show($tableName);;
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
        $table = $request->input();

        if (!TableController::table_store($tableName,$table))
        	return abort(500, "Failed to create Table '$tableName'");
        
        // Summary of the created table
        echo "<pre>";
        echo "CREATE TABLE '$tableName'\n";
        echo "(\n";
        echo "    'id' integer not null primary key autoincrement\n";
        foreach ($table as $key => $value) {
        	if ($key != "id" && $key != "tablename")
            	echo "    '$key' $value\n";
        }
        echo ")</pre>";

        return "";
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

        return "";
    }

}
