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
        if (Schema::hasTable($tableName))
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

        return DB::select("SELECT name FROM sqlite_master WHERE type='table'");
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
     * Create/Replace table.
     *
     * @param  string $tableName
     * @return true|false
     */
    public static function table_store($tableName)
    {
        if (!TableController::table_remove($tableName))
            return false;

        Schema::create($tableName, function($table){
            $table->increments('id');
            $table->text('contents');
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