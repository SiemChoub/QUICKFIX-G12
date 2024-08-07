<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =
    [
        // 'user_id',
        'price',
        'deadline',
        'description',
        // 'status',
    ];

    public function user():BelongsToMany {
        return $this->belongsToMany(User::class, 'user_id', 'id');
    }
}
