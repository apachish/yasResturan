<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ["title","status"];

    public function foods()
    {
        return $this->hasMany(Food::class,'category_id');
    }

    public function menus()
    {
        return $this->morphToMany(Menu::class, 'menuable')->withTimestamps();
    }
}
