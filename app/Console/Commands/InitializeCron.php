<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InitializeCron extends Command
{
    protected $signature = 'initialize-local';
    protected $description = 'Combining some steps for local testing';

    public function handle()
    {
        $this->info("--- Migrate fresh data ---");
        Artisan::call('migrate:fresh');

        $this->info('--- Clearing cache ---');
        $this->call('cache:clear');

        $this->info('--- Caching config and routes ---');
        $this->call('config:cache');
        $this->call('route:cache');

        $this->info("--- Seed manufacturers ---");
        Artisan::call('db:seed', [
            '--class' => 'ManufacturerSeeder',
        ]);
        $this->info("--- Seed cars ---");
        Artisan::call('db:seed', [
            '--class' => 'CarSeeder',
        ]);

        $this->info("--- Seed customers ---");
        Artisan::call('db:seed', [
            '--class' => 'CustomerSeeder',
        ]);
    }
}
