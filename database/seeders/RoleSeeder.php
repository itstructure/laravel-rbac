<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Itstructure\LaRbac\Models\{Role, Permission};

/**
 * Class RoleSeeder
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $totalPermissionId   = Permission::where('slug', Permission::ADMINISTRATE_PERMISSION)->firstOrFail()->id;
        $viewPermissionId    = Permission::where('slug', Permission::VIEW_RECORD_PERMISSION)->firstOrFail()->id;
        $createPermissionId  = Permission::where('slug', Permission::CREATE_RECORD_PERMISSION)->firstOrFail()->id;
        $updatePermissionId  = Permission::where('slug', Permission::UPDATE_RECORD_PERMISSION)->firstOrFail()->id;
        $deletePermissionId  = Permission::where('slug', Permission::DELETE_RECORD_PERMISSION)->firstOrFail()->id;
        $publishPermissionId = Permission::where('slug', Permission::PUBLISH_RECORD_PERMISSION)->firstOrFail()->id;

        $this->createRecord(
            Role::ADMIN_ROLE,
            'Administrator',
            [
                $totalPermissionId,
                $viewPermissionId,
                $createPermissionId,
                $updatePermissionId,
                $deletePermissionId,
                $publishPermissionId
            ]
        );

        $this->createRecord(
            Role::MANAGER_ROLE,
            'Content manager',
            [
                $viewPermissionId,
                $createPermissionId,
                $updatePermissionId,
                $deletePermissionId,
                $publishPermissionId
            ]
        );

        $this->createRecord(
            Role::EDITOR_ROLE,
            'Record editor',
            [
                $viewPermissionId,
                $createPermissionId,
                $updatePermissionId,
                $deletePermissionId,
                $publishPermissionId
            ]
        );

        $this->createRecord(
            Role::USER_ROLE,
            'Simple user',
            [
                $viewPermissionId
            ]
        );
    }

    /**
     * Create role record in database.
     * @param string $slug
     * @param string $description
     * @param array $permissions
     * @return void
     */
    private function createRecord(string $slug, string $description, array $permissions): void
    {
        Role::create([
            'name' => ucfirst($slug),
            'slug' => $slug,
            'description' => $description,
        ])->permissions()
            ->attach($permissions);
    }
}
