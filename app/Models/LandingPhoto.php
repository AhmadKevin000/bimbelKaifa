<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPhoto extends Model
{
    protected $table = 'landing_photos';

    protected $fillable = ['key', 'image_path', 'description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function ($photo) {
            if ($photo->is_active) {
                static::where('key', $photo->key)
                    ->where('id', '!=', $photo->id)
                    ->update(['is_active' => false]);
            }
        });
    }
}
