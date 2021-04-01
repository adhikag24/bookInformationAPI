<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'book_id';
}