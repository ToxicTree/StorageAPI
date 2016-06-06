<?php

namespace App\Http\Controllers;

use DB;
use Schema;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Check if database exists.
     *
     * @return ture|false
     */
    public function database_exists()
    {
        if (!file_exists( database_path('database.sqlite') ))
            return false;
        return true;
    }

    /**
     * Create database.
     *
     * @return file pointer resource|false
     */
    public function database_create()
    {
        return fopen( database_path('database.sqlite') , "w");
    }


    /**
     * Retrieve all tables.
     *
     * @return Response
     */
    public function table_showAll()
    {
        if (!StorageController::database_exists())
            StorageController::database_create();
        return DB::select("SELECT name FROM sqlite_master WHERE type='table'");
    }

    /**
     * Retrieve table with the given name.
     *
     * @param  string $tableName
     * @return Response
     */
    public function table_show($tableName)
    {
        if (DB::table('sqlite_master')->where('name', $tableName)->first())
            return DB::table($tableName)->get();

        return abort(404, "Table '$tableName' not found");
    }

    /**
     * Create/Replace table.
     *
     * @param  Request $request
     * @return Response
     */
    public function table_store(Request $request)
    {
        if ($request->has('name')){
            $tableName = $request->name;

            if (DB::table('sqlite_master')->where('name', $tableName)->first())
                StorageController::table_remove($tableName);

            Schema::create($tableName, function($table){
                $table->increments('id');
                $table->text('contents');
            });

            return StorageController::table_show($tableName);

        }
        return abort(400, "No name given.");
    }

    /**
     * Remove table.
     *
     * @param  string $tableName
     * @return Response
     */
    public function table_remove($tableName)
    {
        Schema::dropIfExists($tableName);

        if (DB::table('sqlite_master')->where('name', $tableName)->first())
            return abort(500, "Couldn´t delete table '$tableName'");
    }

}
