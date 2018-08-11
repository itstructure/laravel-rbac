<?php

namespace Itstructure\LaRbac\Contracts;

/**
 * Interface Model
 *
 * @package Itstructure\LaRbac\Contracts
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
interface Model
{
    /**
     * Get Author id which related with user model record.
     *
     * @return int
     */
    public function getAuthorIdAttribute(): int;
}
