<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ["title","status","slug"];

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function categories()
    {
        return $this->morphedByMany(Category::class, 'menuable');
    }

    /**
     * Get all of the videos that are assigned this tag.
     */
    public function foods()
    {
        return $this->morphedByMany(Food::class, 'menuable');
    }
}
