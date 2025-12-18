<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'address',
        'avatar',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function completedEnrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id')->where('status', 'completed');
    }

    public function assignedCourses()
    {
        return $this->belongsToMany(Course::class, 'course_trainer', 'trainer_id', 'course_id');
    }

    public function loginHistory()
    {
        return $this->hasMany(LoginHistory::class);
    }

    public function lastLogin()
    {
        return $this->hasOne(LoginHistory::class)->latestOfMany('logged_in_at');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function notifications()
    {
        return $this->hasMany(AdminNotification::class);
    }

    public function unreadNotifications()
    {
        return $this->hasMany(AdminNotification::class)->where('is_read', false);
    }
}
