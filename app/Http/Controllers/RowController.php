<?php

namespace App\Http\Controllers;

use Schema;
use DB;

class RowController extends Controller
{
    /**
     * Retrieve row with the given id.
     *
     * @param  string $tableName
     * @param  int $id
     * @return array|false
     */
    public static function row_show($tableName,$id)
    {
        return DB::table($tableName)->where('id', $id)->get();
    }

    /**
     * Create/Replace row.
     *
     * @param  string $tableName
     * @param  object $row
     * @return id|false
     */
    public static function row_store($tableName,$row)
    {
        // Only use existing columns
        $insert = array();
        $hasColumns = Schema::getColumnListing($tableName);
        foreach ($hasColumns as $hasColumn){
            foreach ($row as $column => $value){
                if ($column == $hasColumn){
                    $insert[$column] = $value;
                }
            }
        }

        return DB::table($tableName)->insertGetId($insert);
    }

    /**
     * Update row.
     *
     * @param  string $tableName
     * @param  int $id
     * @param  object $row
     * @return true|false
     */
    public static function row_update($tableName,$id,$row)
    {
        // Only use existing columns
        $update = array();
        $hasColumns = Schema::getColumnListing($tableName);
        foreach ($hasColumns as $hasColumn){
            foreach ($row as $column => $value){
                if ($column == $hasColumn){
                    $update[$column] = $value;
                }
            }
        }

        return DB::table($tableName)->where('id', $id)->update($update);
    }


    /**
     * Remove row.
     *
     * @param  string $tableName
     * @param  int $id
     * @return true|false
     */
    public static function row_remove($tableName,$id)
    {
        return DB::table($tableName)->where('id', $id)->delete();
    }

}
