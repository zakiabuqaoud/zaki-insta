<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public $timestamps = false;
    public function posts()
    {
        return $this->belongsToMany(
            post::class,
            "posts_tags",
            "tag_id",
            "post_id",
            "id",
            "id"
        );
    }
}
