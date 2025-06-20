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
}
