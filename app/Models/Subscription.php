<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'price',
        'months',
        'products',
        'featured_products',
        'comments',
        'pinned_comments',
    ];

    public function getStartsOnAttribute()
    {
        return Carbon::parse($this->created_at)->translatedFormat('d F Y');
    }

    public function getEndsOnAttribute()
    {
        return Carbon::parse($this->created_at)
            ->addMonths($this->package->months)
            ->subDay()
            ->translatedFormat('d F Y');
    }
    public function getDurationAttribute()
    {
        if ( $this->months % 12 == 0)
            return ($this->months==1? null : $this->months==1) . __('messages.year');
        return  ($this->months==1? null : $this->months==1) . __('messages.month');
    }
    public function getIsYearlyAttribute(): bool
    {
        return $this->package_id && $this->months % 12 ==0;
    }


    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
