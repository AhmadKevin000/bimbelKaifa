<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPhoto extends Model
{
    protected $table = 'landing_photos';

    protected $fillable = ['key', 'image_path', 'description'];
}
