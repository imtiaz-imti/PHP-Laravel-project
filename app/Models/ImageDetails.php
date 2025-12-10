<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageDetails extends Model
{
    protected $table = 'image_details';

    protected $fillable = [
        'image_id',
        'like_count',
        'liked_user_ids',
    ];

    protected $casts = [
        'liked_user_ids' => 'array',
    ];

    public function image()
    {
        return $this->belongsTo(UserImage::class,'image_id');
    }
}
