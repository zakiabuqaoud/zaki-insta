<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'bio', 'hour_rate', 'avatar', 'first_name'
    ];
    protected $table = 'profiles';

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . $this->user->name;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
