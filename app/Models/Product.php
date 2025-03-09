<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function priceValue(): Attribute
    {
        return Attribute::get(function () {
            $formatter = numfmt_create(app()->getLocale(), \NumberFormatter::DECIMAL);
            return numfmt_format($formatter, $this->price);
        });
    }
    public function productCurrency(): Attribute
    {
        return Attribute::get(function () {
            return __('messages.LE');
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function markes()
    {
        return $this->hasMany(ProductMark::class);
    }
}
