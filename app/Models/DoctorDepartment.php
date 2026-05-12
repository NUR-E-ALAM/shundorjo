<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorDepartment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'dep_id',
      ];

      public function userall()
      {
          return $this->belongsTo(User::class);
      }



}
