<?php

namespace Itstructure\LaRbac\Interfaces;

use Itstructure\LaRbac\Models\Role;

/**
 * Interface RbacUserInterface
 *
 * @package Itstructure\LaRbac\Interfaces
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
interface RbacUserInterface
{
    /**
     * User identifier.
     * @return mixed
     */
    public function getMemberKeyAttribute();

    /**
     * User name.
     * @return string
     */
    public function getMemberNameAttribute(): string;

    /**
     * Set new filled roles.
     * @param $value
     * @return void
     */
    public function setRolesAttribute($value): void;

    /**
     * Get user roles by relation.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles();

    /**
     * Checks if User has access to $permissions.
     * @param array $permissions
     * @return bool
     */
    public function hasAccess(array $permissions) : bool;

    /**
     * Checks if the user belongs to role.
     * @param string $roleSlug
     * @return bool
     */
    public function inRole(string $roleSlug): bool;

    /**
     * @param RbacUserInterface $member
     * @param Role $role
     * @return bool
     */
    public function canAssignRole(RbacUserInterface $member, Role $role): bool;
}
