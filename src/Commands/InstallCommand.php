<?php
namespace Itstructure\LaRbac\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use JeroenNoten\LaravelAdminLte\ServiceProvider as AdminLteServiceProvider;
use Itstructure\LaRbac\RbacServiceProvider;

/**
 * Class InstallCommand
 *
 * @package Itstructure\LaRbac\Commands
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rbac:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the RBAC package';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Starting installation process of RBAC package...');

        $this->info('1. Publishing dependent AdminLTE package assets, resources and config files');
        $this->call('vendor:publish', [
            '--provider' => AdminLteServiceProvider::class,
        ]);

        $this->info('2. Publishing the RBAC resources, database, and config files');
        $this->call('vendor:publish', [
            '--provider' => RbacServiceProvider::class,
        ]);

        $this->info('3. Dumping the autoloaded files and reloading all new files');
        $composer = $this->findComposer();
        $process = new Process($composer.' dump-autoload -o');
        $process->setTimeout(null);
        $process->setWorkingDirectory(base_path())->run();

        $this->info('Installation was successful.');
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    private function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }

        return 'composer';
    }
}
