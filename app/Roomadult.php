<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roomadult extends Model
{

    protected $fillable = ['num' , 'age'];

    public function search()
    {
        return $this->belongsTo('App\Search');
    }
}
