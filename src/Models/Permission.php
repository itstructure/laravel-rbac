<?php

namespace Itstructure\LaRbac\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 *
 * @package Itstructure\LaRbac\Models
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class Permission extends Model
{
    /**
     * Permissions
     */
    const ADMINISTRATE_PERMISSION = 'administrate';
    const VIEW_RECORD_PERMISSION = 'view-record';
    const CREATE_RECORD_PERMISSION = 'create-record';
    const UPDATE_RECORD_PERMISSION = 'update-record';
    const DELETE_RECORD_PERMISSION = 'delete-record';
    const PUBLISH_RECORD_PERMISSION = 'publish-record';

    /**
     * Action flags
     */
    const ASSIGN_ROLE_FLAG = 'assign-role';
    const DELETE_MEMBER_FLAG = 'delete-member';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description',
    ];

    /**
     * Get roles by relation.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id')->withTimestamps();
    }

    /**
     * Set name.
     * Set slug by name.
     * @param $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
        $this->attributes['slug'] = Str::slug($value, '-');
    }
}
