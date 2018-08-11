<?php

namespace Itstructure\LaRbac\Commands;

use Illuminate\Console\Command;
use Itstructure\LaRbac\Models\Role;
use Itstructure\LaRbac\Helpers\Helper;

/**
 * Class AdminCommand
 *
 * @package Itstructure\LaRbac\Commands
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class AdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rbac:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign Admin role for existing special user';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('1. Assign Admin role for existing special user');
        if ($this->assignAdminRole()) {
            $this->info('Admin role is assigned successfully.');
        } else {
            $this->info('Admin role is not assigned.');
        }
    }

    /**
     * Assign Admin role for existing special user (which adminUserId is set in config/rbac.php file).
     *
     * @return bool
     */
    private function assignAdminRole(): bool
    {
        $userModelClass = config('rbac.userModelClass');

        if (!Helper::checkUserContract($userModelClass)) {
            $this->info(Helper::contractErrorMessage());
            return false;
        }

        if (!Helper::checkUserParent($userModelClass)) {
            $this->info(Helper::parentErrorMessage());
            return false;
        }

        $adminUserId = config('rbac.adminUserId');

        if (!$adminUserId || !is_int($adminUserId)) {
            $this->info('Identifier of desired Admin user is not defined in config file.');
            return false;
        }

        $adminUser = call_user_func([
            $userModelClass,
            'findOrFail',
        ], $adminUserId);

        if (!$adminUser) {
            $this->info('There is no user with such id: '.$adminUserId.'.');
            return false;
        }

        $adminRoleId = Role::where('slug', Role::ADMIN_ROLE)->firstOrFail()->id;

        $adminUser->roles()->attach([
            $adminRoleId
        ]);

        return true;
    }
}
