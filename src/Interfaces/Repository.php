<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Interfaces;

interface Repository 
{
    /**
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool;
    
    /**
     * 
     * @return array|null
     */
    public function findAll() : ?array;

    /**
     * @param   int $offset
     * @param   int $limit
     * @return array|null
     */
    public function findAllByRange(int $offset, int $limit) : ?array;
}
