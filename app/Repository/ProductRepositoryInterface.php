<?php

namespace App\Repository;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function cursorProducts($per_page,$relations=[],$user_id=null);
    public function getSimilarProducts($product,$relations=[]);
}
