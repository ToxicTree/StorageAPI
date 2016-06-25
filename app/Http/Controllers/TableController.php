<?php

namespace App\Http\Controllers;

use Schema;
use DB;

class TableController extends Controller
{
    /**
     * Check if table exists
     *
     * @param  string $tableName
     * @return true|false
     */
    public static function table_exists($tableName)
    {
        if (Schema::hasTable($tableName) && $tableName!='sqlite_sequence')
            return true;
        return false;
    }

    /**
     * Retrieve all tables.
     *
     * @return array
     */
    public static function table_showAll()
    {
        if (!DatabaseController::database_exists())
            DatabaseController::database_create();

        $tables = DB::select("SELECT * FROM sqlite_master WHERE type='table' AND name!='sqlite_sequence'");

        $result = [];
        foreach ($tables as $t){
            $result[$t->name] = Schema::getColumnListing($t->name);
        }
        return $result;
    }

    /**
     * Retrieve table with the given name.
     *
     * @param  string $tableName
     * @return array|false
     */
    public static function table_show($tableName)
    {
        if (TableController::table_exists($tableName))
            return DB::table($tableName)->get();

        return null;
    }

    /**
     * Retrieve table with the given name.
     *
     * @param  string $tableName
     * @return array|false
     */
    public static function table_showInfo($tableName)
    {
        if (TableController::table_exists($tableName)){

            $tableInfo = DB::select( "PRAGMA table_info('$tableName')" );
            
            $result = [ 'tablename' => $tableName ];
            
            $result['columns'] = [];
            
            for ($i=0 ; $i<count($tableInfo) ; $i++)
                $result['columns'][] = ['name' => $tableInfo[$i]->name, 'type' => $tableInfo[$i]->type ];

            return $result;
        }

        return null;
    }

    /**
     * Create/Replace table.
     *
     * @param  string $tableName
     * @param  object $table
     * @return true|false
     */
    public static function table_store($tableName,$table)
    {
        if (!TableController::table_remove($tableName))
            return false;

        Schema::create($tableName, function($t) use ($table){
            foreach ($table as $column => $type){
                if ($column=="id")
                    $t->$type($column);
                else
                    $t->$type($column)->nullable();
            }
        });

        return true;
    }

    /**
     * Update table.
     *
     * @param  string $tableName
     * @param  object $table
     * @return true|false
     */
    public static function table_update($tableName,$table)
    {
        if (!TableController::table_exists($tableName))
            return TableController::table_store($tableName,$table);

        // Drop columns not in given table
        $drop = array();
        $oldColumns = Schema::getColumnListing($tableName);
        foreach ($oldColumns as $oldColumn){
            $keep = false;
            foreach ($table as $column => $type){
                if ($column == $oldColumn){
                    $keep = true;
                }
            }
            if ($keep==false){
                $drop[$oldColumn]="remove";
                echo "$oldColumn == DROP";
            }
        }
        $add = array();
        foreach ($table as $column => $type){
            $new = true;
            foreach ($oldColumns as $oldColumn){
                if ($column == $oldColumn){
                    $new = false;
                }
            }
            if ($new==true){
                $add[$column]=$type;
                echo "$column == NEW";
            }
        }

        Schema::table($tableName, function($t) use ($drop,$add){
            foreach ($drop as $column => $type){
                $t->dropColumn($column);
            }
            foreach ($add as $column => $type){
                $t->$type($column)->nullable();
            }
        });

        return true;
    }


    /**
     * Remove table.
     *
     * @param  string $tableName
     * @return true|false
     */
    public static function table_remove($tableName)
    {
        Schema::dropIfExists($tableName);

        if (TableController::table_exists($tableName))
            return false;

        return true;
    }

}
