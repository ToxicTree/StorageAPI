<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class Testing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display info about testing';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment(
            "\n"
            ."Run phpunit to test the application:\n\n"
            ."> vendor\bin\phpunit \n\n"
            ."$ ./vendor/bin/phpunit \n"
        );
    }
}
