<?php

namespace App\Helpers;

use App\Models\AdminNotification;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Batch;
use App\Models\Video;
use App\Models\CommunityQuery;
use Illuminate\Support\Facades\Log;

/**
 * NotificationHelper - Centralized notification creation utility
 * 
 * Provides methods to create notifications for various events
 * across Student, Trainer, and Admin modules
 */
class NotificationHelper
{
    /**
     * Create student notification - Course Enrolled
     */
    public static function studentCourseEnrolled($studentId, $courseName)
    {
        try {
            AdminNotification::create([
                'user_id' => $studentId,
                'type' => 'success',
                'title' => 'Course Enrolled',
                'message' => "Welcome aboard! You've been successfully enrolled in {$courseName}. Start learning today and take the next step toward your goals.",
                'link' => route('student.enroll-courses'),
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'notifications', ['action' => 'student_course_enrolled']);
        }
    }
    
    /**
     * Create trainer notification - New Enrollment
     */
    public static function trainerNewEnrollment($trainerId, $studentName, $courseName)
    {
        try {
            AdminNotification::create([
                'user_id' => $trainerId,
                'type' => 'info',
                'title' => 'New Enrollment',
                'message' => "{$studentName} has enrolled in your course {$courseName}.",
                'link' => route('trainer.courses'),
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'notifications', ['action' => 'trainer_new_enrollment']);
        }
    }
    
    /**
     * Create trainer notification - Community Query
     */
    public static function trainerCommunityQuery($trainerId, $courseName)
    {
        try {
            AdminNotification::create([
                'user_id' => $trainerId,
                'type' => 'warning',
                'title' => 'Community Query',
                'message' => "A student has posted a new question in {$courseName}. Please review and respond.",
                'link' => route('admin.community-queries.index'),
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'notifications', ['action' => 'trainer_community_query']);
        }
    }
    
    /**
     * Create trainer notification - Session Reminder
     */
    public static function trainerSessionReminder($trainerId, $sessionTitle)
    {
        try {
            AdminNotification::create([
                'user_id' => $trainerId,
                'type' => 'info',
                'title' => 'Session Reminder',
                'message' => "Your live session {$sessionTitle} will start in 15 minutes. Get ready to go live.",
                'link' => route('trainer.live-classes'),
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'notifications', ['action' => 'trainer_session_reminder']);
        }
    }
    
    /**
     * Create trainer notification - Course Enrolled (Trainer View)
     */
    public static function trainerCourseEnrolled($trainerId, $courseName)
    {
        try {
            AdminNotification::create([
                'user_id' => $trainerId,
                'type' => 'success',
                'title' => 'Course Enrolled',
                'message' => "Students have started enrolling in your course {$courseName}.",
                'link' => route('trainer.courses'),
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'notifications', ['action' => 'trainer_course_enrolled']);
        }
    }
    
    /**
     * Create admin notification - New User Registered
     */
    public static function adminNewUserRegistered($userName, $userRole)
    {
        try {
            // Notify all admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                AdminNotification::create([
                    'user_id' => $admin->id,
                    'type' => 'info',
                    'title' => 'New User Registered',
                    'message' => "{$userName} has successfully registered on the LMS as {$userRole}.",
                    'link' => route('admin.dashboard'),
                    'is_read' => false,
                ]);
            }
        } catch (\Exception $e) {
            LogHelper::exception($e, 'notifications', ['action' => 'admin_new_user_registered']);
        }
    }
    
    /**
     * Create admin notification - Course Created
     */
    public static function adminCourseCreated($trainerName, $courseName)
    {
        try {
            // Notify all admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                AdminNotification::create([
                    'user_id' => $admin->id,
                    'type' => 'success',
                    'title' => 'Course Created',
                    'message' => "Trainer {$trainerName} has created a new course {$courseName}.",
                    'link' => route('admin.courses.index'),
                    'is_read' => false,
                ]);
            }
        } catch (\Exception $e) {
            LogHelper::exception($e, 'notifications', ['action' => 'admin_course_created']);
        }
    }
    
    /**
     * Create admin notification - Batch Created
     */
    public static function adminBatchCreated($trainerName, $courseName)
    {
        try {
            // Notify all admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                AdminNotification::create([
                    'user_id' => $admin->id,
                    'type' => 'info',
                    'title' => 'Batch Created',
                    'message' => "Trainer {$trainerName} has created a new batch for {$courseName}.",
                    'link' => route('admin.trainer-module.active-batches'),
                    'is_read' => false,
                ]);
            }
        } catch (\Exception $e) {
            LogHelper::exception($e, 'notifications', ['action' => 'admin_batch_created']);
        }
    }
    
    /**
     * Create admin notification - New Video Uploaded
     */
    public static function adminVideoUploaded($trainerName, $courseName)
    {
        try {
            // Notify all admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                AdminNotification::create([
                    'user_id' => $admin->id,
                    'type' => 'info',
                    'title' => 'New Video Uploaded',
                    'message' => "Trainer {$trainerName} uploaded a new video in {$courseName}.",
                    'link' => route('admin.trainer-module.videos'),
                    'is_read' => false,
                ]);
            }
        } catch (\Exception $e) {
            LogHelper::exception($e, 'notifications', ['action' => 'admin_video_uploaded']);
        }
    }
    
    /**
     * Create admin notification - Community Query Alert
     */
    public static function adminCommunityQueryAlert()
    {
        try {
            // Notify all admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                AdminNotification::create([
                    'user_id' => $admin->id,
                    'type' => 'warning',
                    'title' => 'Community Query Alert',
                    'message' => "A new community query has been posted. Please review and take action.",
                    'link' => route('admin.community-queries.index'),
                    'is_read' => false,
                ]);
            }
        } catch (\Exception $e) {
            LogHelper::exception($e, 'notifications', ['action' => 'admin_community_query_alert']);
        }
    }
}
