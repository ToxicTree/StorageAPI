<?php

namespace App\Http\Controllers;

class DatabaseController extends Controller
{

    /**
     * Check if database exists.
     *
     * @return ture|false
     */
    public static function databaseExists()
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
    public static function databaseCreate()
    {
        return fopen( database_path('database.sqlite') , "w");
    }

}
