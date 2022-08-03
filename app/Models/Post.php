<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $tabels = "posts";
    protected $fillable = [
        "content", "user_id", "image"
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            "posts_tags",
            "post_id",
            "tag_id",
            "id",
            "id"
        );
    }
}
