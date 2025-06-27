<?php

namespace App\Repository;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function cursorPosts($per_page,$relations=[]);
    public function getHomePosts($relations=[]);

}
