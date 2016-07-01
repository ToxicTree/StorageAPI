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
    public static function tableExists($tableName)
    {
        if (Schema::hasTable($tableName) && $tableName!='sqlite_sequence')
            return true;

        return false;
    }

    /**
     * Retrieve info about table with the given name.
     *
     * @param  string $tableName
     * @return array
     */
    public static function tableInfo($tableName)
    {
        $result = [ 'tablename' => $tableName ];

        $tableInfo = DB::select( "PRAGMA table_info('$tableName')" );
        
        for ($i=0 ; $i<count($tableInfo) ; $i++)
            $result['columns'][] = ['name' => $tableInfo[$i]->name, 'type' => $tableInfo[$i]->type ];

        return $result;
    }


    /**
     * Remove table with the given name.
     *
     * @param  string $tableName
     * @return true|false
     */
    public static function tableRemove($tableName)
    {
        Schema::dropIfExists($tableName);

        if (TableController::tableExists($tableName))
            return false;

        return true;
    }

    /**
     * Retrieve table with the given name or all tables.
     *
     * @param  string $tableName
     * @return array
     */
    public static function tableGet($tableName)
    {
        $result = [];

        if (!$tableName){

            $tables = DB::select("SELECT * FROM sqlite_master WHERE type='table' AND name!='sqlite_sequence'");

            foreach ($tables as $t)
                $result[] = TableController::tableInfo($t->name);

        }

        else if (TableController::tableExists($tableName)){
            
            $result[0] = TableController::tableInfo($tableName);

            $result[0]['data'] = RowController::rowGet($tableName,false);
            
        }

        return $result;
    }

}
