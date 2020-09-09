<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Itstructure\LaRbac\Models\Permission;

/**
 * Class PermissionSeeder
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $this->createRecord(
            Permission::ADMINISTRATE_PERMISSION,
            'Total administrate of users and content'
        );

        $this->createRecord(
            Permission::VIEW_RECORD_PERMISSION,
            'Permission to view record'
        );

        $this->createRecord(
            Permission::CREATE_RECORD_PERMISSION,
            'Permission to create record'
        );

        $this->createRecord(
            Permission::UPDATE_RECORD_PERMISSION,
            'Permission to update record'
        );

        $this->createRecord(
            Permission::DELETE_RECORD_PERMISSION,
            'Permission to delete record'
        );

        $this->createRecord(
            Permission::PUBLISH_RECORD_PERMISSION,
            'Permission to publish record'
        );
    }

    /**
     * Create permission record in database.
     * @param string $slug
     * @param string $description
     * @return void
     */
    private function createRecord(string $slug, string $description): void
    {
        Permission::create([
            'name' => str_replace('-', ' ', ucfirst($slug)),
            'slug' => $slug,
            'description' => $description,
        ]);
    }
}
