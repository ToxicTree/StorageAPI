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
        $result = [ 'tablename' => $tableName, 'originalTablename' => $tableName ];

        $tableInfo = DB::select( "PRAGMA table_info('$tableName')" );
        
        for ($i=0 ; $i<count($tableInfo) ; $i++)
            $result['columns'][] = [
                'name' => $tableInfo[$i]->name,
                'originalName' => $tableInfo[$i]->name,
                'type' => strtoupper($tableInfo[$i]->type),
                'originalType' => strtoupper($tableInfo[$i]->type)
            ];

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

            $result[0]['data'] = RowController::rowGet($tableName,0);
            
        }

        return $result;
    }

    /**
     * Create table.
     *
     * @return array
     */
    public static function tableStore()
    {
        Schema::create('_temp_', function($table){
            
            $table->increments('id');

        });

        return TableController::tableGet('_temp_');
    }

    /**
     * Update table.
     *
     * @param  string $tableName
     * @param  object $structure
     * @return array
     */
    public static function tableUpdate($tableName,$tableInfoNew)
    {
        if (!TableController::tableExists($tableName))
            return TableController::tableStore();

        // Get Current table
        $tableInfoOld = TableController::tableInfo($tableName);

        $structureOld = $tableInfoOld['columns'];

        // Get New table
        $structureNew = $tableInfoNew['columns'];
        

        // Check for new columns
        $addThese = array();

        foreach ($structureNew as $columnNew){

            $add = true;

            foreach ($structureOld as $columnOld) {

                // Column exists
                if ($columnOld['originalName'] == $columnNew['originalName'])
                    $add = false;

            }

            // No match, add column
            if ($add)
                $addThese[] = $columnNew;

        }

        Schema::table($tableName, function($table) use ($addThese){
            
            foreach ($addThese as $column)
                $table->$column['originalType']($column['originalName'])->nullable();

        });

        // Check existing columns
        $dropThese = array();

        foreach ($structureOld as $columnOld) {
            
            $drop = true;

            foreach ($structureNew as $columnNew){

                // Column exists
                if ($columnOld['originalName'] == $columnNew['originalName'])
                    $drop = false;

            }

            // No match, drop column
            if ($drop)
                $dropThese[] = $columnOld['originalName'];

        }

        Schema::table($tableName, function($table) use ($dropThese){
            
            $table->dropColumn($dropThese);

        });

        // Check for renamed columns
        foreach ($structureNew as $columnNew){

            // Column renamed
            if (isset($columnNew['name']) && $columnNew['originalName'] != $columnNew['name']){

                Schema::table($tableName, function($table) use ($columnNew){

                    $table->renameColumn($columnNew['originalName'], $columnNew['name']);

                });
                
            }

        }

        // Check for rename table
        if ($tableInfoNew['originalTablename'] != $tableInfoNew['tablename'])
            Schema::rename($tableInfoNew['originalTablename'], $tableInfoNew['tablename']);


        return TableController::tableGet($tableInfoNew['tablename']);
    }

}
