<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $fillable = ["id","title","category_id","price","status","description","image"];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function menus()
    {
        return $this->morphToMany(Menu::class, 'menuable')->withTimestamps();
    }
}
