<?php

namespace App\Models;

use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostStatusEnum;
use App\Enums\SystemCacheKeyEnum;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
            $object->user_id = auth()->id();
            $object->status = 1;
        });
        static::saved(static function ($object) {
            $city = $object->city;
            $arr = explode(', ', $city);
            $arrCity = getAndCachePostCities();
            foreach ($arr as $item) {
                if (in_array($item, $arrCity)) {
                    continue;
                }
                $arrCity[] = $item;
            }
            cache()->put(SystemCacheKeyEnum::POST_CITIES, $arrCity);
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
        // $related: b???ng c???n li??n k???t t???i
        // $name :khi truy???n name v??o n?? s??? auto chuy???n th??nh $name_type ????? bi???t b???ng trung gian n??y quy ?????nh cho b???ng n??o
        // $table :b???ng trung gian
        // $foreignPivotKey: kh??a ngo???i c???a b???ng trung gian v???i b???ng hi???n t???i
        // $relatedPivotKey: kh??a ngo???i c???a b???ng trung gian v???i b???ng c??n li??n k???t
        return $this->morphToMany(
            Language::class,
            'object',
            ObjectLanguage::class,
            'object_id',
            'language_id',
        );
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getLocationAttribute(): ?string
    {
        if (!empty($this->district)) {
            return $this->district . ' - ' . $this->city;
        }

        return $this->city;
    }

    public function getSalaryAttribute() : string
    {
        $val    = $this->currency_salary;
        $key    = PostCurrencySalaryEnum::getKey($val);
        $locale = PostCurrencySalaryEnum::getLocaleByVal($val);
        $format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $rate   = (double)(Config::getByKey($key));
        // dd($this->min_salary);
        if (!is_null($this->min_salary)) {
            $salary    = $this->min_salary * $rate;
            $minSalary = $format->formatCurrency($salary, $key);
        }
        if (!is_null($this->max_salary)) {
            $salary    = $this->max_salary * $rate;
            $maxSalary = $format->formatCurrency($salary, $key);
        }

        if (!empty($minSalary) && !empty($maxSalary)) {
            return $minSalary . ' - ' . $maxSalary;
        }

        if (!empty($minSalary)) {
            return __('frontpage.from_salary') . ' ' . $minSalary;
        }

        if (!empty($maxSalary)) {
            return __('frontpage.to_salary') . ' ' . $maxSalary;
        }

        return '';
    }
}
