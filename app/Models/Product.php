<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function productPhotos() {
        return $this->hasMany(ProductPhoto::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
