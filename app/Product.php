<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title', 'article', 'description'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
