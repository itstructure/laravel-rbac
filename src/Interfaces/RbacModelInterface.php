<?php

namespace Itstructure\LaRbac\Interfaces;

/**
 * Interface RbacModelInterface
 *
 * @package Itstructure\LaRbac\Interfaces
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
interface RbacModelInterface
{
    /**
     * Get Author id which related with user model record.
     * @return int
     */
    public function getAuthorIdAttribute(): int;
}
