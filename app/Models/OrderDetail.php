<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    use HasFactory;
    protected $fillable = [
        'order_id', 'seller_id', 'product_id', 'variation', 'price', 'tax', 'shipping_cost', 'quantity', 'payment_status', 'delivery_status'
      ];
}
