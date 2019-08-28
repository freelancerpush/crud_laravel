<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
	protected $fillable = [
        //'name', 'email', 'password',
    ];
    public function genre()
    {
        return $this->belongsTo('App\Genre');
    }
    public function images()
    {
        return $this->hasMany('App\Image');
    }
}
