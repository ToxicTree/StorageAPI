<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ExampleTableSeeder::class);
    }

}

class ExampleTableSeeder extends Seeder {
    public function run() {

        Schema::dropIfExists('table_example');

        Schema::create('table_example', function($table){
            
            $table->increments('id');
            $table->text('text_column')->nullable();
            $table->integer('integer_column')->nullable();

        });
        
        $insert = [
            ['text_column' => 'example text', 'integer_column' => 1 ],
            ['text_column' => 'more text', 'integer_column' => 52 ]
        ];

        DB::table('table_example')->insert($insert);

    }
}
