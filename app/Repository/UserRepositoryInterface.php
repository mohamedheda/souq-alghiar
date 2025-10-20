<?php

namespace App\Repository;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getActiveUsers();
    public function getByUserName($user_name);
    public function paginateMerchants($per_page);
}
