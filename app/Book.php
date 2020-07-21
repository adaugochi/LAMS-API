<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'author_name', 'title', 'category_id', 'shelf_no', 'quantity'
    ];
}
