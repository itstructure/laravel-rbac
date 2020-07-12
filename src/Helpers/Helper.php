<?php

namespace Itstructure\LaRbac\Helpers;

use Exception;
use Illuminate\Foundation\Auth\User as ParentUser;
use Itstructure\LaRbac\Interfaces\RbacUserInterface;

/**
 * Class Helper
 *
 * @package Itstructure\LaRbac\Helpers
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class Helper
{
    /**
     * Check user model for be implemented by RbacUserInterface and extended of parent Auth User model.
     * @param string|null $userModelClass
     * @throws Exception
     */
    public static function checkUserModel(string $userModelClass = null)
    {
        if (empty($userModelClass)) {
            throw new Exception('User Model class is not defined in "rbac" config file.');
        }

        static::checkUserModelInterface($userModelClass, RbacUserInterface::class);

        static::checkUserModelParent($userModelClass, ParentUser::class);
    }

    /**
     * Check user model for be implemented by RbacUserInterface.
     * @param string $userModelClass
     * @param string $interfaceClass
     * @throws Exception
     */
    public static function checkUserModelInterface(string $userModelClass, string $interfaceClass): void
    {
        $userModelInterfaces = class_implements($userModelClass);

        if (!isset($userModelInterfaces[$interfaceClass])) {
            throw new Exception('User Model class must be implemented from "'.$interfaceClass.'".');
        }
    }

    /**
     * Check user model for instance of parent Auth User model.
     * @param string $userModelClass
     * @param string $parentClass
     * @throws Exception
     */
    public static function checkUserModelParent(string $userModelClass, string $parentClass): void
    {
        $userModelParents = class_parents($userModelClass);

        if (!isset($userModelParents[$parentClass])) {
            throw new Exception('User Model class should be extended from "'.$parentClass.'".');
        }
    }

    /**
     * Check a primary key type of a User model.
     * @param ParentUser $userModelObject
     * @throws Exception
     */
    public static function checkUserModelKeyType(ParentUser $userModelObject): void
    {
        if (!in_array($userModelObject->getKeyType(), ['int', 'integer'])) {
            throw new Exception('User Model keyType must be type of "int".');
        }
    }

    /**
     * Check a primary key type of a users table.
     * @param string $userTablePrimaryType
     * @param string $userModelKeyName
     * @param string $userModelTable
     * @throws Exception
     */
    public static function checkUserTablePrimaryType(string $userTablePrimaryType, string $userModelKeyName, string $userModelTable): void
    {
        if (!in_array($userTablePrimaryType, ['bigint', 'integer'])) {
            throw new Exception('Primary key "'.$userModelKeyName.'" in "'.$userModelTable.'" table must be type of "bigint" or "integer"');
        }
    }

    /**
     * Check for correct defining of an Admin user ID value at the beginning package installation.
     * @param int|null $adminUserId
     * @throws Exception
     */
    public static function checkAdminUserId(int $adminUserId = null): void
    {
        if (empty($adminUserId) || !is_int($adminUserId)) {
            throw new Exception('Identifier of a desired Admin user is not defined in "rbac" config file.');
        }
    }

    /**
     * Retrieve user model entity.
     * @param string $userModelClass
     * @param int $adminUserId
     * @return mixed
     * @throws Exception
     */
    public static function retrieveUserModel(string $userModelClass, int $adminUserId)
    {
        return call_user_func([
            $userModelClass,
            'findOrFail',
        ], $adminUserId);
    }
}
