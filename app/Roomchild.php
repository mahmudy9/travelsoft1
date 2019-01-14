<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roomchild extends Model
{

    protected $fillable = ['num' , 'age'];

    public function search()
    {
        return $this->belongsTo('App\Search');
    }
}
