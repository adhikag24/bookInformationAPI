<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WriterModel extends Model
{
    protected $table = 'writers';
    protected $primaryKey = 'id';

    public function books()
    {
        return $this->belongsToMany(BookModel::class, 'bw_relations', 'id', 'book_id')->select(['book_title', 'book_release', 'book_page']);
    }

    protected $fillable = [
        'writer_name', 'writer_age'
    ];
}
