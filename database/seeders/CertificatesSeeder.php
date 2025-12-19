<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Seeder;

class CertificatesSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        $courses = Course::all();

        if ($students->isEmpty() || $courses->isEmpty()) {
            $this->command->warn('No students or courses found. Please run UsersSeeder and CoursesSeeder first.');
            return;
        }

        // Create 15 certificates for completed enrollments
        for ($i = 0; $i < 15; $i++) {
            $student = $students->random();
            $course = $courses->random();
            
            $issuedDate = now()->subDays(rand(1, 180));
            $certNumber = 'G' . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT) . '/' . $issuedDate->format('y') . '-' . $issuedDate->format('m');
            
            Certificate::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'certificate_number' => $certNumber,
                'issued_at' => $issuedDate,
            ]);
        }
    }
}
