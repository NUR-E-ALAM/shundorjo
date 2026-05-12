<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionImage extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','patient_name','image'];
    public function userall()
      {
          return $this->belongsTo(User::class);
      }
}
