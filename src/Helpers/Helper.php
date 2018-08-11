<?php

namespace Itstructure\LaRbac\Helpers;

use Itstructure\LaRbac\Exceptions\InvalidConfigException;
use Itstructure\LaRbac\Contracts\User as UserContract;

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
     * @var string
     */
    private static $parentNeed = 'Illuminate\Foundation\Auth\User';

    /**
     * Check user model for instance of UserContract and parent Auth User model.
     *
     * @param string $userModelClass
     *
     * @throws InvalidConfigException
     */
    public static function checkUserModel(string $userModelClass)
    {
        if (!self::checkUserContract($userModelClass)) {
            throw new InvalidConfigException(self::contractErrorMessage());
        }

        if (!self::checkUserParent($userModelClass)) {
            throw new InvalidConfigException(self::parentErrorMessage());
        }
    }

    /**
     * Check user model for instance of UserContract.
     *
     * @param string $userModelClass
     *
     * @return bool
     */
    public static function checkUserContract(string $userModelClass): bool
    {
        $userModelInterfaces = class_implements($userModelClass);

        if (isset($userModelInterfaces[UserContract::class])) {
            return true;
        }

        return false;
    }

    /**
     * Check user model for instance of parent Auth User model.
     *
     * @param string $userModelClass
     * @param string $parentNeed
     *
     * @return bool
     */
    public static function checkUserParent(string $userModelClass, string $parentNeed = null): bool
    {
        $userModelParents = class_parents($userModelClass);

        $parentNeed = $parentNeed ?? self::$parentNeed;

        if (isset($userModelParents[$parentNeed])) {
            return true;
        }

        return false;
    }

    /**
     * Get error message if user model is not an instance of UserContract.
     *
     * @return string
     */
    public static function contractErrorMessage(): string
    {
        return 'User Model class must be instance of '.UserContract::class.'.';
    }

    /**
     * Get error message if user model is not an instance of parent Auth User model.
     *
     * @param string $parentNeed
     *
     * @return string
     */
    public static function parentErrorMessage(string $parentNeed = null): string
    {
        $parentNeed = $parentNeed ?? self::$parentNeed;

        return 'User Model class should extend from '.$parentNeed.'.';
    }
}
