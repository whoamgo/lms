<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiringApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'position',
        'cover_letter',
        'resume',
        'status',
        'admin_notes',
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
