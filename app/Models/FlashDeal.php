<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashDeal extends Model
{
    public function flash_deal_products()
    {
        return $this->hasMany(FlashDealProduct::class);
    }
}
