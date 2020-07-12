<?php

namespace Itstructure\LaRbac\Classes;

use Itstructure\LaRbac\Interfaces\RbacUserInterface;
use Itstructure\LaRbac\Models\Role;

/**
 * Class MemberToRole
 * @package Itstructure\LaRbac\Classes
 */
class MemberToRole
{
    /**
     * @var RbacUserInterface
     */
    private $member;

    /**
     * @var Role
     */
    private $role;

    /**
     * @param RbacUserInterface $member
     * @param Role $role
     * @return static
     */
    public static function make(RbacUserInterface $member, Role $role)
    {
        $obj = new static();

        $obj->member = $member;
        $obj->role = $role;

        return $obj;
    }

    /**
     * @return RbacUserInterface
     */
    public function getMember(): RbacUserInterface
    {
        return $this->member;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }
}
