<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;
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
