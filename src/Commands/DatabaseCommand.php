<?php

namespace Itstructure\LaRbac\Commands;

use Illuminate\Console\Command;

/**
 * Class DatabaseCommand
 *
 * @package Itstructure\LaRbac\Commands
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class DatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'rbac:database '.
    '{--force : Overwrite existing files by default.}'.
    '{--only= : Run only specific process. Available values: migrate, seed.}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Fill database - migrate and seed.';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        try {
            $this->info('Start fill database...');

            $callArguments = [];

            if ($this->option('force')) {
                $this->warn('Force process.');
                $callArguments['--force'] = true;
            }

            if ($this->option('only')) {
                switch ($this->option('only')) {
                    case 'migrate':
                        $this->info('Migration process...');
                        $this->call('migrate', $callArguments);
                        break;

                    case 'seed':
                        $this->info('Seeding process...');
                        $this->call('db:seed', array_merge([
                                '--class' => 'LaRbacDatabaseSeeder',
                            ], $callArguments)
                        );
                        break;

                    default:
                        $this->error('Invalid "only" argument value!');
                        return;
                        break;
                }

            } else {
                $this->info('Run all processes: migration and seeding.');
                $this->call('migrate', $callArguments);
                $this->call('db:seed', array_merge([
                        '--class' => 'LaRbacDatabaseSeeder',
                    ], $callArguments)
                );
            }

            $this->info('Filling database is completed successfully.');

        } catch (\Exception $e) {
            $this->error('Failed!');
            $this->error($e->getMessage());
        }
    }
}
