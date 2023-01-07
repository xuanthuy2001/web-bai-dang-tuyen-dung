<?php

namespace App\Models;

use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'job_title',
        'company_id',
        'city',
        'status',
    ];
    // protected $appends = ['currency_salary_code'];
    protected static function booted()
    {
        static::creating(static function ($object) {
            // $object->user_id = auth()->id();
            $object->user_id = 1;
        });
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'job_title'
            ]
        ];
    }

    public function getCurrencySalaryCodeAttribute(): string
    {
        return PostCurrencySalaryEnum::getKey($this->currency_salary);
    }
    public function getStatusNameAttribute(): string
    {
        return PostStatusEnum::getKey($this->status);
    }
    // public function getSlugOptions() : SlugOptions
    // {
    //     return SlugOptions::create()
    //         ->generateSlugsFrom('name')
    //         ->saveSlugsTo('slug');
    // }
}
