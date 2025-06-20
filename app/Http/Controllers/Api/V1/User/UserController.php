<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(
        private readonly UserService $userService ,
    )
    {
    }

    public function getUserProfile($user_name)
    {
        return $this->userService->getUserProfile($user_name);
    }
}
