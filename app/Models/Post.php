<?php

namespace App\Models;

use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\MorphToMany as MorphToManyAlias;
//use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'company_id',
        'job_title',
        'city',
        'status',
        "district",
        "remotable",
        "can_parttime",
        "min_salary",
        "max_salary",
        "currency_salary",
        "requirement",
        "start_date",
        "end_date",
        "number_applicants",
        "status",
        "is_pinned",
        "slug",
    ];
    // protected $appends = ['currency_salary_code'];
    protected static function booted()
    {
        static::creating(static function ($object) {
             // $object->user_id = auth()->id();
             $object->user_id = 1;
             $object->status = 1;
        });
    }
    public function sluggable(): array
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
    public function language(): MorphToManyAlias
    {
        // $related: bảng cần liên kết tới
        // $name :khi truyền name vào nó sẽ auto chuyển thành $name_type để biết bảng trung gian này quy định cho bảng nào
        // $table :bảng trung gian
        // $foreignPivotKey: khóa ngoại của bảng trung gian với bảng hiện tại
        // $relatedPivotKey: khóa ngoại của bảng trung gian với bảng cân liên kết
        return $this->morphToMany(
            Language::class,
                'object',
            ObjectLanguage::class,
            'object_id',
            'language_id',
        );
    }
}
