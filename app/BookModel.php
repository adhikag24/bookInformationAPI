<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
  
    public function writers()
    {
        return $this->belongsToMany(WriterModel::class, 'bw_relations', 'id', 'writer_id');
    }
}
