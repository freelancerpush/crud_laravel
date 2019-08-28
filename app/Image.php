<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	public $timestamps = false;
	protected $fillable = [
        'image_name', 'movie_id',
    ];
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
