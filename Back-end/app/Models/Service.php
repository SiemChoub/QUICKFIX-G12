<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $fillable = ['name','description','image','price','category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
=======
    protected $fillable = ['name','description','image','price'];
>>>>>>> 2adbd5d (merge service)
}
