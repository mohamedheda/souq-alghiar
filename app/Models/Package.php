<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory,LanguageToggle;

    public function priceValue():Attribute{
        return Attribute::get(fn()=> $this->price . " " . __('messages.LE'));
    }
    public function durationValue():Attribute{
        return Attribute::get(function (){
            if ( $this->months % 12 == 0)
                return "/". ($this->months==1? null : $this->months==1) . __('messages.year');
            return  "/". ($this->months==1? null : $this->months==1) . __('messages.month');
        });
    }
    public function features(){
        return $this->hasMany(PackageFeature::class);
    }
}
