<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satsang extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'title',
        'description',
        'visibility',
        'scheduled_at',
        'time',
        'timezone',
        'thumbnail',
        'create_playlist',
        'status',
        'meeting_link',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'create_playlist' => 'boolean',
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
