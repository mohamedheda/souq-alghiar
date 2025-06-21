<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Http\Enums\UserType;
use App\Models\User;
use App\Repository\InfoRepositoryInterface;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('add-product', function (User $user, $featured) {
//            if ($user->is_blocked)
//                return Response::deny(__('messages.user_blocked'));
//            elseif ($featured && $user?->wallet < app(InfoRepositoryInterface::class)->getValue('featured_product_points')
//                && filter_var(app(InfoRepositoryInterface::class)->getValue('withdraw_points_enabled'), FILTER_VALIDATE_BOOLEAN))
//                return Response::deny(__('messages.featured_product_points_required'));
//            elseif (!$featured && $user?->wallet < app(InfoRepositoryInterface::class)->getValue('product_addition_points')
//                && filter_var(app(InfoRepositoryInterface::class)->getValue('withdraw_points_enabled'), FILTER_VALIDATE_BOOLEAN))
//                return Response::deny(__('messages.product_addition_points_required'));
//            elseif ($user?->productsCount >= app(InfoRepositoryInterface::class)->getValue('free_product_limit_user')
//                && $user->type == UserType::User->value)
//                return Response::deny(__('messages.free_product_limit_reached'));
//            else
                return Response::allow();
        });
        Gate::define('add-comment', function (User $user, $featured) {
                return Response::allow();
        });
    }
}
