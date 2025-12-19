<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Web Development Fundamentals',
                'description' => 'Learn the basics of web development including HTML, CSS, and JavaScript.',
                'status' => 'active',
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(60),
                'duration_days' => 90,
                'price' => 299.99,
            ],
            [
                'title' => 'Advanced JavaScript',
                'description' => 'Master advanced JavaScript concepts including ES6+, async/await, and design patterns.',
                'status' => 'active',
                'start_date' => now()->subDays(15),
                'end_date' => now()->addDays(75),
                'duration_days' => 90,
                'price' => 399.99,
            ],
            [
                'title' => 'React.js Complete Guide',
                'description' => 'Build modern web applications with React.js, hooks, and Redux.',
                'status' => 'active',
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(80),
                'duration_days' => 90,
                'price' => 449.99,
            ],
            [
                'title' => 'Node.js Backend Development',
                'description' => 'Create scalable backend applications using Node.js and Express.',
                'status' => 'active',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(85),
                'duration_days' => 90,
                'price' => 499.99,
            ],
            [
                'title' => 'Full Stack Development',
                'description' => 'Complete full-stack development course covering frontend and backend.',
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addDays(90),
                'duration_days' => 90,
                'price' => 799.99,
            ],
            [
                'title' => 'Python Programming',
                'description' => 'Learn Python from scratch to advanced level with real-world projects.',
                'status' => 'active',
                'start_date' => now()->subDays(20),
                'end_date' => now()->addDays(70),
                'duration_days' => 90,
                'price' => 349.99,
            ],
            [
                'title' => 'Data Science with Python',
                'description' => 'Master data science using Python, pandas, numpy, and machine learning.',
                'status' => 'active',
                'start_date' => now()->subDays(8),
                'end_date' => now()->addDays(82),
                'duration_days' => 90,
                'price' => 599.99,
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'Build mobile applications for iOS and Android using React Native.',
                'status' => 'active',
                'start_date' => now()->subDays(12),
                'end_date' => now()->addDays(78),
                'duration_days' => 90,
                'price' => 549.99,
            ],
            [
                'title' => 'UI/UX Design',
                'description' => 'Learn user interface and user experience design principles and tools.',
                'status' => 'active',
                'start_date' => now()->subDays(25),
                'end_date' => now()->addDays(65),
                'duration_days' => 90,
                'price' => 399.99,
            ],
            [
                'title' => 'Digital Marketing',
                'description' => 'Comprehensive digital marketing course covering SEO, SEM, and social media.',
                'status' => 'active',
                'start_date' => now()->subDays(18),
                'end_date' => now()->addDays(72),
                'duration_days' => 90,
                'price' => 299.99,
            ],
            [
                'title' => 'Graphic Design',
                'description' => 'Master graphic design using Adobe Photoshop, Illustrator, and InDesign.',
                'status' => 'active',
                'start_date' => now()->subDays(7),
                'end_date' => now()->addDays(83),
                'duration_days' => 90,
                'price' => 349.99,
            ],
            [
                'title' => 'Content Writing',
                'description' => 'Learn professional content writing, copywriting, and content strategy.',
                'status' => 'active',
                'start_date' => now()->subDays(14),
                'end_date' => now()->addDays(76),
                'duration_days' => 90,
                'price' => 249.99,
            ],
            [
                'title' => 'Video Editing',
                'description' => 'Master video editing using Adobe Premiere Pro and After Effects.',
                'status' => 'active',
                'start_date' => now()->subDays(22),
                'end_date' => now()->addDays(68),
                'duration_days' => 90,
                'price' => 399.99,
            ],
            [
                'title' => 'Animation Course',
                'description' => 'Learn 2D and 3D animation techniques and tools.',
                'status' => 'active',
                'start_date' => now()->subDays(9),
                'end_date' => now()->addDays(81),
                'duration_days' => 90,
                'price' => 499.99,
            ],
            [
                'title' => 'SEO Course',
                'description' => 'Complete SEO course covering on-page, off-page, and technical SEO.',
                'status' => 'draft',
                'start_date' => now()->addDays(10),
                'end_date' => now()->addDays(100),
                'duration_days' => 90,
                'price' => 199.99,
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
