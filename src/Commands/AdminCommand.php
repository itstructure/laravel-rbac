<?php

namespace Itstructure\LaRbac\Commands;

use Illuminate\Foundation\Auth\User as ParentUser;
use Illuminate\Console\Command;
use Itstructure\LaRbac\Models\Role;
use Itstructure\LaRbac\Helpers\Helper;
use Itstructure\LaRbac\Interfaces\RbacUserInterface;

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
     * @var string
     */
    protected $signature = 'rbac:admin';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Assign Admin role for existing special user.';

    /**
     * @var RbacUserInterface|ParentUser
     */
    protected $userModelClass;

    /**
     * @var int
     */
    protected $adminUserId;

    /**
     * AdminCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->userModelClass = config('rbac.userModelClass');
        $this->adminUserId = config('rbac.adminUserId');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Start assign admin role for existing special user.');

            Helper::checkUserModel($this->userModelClass);

            Helper::checkAdminUserId($this->adminUserId);

            $adminUser = Helper::retrieveUserModel($this->userModelClass, $this->adminUserId);

            $adminRoleId = Role::where('slug', Role::ADMIN_ROLE)->firstOrFail()->id;

            /** @var RbacUserInterface $adminUser */
            $adminUser->roles()->attach([
                $adminRoleId
            ]);

            $this->info('Admin role is assigned successfully.');

        } catch (\Exception $e) {
            $this->error('Failed!');
            $this->error($e->getMessage());
        }
    }
}
