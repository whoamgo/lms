<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityQuery extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'assigned_trainer_id',
        'subject',
        'question',
        'answer',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function assignedTrainer()
    {
        return $this->belongsTo(User::class, 'assigned_trainer_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
