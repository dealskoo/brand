<?php

namespace Dealskoo\Brand\Models;

use Dealskoo\Admin\Traits\HasSlug;
use Dealskoo\Country\Traits\HasCountry;
use Dealskoo\Follow\Traits\Followable;
use Dealskoo\Like\Traits\Likeable;
use Dealskoo\Seller\Traits\HasSeller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Brand extends Model
{
    use HasFactory, SoftDeletes, HasCountry, HasSlug, HasSeller, Followable, Likeable, Searchable;

    protected $appends = ['logo_url'];

    protected $fillable = [
        'slug',
        'name',
        'website',
        'logo',
        'score',
        'description',
        'country_id',
        'seller_id',
        'approved'
    ];

    protected $casts = [
        'approved' => 'boolean'
    ];

    public function getLogoUrlAttribute()
    {
        return empty($this->logo) ? asset(config('brand.default_logo')) : Storage::url($this->logo);
    }

    public function scopeApproved(Builder $builder)
    {
        return $builder->where('approved', true);
    }

    public function shouldBeSearchable()
    {
        return $this->approved;
    }

    public function toSearchableArray()
    {
        return $this->only([
            'slug',
            'name',
            'website',
            'score',
            'description',
            'country_id',
            'seller_id'
        ]);
    }
}
