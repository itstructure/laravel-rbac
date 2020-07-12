<?php

namespace Itstructure\LaRbac\Traits;

use Itstructure\LaRbac\Interfaces\RbacUserInterface;
use Itstructure\LaRbac\Models\{Role, Permission};

/**
 * Class Administrable
 *
 * @package Itstructure\LaRbac\Traits
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
     * @return mixed
     */
    public function getMemberKeyAttribute()
    {
        return $this->attributes[$this->getAuthIdentifierName()];
    }

    /**
     * @return string
     */
    public function getMemberNameAttribute(): string
    {
        $userNameAttributeKey = config('rbac.memberNameAttributeKey');

        if (empty($userNameAttributeKey)) {
            return '';
        }

        if (is_string($userNameAttributeKey)) {
            return $this->attributes[$userNameAttributeKey];
        }

        if (is_callable($userNameAttributeKey)) {
            return $userNameAttributeKey($this);
        }

        return '';
    }

    /**
     * Set new filled roles.
     * @param $value
     * @return void
     */
    public function setRolesAttribute($value): void
    {
        $this->_roles = $value;
    }

    /**
     * Get user roles by relation.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')->withTimestamps();
    }

    /**
     * Checks if User has access to $permissions.
     * @param array $permissions
     * @return bool
     */
    public function hasAccess(array $permissions) : bool
    {
        // check if the permission is available in any role
        /* @var Role $role */
        foreach ($this->roles()->get() as $role) {

            if($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the user belongs to role.
     * @param string $roleSlug
     * @return bool
     */
    public function inRole(string $roleSlug): bool
    {
        return $this->roles()->where('slug', $roleSlug)->count() == 1;
    }

    /**
     * Can assign role checking.
     * @param RbacUserInterface $member
     * @param Role $role
     * @return bool
     */
    public function canAssignRole(RbacUserInterface $member, Role $role): bool
    {
        if ($this->countAdministrativeRoles() == 0) {
            return false;
        }

        if ($this->getMemberKeyAttribute() != $member->getMemberKeyAttribute()) {
            return true;
        }

        if ($this->countAdministrativeRoles() > 1) {
            return true;
        }

        if (!$role->hasAccess([Permission::ADMINISTRATE_PERMISSION])) {
            return true;
        }

        if ($this->inRole($role->slug)) {
            return false;
        }

        return true;
    }

    /**
     * Synchronize user roles after save model.
     * @param array $options
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
        foreach ($this->roles()->get() as $role) {

            if($role->hasAccess([Permission::ADMINISTRATE_PERMISSION])) {
                $this->_countAdministrativeRoles += 1;
            }
        }

        return $this->_countAdministrativeRoles;
    }
}
