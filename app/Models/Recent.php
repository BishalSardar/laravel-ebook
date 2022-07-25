<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recent extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ebook_id'];


    function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }
}
