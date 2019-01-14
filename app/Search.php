<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{

    protected $fillable = ['destination' , 'checkin' , 'checkout' , 'star_rate' , 'rooms_num' , 'adults_num' , 'children_num'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function roomadults()
    {
        return $this->hasMany('App\Roomadult');
    }

    public function roomchildren()
    {
        return $this->hasMany('App\Roomchild');
    }
}
