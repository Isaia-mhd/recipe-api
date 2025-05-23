<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ["user_id","title", "description", "ingredients", "instructions", "images"];

    protected $casts = [
        "ingredients" => "array",
        "images" => "json"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'recipe_category');
    }

    public function favorites()
    {
        return $this->belongsToMany(Favorite::class);
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }
}
