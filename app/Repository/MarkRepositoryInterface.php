<?php

namespace App\Repository;

interface MarkRepositoryInterface extends RepositoryInterface
{
    public function getAllMarks();
    public function getHomeMarks();
}
