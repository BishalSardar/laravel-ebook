<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ebook;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['category'];

    function ebooks()
    {
        return $this->hasMany(Ebook::class);
    }
}
