<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "name",
        "address",
        "country",
        "zipcode",
        "city",
        "phone",
        "email",
        "logo",
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}