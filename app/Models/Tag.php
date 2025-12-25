<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    // Relationship
    public function posts()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Summary of scopePopular
     * Popular Tags by Post count
     * @param mixed $query
     */
    public function scopePopular($query)
    {
        return $query->withCount('posts')->orderByDesc('posts_count');
    }

    /**
     * Summary of scopeAlphbetical
     * Tags sort Alphabetically
     * @param mixed $query
     */
    public function scopeAlphbetical($query)
    {
        return $query->orderBy('name');
    }
}
