<?php

namespace App\Models;

use App\Repository\InfoRepositoryInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    const ACTIVE=1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'user_name',
        'city_id',
        'address',
        'image',
        'cover',
        'phone',
        'wallet',
        'provider_id',
        'provider',
        'is_blocked',
        'otp_verified',
        'is_active',
        'subscription_ends_at',
        'subscription_active',
        'products',
        'featured_products',
        'comments',
        'pinned_comments',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function productsCount(): Attribute
    {
        return Attribute::make(get: fn() => $this->products()?->count());
    }
    public function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->image)
                return url($this->image);
            return null;
        });
    }
    public function coverUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->cover)
                return url($this->cover);
            // TODO return cached static cover if not exist
            return null;
        });
    }

    public function productsAvailableCount(): Attribute
    {
        return Attribute::make(get: fn() => is_null($this->products) ? __('messages.unlimited') : $this->products);
    }
    public function featuredProductsAvailableCount(): Attribute
    {
        return Attribute::make(get: fn() => is_null($this->featured_products) ? __('messages.unlimited') : $this->featured_products);
    }
    public function commentsAvailableCount(): Attribute
    {
        return Attribute::make(get: fn() => is_null($this->comments) ? __('messages.unlimited') : $this->comments);
    }
    public function pinnedCommentsAvailableCount(): Attribute
    {
        return Attribute::make(get: fn() => is_null($this->pinned_comments) ? __('messages.unlimited') : $this->pinned_comments);
    }
    public function subscriptionActiveTitle(): Attribute
    {
        return Attribute::make(get: fn()=> $this->subscription_active == self::ACTIVE ? __('messages.active') : __('messages.inactive'));
    }


    public function canAddProduct(): Attribute
    {
        return Attribute::make(get: function () {
            return ($this->wallet >= app(InfoRepositoryInterface::class)->getValue('product_addition_points')
                    || ! filter_var(app(InfoRepositoryInterface::class)->getValue('withdraw_points_enabled') , FILTER_VALIDATE_BOOLEAN) )
                    && !$this->is_blocked;
        });
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function token()
    {
        return JWTAuth::fromUser($this);
    }


    public function otp()
    {
        return $this->hasOne(Otp::class);
    }

    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function lastSubscription(){
        return $this->hasOne(Subscription::class)->latestOfMany();
    }
    public function subscriptions(){
        return $this->hasMany(Subscription::class)->latest();
    }
}
