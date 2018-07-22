<?php
namespace Itstructure\LaRbac\Models;

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
     * @return bool
     */
    public function inRole(string $roleSlug): bool
    {
        return $this->roles()->where('slug', $roleSlug)->count() == 1;
    }

    /**
     * Synchronize user roles after save model.
     *
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
}
