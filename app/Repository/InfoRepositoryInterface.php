<?php

namespace App\Repository;

interface InfoRepositoryInterface extends RepositoryInterface
{
    public function getValue(string $key, $default = null);
}
