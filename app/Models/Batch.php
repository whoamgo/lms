<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'class_time',
        'max_students',
        'status',
        'thumbnail',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'class_time' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
