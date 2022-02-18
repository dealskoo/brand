<?php

namespace Dealskoo\Brand\Traits;

use Dealskoo\Brand\Models\Brand;

trait HasBrand
{
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
