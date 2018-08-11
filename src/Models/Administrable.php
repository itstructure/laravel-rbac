<?php

namespace Itstructure\LaRbac\Models;

use Itstructure\LaRbac\Contracts\User as RbacUserContract;

/**
 * Class Administrable
 *
 * @package Itstructure\LaRbac\Models
 */
trait Administrable
{
    /**
     * New filled roles.
     *
     * @var array
     */
    private $_roles;

    /**
     * @var int|null
     */
    private $_countAdministrativeRoles;

    /**
     * User identifier.
     *
     * @return int
     */
    public function getIdAttribute(): int
    {
        return $this->attributes['id'];
    }

    /**
     * User name.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Set new filled roles.
     *
     * @param $value
     *
     * @return void
     */
    public function setRolesAttribute($value): void
    {
        $this->_roles = $value;
    }

    /**
     * Get user roles by relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')->withTimestamps();
    }

    /**
     * Checks if User has access to $permissions.
     *
     * @param array $permissions
     *
     * @return bool
     */
    public function hasAccess(array $permissions) : bool
    {
        // check if the permission is available in any role
        /* @var Role $role */
        foreach ($this->roles as $role) {

            if($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the user belongs to role.
     *
     * @param string $roleSlug
     *
     * @return bool
     */
    public function inRole(string $roleSlug): bool
    {
        return $this->roles()->where('slug', $roleSlug)->count() == 1;
    }

    /**
     * Can assign role checking.
     *
     * @param RbacUserContract $member
     * @param Role $role
     *
     * @return bool
     */
    public function canAssignRole(RbacUserContract $member, Role $role): bool
    {
        if ($this->countAdministrativeRoles() == 0) {
            return false;
        }

        if ($this->getIdAttribute() != $member->getIdAttribute()) {
            return true;
        }

        if ($this->countAdministrativeRoles() > 1) {
            return true;
        }

        if (!$role->hasAccess([Permission::ADMIN_PERMISSION])) {
            return true;
        }

        if ($this->inRole($role->slug)) {
            return false;
        }

        return true;
    }

    /**
     * Synchronize user roles after save model.
     *
     * @param array $options
     *
     * @return bool
     */
    public function save(array $options = [])
    {
        if (!parent::save($options)) {
            return false;
        }

        if (null !== $this->_roles) {
            $this->roles()->sync($this->_roles);
        }

        return true;
    }

    /**
     * @return int
     */
    private function countAdministrativeRoles(): int
    {
        if (null !== $this->_countAdministrativeRoles) {
            return $this->_countAdministrativeRoles;
        }

        $this->_countAdministrativeRoles = 0;

        /* @var Role $role */
        foreach ($this->roles as $role) {

            if($role->hasAccess([Permission::ADMIN_PERMISSION])) {
                $this->_countAdministrativeRoles += 1;
            }
        }

        return $this->_countAdministrativeRoles;
    }
}
