<?php

namespace Dealskoo\Brand\Tests;

use Dealskoo\Brand\Traits\HasBrand;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasBrand;

    protected $fillable = ['name'];
}
