<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'author', 'desc', 'category_id', 'image', 'pdf'];

    function category()
    {
        return $this->belongsTo(Ebook::class);
    }
}
