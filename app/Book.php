<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Class Book
 * @package App
 * @author Maryfaith Mgbede <adaamgbede@gmail.com>
 */
class Book extends Model
{
    const ACTIVE = 1;
    const INACTIVE = 0;
    const STATUS_PENDING = 'pending';
    const STATUS_DEACTIVATE = 'deactivate';
    const STATUS_AVAILABLE = 'available';
    const STATUS_UNAVAILABLE = 'unavailable';

    protected $fillable = [
        'author_name', 'title', 'category_id', 'shelf_no', 'quantity'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
