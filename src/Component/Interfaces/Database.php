<?php
declare(strict_types=1);

namespace Exdrals\Excidia\Component\Interfaces;

interface Database {

    public function prepare(string $sql);
}
