<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['title','category_id','pcategory_id', 'details', 'photo', 'source', 'views','updated_at', 'status','meta_tag','meta_description','tags'];

    protected $dates = ['created_at'];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function category()
    {
    	return $this->belongsTo('App\Models\BlogCategory','category_id')->withDefault(function ($data) {
			foreach($data->getFillable() as $dt){
				$data[$dt] = __('Deleted');
			}
		});
    }


    public function pcategory()
    {
    	return $this->belongsTo('App\Models\Category','pcategory_id')->withDefault(function ($data) {
			foreach($data->getFillable() as $dt){
				$data[$dt] = __('Deleted');
			}
		});
    }
}
