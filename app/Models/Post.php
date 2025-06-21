<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderByDesc('pinned')->latest();
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function mark(){
        return $this->belongsTo(Mark::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }
}
