<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,LanguageToggle;
    protected $guarded=[];
    public function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->image)
                return url($this->image);
            return null;
        });
    }
}
