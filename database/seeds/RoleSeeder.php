<?php

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
     *
     * @return void
     */
    public function run()
    {
        $totalPermissionId   = Permission::where('slug', Permission::ADMIN_PERMISSION)->firstOrFail()->id;
        $viewPermissionId    = Permission::where('slug', 'view-record')->firstOrFail()->id;
        $createPermissionId  = Permission::where('slug', 'create-record')->firstOrFail()->id;
        $updatePermissionId  = Permission::where('slug', 'update-record')->firstOrFail()->id;
        $deletePermissionId  = Permission::where('slug', 'delete-record')->firstOrFail()->id;
        $publishPermissionId = Permission::where('slug', 'publish-record')->firstOrFail()->id;

        $this->createRecord(
            ucfirst(Role::ADMIN_ROLE),
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
            'Editor',
            'editor',
            'Post editor',
            [
                $viewPermissionId,
                $createPermissionId,
                $updatePermissionId,
                $deletePermissionId,
                $publishPermissionId
            ]
        );

        $this->createRecord(
            'Manager',
            'manager',
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
            'Author',
            'author',
            'Post author',
            [
                $viewPermissionId,
                $createPermissionId,
                $updatePermissionId,
                $deletePermissionId
            ]
        );

        $this->createRecord(
            'User',
            'user',
            'Simple user',
            [
                $viewPermissionId
            ]
        );
    }

    /**
     * Create role record in database.
     *
     * @param string $name
     * @param string $slug
     * @param string $description
     * @param array $permissions
     *
     * @return void
     */
    private function createRecord(string $name, string $slug, string $description, array $permissions): void
    {
        Role::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
        ])->permissions()
            ->attach($permissions);
    }
}
