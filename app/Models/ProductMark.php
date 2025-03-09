<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMark extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function make()
    {
        return $this->belongsTo(Mark::class,'mark_id');
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
