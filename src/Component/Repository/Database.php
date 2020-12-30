<?php
declare(strict_types=1);

namespace Exdrals\Bugebo\Component\Repository;

interface Database {
    public function prepare(string $sql);
}
