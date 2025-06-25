<?php

namespace App\Repository;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function paginteCategories($paginate);
    public function getHomeCategories();
    public function getCategories();
    public function getSubCategories($parent_id);

}
