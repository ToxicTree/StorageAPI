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
        if (!$request->has('name'))
            return abort(400, "No name given.");

        $tableName = $request->name;

        if (!TableController::table_store($tableName))
        	return abort(500, "Failed to create Table '$tableName'");

        return $this->t_show($tableName);
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
