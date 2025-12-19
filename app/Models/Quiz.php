<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'course_id',
        'title',
        'description',
        'quiz_type',
        'status',
        'time_limit',
        'total_questions',
        'views',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function completedAttempts()
    {
        return $this->hasMany(QuizAttempt::class)->where('status', 'completed');
    }
}
