<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\WaitDbAlive;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('wait_db_alive', function () {
    $this->call(WaitDbAlive::class);
})->purpose('Wait for database connection to be alive before proceeding');