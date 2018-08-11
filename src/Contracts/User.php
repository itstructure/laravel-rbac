<?php

namespace Itstructure\LaRbac\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Itstructure\LaRbac\Models\Role;

/**
 * Interface User
 *
 * @package Itstructure\LaRbac\Contracts
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
interface User extends Authenticatable
{
    /**
     * User identifier.
     *
     * @return int
     */
    public function getIdAttribute(): int;

    /**
     * User name.
     *
     * @return string
     */
    public function getNameAttribute(): string;

    /**
     * Set new filled roles.
     *
     * @param $value
     *
     * @return void
     */
    public function setRolesAttribute($value): void;

    /**
     * Get user roles by relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles();

    /**
     * Checks if User has access to $permissions.
     *
     * @param array $permissions
     *
     * @return bool
     */
    public function hasAccess(array $permissions) : bool;

    /**
     * Checks if the user belongs to role.
     *
     * @param string $roleSlug
     *
     * @return bool
     */
    public function inRole(string $roleSlug): bool;

    /**
     * @param User $member
     * @param Role $role
     *
     * @return bool
     */
    public function canAssignRole(self $member, Role $role): bool;
}
