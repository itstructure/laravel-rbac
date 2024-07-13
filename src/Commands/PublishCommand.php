<?php

namespace Itstructure\LaRbac\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Itstructure\LaRbac\RbacServiceProvider;

/**
 * Class PublishCommand
 *
 * @package Itstructure\LaRbac\Commands
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'rbac:publish '.
    '{--force : Overwrite existing files by default.}'.
    '{--only= : Publish only specific part. Available parts: config, views, lang, migrations, seeders. This option can not be used.}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Publish the RBAC package parts.';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->info('Starting publication process of RBAC package parts...');

        $callArguments = ['--provider' => RbacServiceProvider::class];

        $dumpAutoload = false;

        if ($this->option('only')) {
            switch ($this->option('only')) {
                case 'config':
                    $this->info('Publish just a part: config.');
                    $callArguments['--tag'] = 'config';
                    break;

                case 'views':
                    $this->info('Publish just a part: views.');
                    $callArguments['--tag'] = 'views';
                    break;

                case 'lang':
                    $this->info('Publish just a part: lang.');
                    $callArguments['--tag'] = 'lang';
                    break;

                case 'migrations':
                    $this->info('Publish just a part: migrations.');
                    $callArguments['--tag'] = 'migrations';
                    $dumpAutoload = true;
                    break;

                case 'seeders':
                    $this->info('Publish just a part: seeders.');
                    $callArguments['--tag'] = 'seeders';
                    $dumpAutoload = true;
                    break;

                default:
                    $this->error('Invalid "only" argument value!');
                    return;
                    break;
            }

        } else {
            $this->info('Publish all parts: config, views, lang, migrations, seeders.');
            $dumpAutoload = true;
        }

        if ($this->option('force')) {
            $this->warn('Force publishing.');
            $callArguments['--force'] = true;
        }

        $this->call('vendor:publish', $callArguments);

        if ($dumpAutoload) {
            $this->info('Dumping the autoloaded files and reloading all new files.');
            $composer = $this->findComposer();
            $process = Process::fromShellCommandline($composer.' dump-autoload -o');
            $process->setTimeout(null);
            $process->setWorkingDirectory(base_path())->run();
        }
    }

    /**
     * Get the composer command for the environment.
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
