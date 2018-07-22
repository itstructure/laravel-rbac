<?php
namespace Itstructure\LaRbac\Models;

use Illuminate\Database\Eloquent\Model;
use Itstructure\LaRbac\Exceptions\InvalidConfigException;
use Itstructure\LaRbac\Helpers\Helper;

/**
 * Class Role
 *
 * @package Itstructure\LaRbac\Models
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class Role extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'permissions'
    ];

    /**
     * @var string
     */
    private $userModelClass;

    /**
     * @var array
     */
    private $_permissions;

    /**
     * Role constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->userModelClass = config('rbac.userModelClass');

        parent::__construct($attributes);
    }

    /**
     * Synchronize role permissions after save model.
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if (!parent::save($options)) {
            return false;
        }

        if (null !== $this->_permissions) {
            $this->permissions()->sync($this->_permissions);
        }

        return true;
    }

    /**
     * Get users by relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @throws InvalidConfigException
     */
    public function users()
    {
        Helper::checkUserModel($this->userModelClass);

        return $this->belongsToMany($this->userModelClass, 'user_role', 'role_id', 'user_id')->withTimestamps();
    }

    /**
     * Set name.
     * Set slug by name.
     *
     * @param $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug(strtolower($value));
    }

    /**
     * Set permissions.
     *
     * @param $value
     * @return void
     */
    public function setPermissionsAttribute($value)
    {
        $this->_permissions = $value;
    }

    /**
     * Get permissions by relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id')->withTimestamps();
    }

    /**
     * Check if role has permissions, transferred to the function.
     *
     * @param array $permissions
     * @return bool
     */
    public function hasAccess(array $permissions) : bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission))
                return true;
        }
        return false;
    }

    /**
     * Check if role has single permission, transferred to the function.
     *
     * @param string $permission
     * @return bool
     */
    private function hasPermission(string $permission) : bool
    {
        return in_array($permission, $this->permissions()->pluck('slug')->toArray());
    }
}
