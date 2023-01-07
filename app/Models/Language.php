<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    
}
