<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserComment extends Model
{
    protected $table = 'user_comments';

    protected $fillable = [
        'image_id',
        'user_id',
        'parent_id',
        'comment',
        'like_count',
        'liked_user_ids'
    ];

    protected $casts = [
        'liked_user_ids' => 'array',
    ];

    public function image()
    {
        return $this->belongsTo(UserImage::class,'image_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
