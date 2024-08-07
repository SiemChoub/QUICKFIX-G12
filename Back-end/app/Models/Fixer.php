<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixer extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'name',
        'career',
        'place',
        'tell',
    ];
}
