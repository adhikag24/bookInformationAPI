<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WriterModel extends Model
{
    protected $table = 'writers';
    protected $primaryKey = 'writer_id';

    public function books(){
        return $this->hasMany('App\BookModel', 'writer_id','writer_id');
    }
}
