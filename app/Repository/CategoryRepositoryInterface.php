<?php

namespace App\Repository;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function paginteCategories($paginate);
    public function getHomeCategories();
    public function getCategories($relations=[]);
    public function getSubCategories($parent_id);

}
