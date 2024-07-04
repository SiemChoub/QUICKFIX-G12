<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookin_immediately extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id', 'image', 'message'
    ];
}
