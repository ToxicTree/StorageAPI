<?php

namespace App\Http\Controllers;

use Schema;
use DB;

class RowController extends Controller
{

    /**
     * Retrieve row with the given id from table with the given name.
     *
     * @param  string $tableName
     * @param  int $id
     * @return array
     */
    public static function rowGet($tableName,$id)
    {
        $result = [];

        if (TableController::tableExists($tableName)){

            if ($id)
                $result = DB::table($tableName)->where('id', $id)->get();

            else
                $result = DB::table($tableName)->get();
        }

        return $result;
    }

    /**
     * Remove row with the given id from table with the given name.
     *
     * @param  string $tableName
     * @param  int $id
     * @return true|false
     */
    public static function rowRemove($tableName,$id)
    {
        if (TableController::tableExists($tableName))
            if (DB::table($tableName)->where('id', $id)->delete())
                return true;

        return false;
    }

}
