<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'parent_id', 'user_id', 'guest_name', 'guest_email', 'body', 'status', 'ip_address', 'user_agent',];

    // Relationships

    // Comment belongs to a Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Comments belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Parent Comment
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Replies
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->latest();
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
