<?php

namespace App\Repository;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function cursorProducts($per_page,$relations=[],$user_id=null);
    public function getSimilarProducts($product,$relations=[]);
    public function getHomeFeaturedProducts($relations=[]);
    public function getHomeLatestProducts($relations=[]);
    public function getHomeMostViewedProducts($relations=[]);
    public function incrementValue(string $key, int $amount = 1, $id = null);
}
