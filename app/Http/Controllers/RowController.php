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
    public static function rowRemove($tableName,$ids)
    {
        if (TableController::tableExists($tableName))
            if (DB::table($tableName)->whereIn('id', $ids)->delete())
                return true;

        return false;
    }

    /**
     * Create rows in table with the given name.
     *
     * @param  string $tableName
     * @return array
     */
    public static function rowStore($tableName,$data)
    {
        // Get existing columns
        $table = TableController::tableGet($tableName)[0];

        $insert = [];

        $update = [];

        if ($data){
            
            for ($i=0 ; $i<count($data) ; $i++){
                // Unique check
                $unique = true;

                for ($d=0 ; $d<count($table['data']) ; $d++){

                    //if unique-marked
                    if ($table['data'][$d]->PostID == $data[$i]['PostID']){
                        $unique = false;
                    }
                }

                if ($unique){
                    $insert[$i] = [];
                    foreach ($table['columns'] as $column)
                        if ($column['originalName'] != 'id')
                            if ( isset($data[$i][ $column['originalName'] ]) )
                                $insert[$i][ $column['originalName'] ] = $data[$i][ $column['originalName'] ];
                }
            }

            DB::table($tableName)->insert($insert);

            return TableController::tableGet($tableName);

        }
        else {

            foreach ($table['columns'] as $column)
                if ($column['originalName'] != 'id')
                    $insert[ $column['originalName'] ] = '0' ;
            
            $id = DB::table($tableName)->insertGetId($insert);

            return RowController::rowGet($tableName, $id);

        }

    }

    /**
     * Update row in table with the given name.
     *
     * @param  string $tableName
     * @param  object $row
     * @return array
     */
    public static function rowUpdate($tableName,$row)
    {
        $update = [];

        // Get existing columns
        $table = TableController::tableGet($tableName)[0];



        foreach ($table['columns'] as $columnT){

            foreach ($row as $columnR => $valueR){

                if ($columnR == $columnT['name'] && $columnT['name'] != 'id'){

                    // Unique check
                    $unique = true;
                    $uniqueColumn = 'PostID';

                    //if unique-marked
                    if ( $columnT['name']==$uniqueColumn && isset($row[$uniqueColumn]) )

                        for ($d=0 ; $d<count($table['data']) ; $d++){

                            if ($table['data'][$d]->$uniqueColumn == $row[$uniqueColumn])

                                $unique = false;
                            
                        }


                    if ($unique)

                        $update[$columnR] = $valueR;

                }

            }

        }

        DB::table($tableName)->where('id', $row['id'])->update($update);

        return RowController::rowGet($tableName,$row['id']);
    }

}
