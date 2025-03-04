<?php

namespace App\Repository;

interface ModelRepositoryInterface extends RepositoryInterface
{
    public function getModelsByMark($mark_id);
}
