<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory,LanguageToggle;
    protected $guarded=[];
    public function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->logo) {
                return null;
            }

            // Resolve original image path (e.g. storage/logos/xyz.png)
            $originalPath = public_path($this->logo);
            if (!file_exists($originalPath)) {
                return null;
            }

            // Cache location
            $cacheDir = storage_path('app/public/cache/logos');
            if (!is_dir($cacheDir)) {
                mkdir($cacheDir, 0755, true);
            }

            // Use model ID for caching
            $cachedFilename = "{$this->id}.webp";
            $cachedPath = "{$cacheDir}/{$cachedFilename}";

            // Check timestamps to refresh cache if source changed
            $sourceModified = filemtime($originalPath);
            $cacheModified = file_exists($cachedPath) ? filemtime($cachedPath) : 0;

            if ($sourceModified > $cacheModified) {
                // Regenerate optimized cache
                $img = Image::make($originalPath)
                    ->encode('webp', 80);

                // Optional: resize for consistent logo size
                // $img->resize(400, null, fn($c) => $c->aspectRatio());

                $img->save($cachedPath);
            }

            // Return full public URL
            return url("storage/cache/logos/{$cachedFilename}");
        });
    }
    public function models(){
        return $this->hasMany(CarModel::class);
    }
}
