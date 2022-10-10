<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'path'
    ];

    public function scopeIdDescending($query)
    {
        return $query->orderBy('id','DESC');
    }
}
