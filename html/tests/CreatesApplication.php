<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $initSqlFile = __DIR__ . '/../../database/couponpocket.sql';

        Artisan::call('migrate:reset');

        if (is_file($initSqlFile)) {
            DB::unprepared(file_get_contents($initSqlFile));
        }

        Artisan::call('migrate');

        return $app;
    }
}
