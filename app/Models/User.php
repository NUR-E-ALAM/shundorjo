<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email','cid','ref_by','ref_id', 'password', 'email_verified_at', 'phone', 'status'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  public function wishlists()
  {
    return $this->hasMany(Wishlist::class);
  }

  public function customer()
  {
    return $this->hasOne(Customer::class);
  }

  public function seller()
  {
    return $this->hasOne(Seller::class);
  }

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  public function shop()
  {
    return $this->hasOne(Shop::class);
  }

  public function staff()
  {
    return $this->hasOne(Staff::class);
  }

  public function orders()
  {
    return $this->hasMany(Order::class);
  }

  public function wallets()
    {
        return $this->hasMany(Wallet::class)->orderBy('created_at', 'desc');
    }
    public function medicationuser()
    {
        return $this->hasMany(MedicationUser::class);
    }
    public function medications()
  {
    return $this->hasMany(Medication::class);
  }
  public function history()
  {
    return $this->hasMany(History::class);
  }
  public function prescriptionimage()
  {
    return $this->hasMany(PrescriptionImage::class);
  }
  public function doctordepartment()
  {
    return $this->hasMany(DoctorDepartment::class);
  }
}
