<?php
namespace Itstructure\LaRbac\Commands;

use Illuminate\Console\Command;

/**
 * Class DatabaseCommand
 *
 * @package Itstructure\LaRbac\Commands
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class DatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rbac:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill database - migrate and seed';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Starting fill database (migrate and seed)...');

        $this->info('1. Running migration');
        $this->call('migrate');

        $this->info('2. Seeding data into the database');
        $this->call('db:seed', [
            '--class' => \LaRbacDatabaseSeeder::class,
        ]);

        $this->info('Filling database was successful.');
    }
}
