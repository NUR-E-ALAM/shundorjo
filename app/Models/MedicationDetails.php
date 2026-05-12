<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id', 'medication_id', 'product_id', 'variation', 'price', 'tax', 'shipping_cost', 'quantity', 'quantity',
      ];
    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
