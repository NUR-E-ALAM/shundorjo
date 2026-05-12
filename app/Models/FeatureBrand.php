<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureBrand extends Model
{
    public function brand()
    {
        return $this->hasOne(Brand::class,'id','brand_id');
    }
}

