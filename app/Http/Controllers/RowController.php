<?php

namespace App\Http\Controllers;

use Schema;
use DB;

class RowController extends Controller
{

    /**
     * Retrieve row with the given id (or all) from table with the given name.
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

    /**
     * Create row.
     *
     * @param  string $tableName
     * @param  object $row
     * @return array
     */
    public static function rowStore($tableName)
    {
        $insert = [];

        // Get existing columns
        $structure = TableController::tableInfo($tableName);

        foreach ($structure['columns'] as $column)
            if ($column['originalName'] != 'id')
                $insert[ $column['originalName'] ]= ' ' ;


        $id = DB::table($tableName)->insertGetId($insert);

        return RowController::rowGet($tableName, $id);
    }

    /**
     * Update row.
     *
     * @param  string $tableName
     * @param  object $row
     * @return array
     */
    public static function rowUpdate($tableName,$row)
    {
        $update = array();

        // Only use existing columns
        $structure = TableController::tableInfo($tableName);

        foreach ($structure['columns'] as $column){

            foreach ($row as $columnR => $valueR){

                if ($columnR == $column['name'] && $column['name'] != 'id')
                    $update[$columnR] = $valueR;

            }

        }

        DB::table($tableName)->where('id', $row['id'])->update($update);

        return RowController::rowGet($tableName,$row['id']);
    }

}
