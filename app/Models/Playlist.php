<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'title',
        'description',
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'playlist_video')
            ->withPivot('order')
            ->orderBy('playlist_video.order');
    }
}
