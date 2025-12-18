# LMS - Learning Management System

A comprehensive Learning Management System built with Laravel 11 and MySQL, featuring role-based access for Admin, Trainer (Instructor), and Student.

## Features

### Admin Module
- Dashboard with system overview
- Total Student Enroll management
- Active Courses management
- Community Query management
- Trainer Dashboard view
- Hiring Portal

### Trainer Module
- Dashboard with assigned courses
- My Profile management
- Assigned Courses view
- Active Batch management
- Upcoming Live Classes
- Uploaded Videos management
- Notifications

### Student Module
- Dashboard with enrolled courses
- My Profile management
- Enroll Courses
- My Certificate downloads
- Attendance Record
- Recorded Course videos

## Installation

1. **Clone the repository and install dependencies:**
   ```bash
   composer install
   npm install
   ```

2. **Configure environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Update database configuration in `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Run migrations:**
   ```bash
   php artisan migrate
   ```

5. **Seed the database with test users:**
   ```bash
   php artisan db:seed
   ```

6. **Build assets:**
   ```bash
   npm run build
   ```

7. **Start the development server:**
   ```bash
   php artisan serve
   ```

## Default Login Credentials

After running the seeder, you can login with:

- **Admin:**
  - Email: `admin@lms.com`
  - Password: `password`

- **Trainer:**
  - Email: `trainer@lms.com`
  - Password: `password`

- **Student:**
  - Email: `student@lms.com`
  - Password: `password`

## Database Structure

The system includes the following main tables:
- `users` - All users (admin, trainer, student)
- `courses` - Course information
- `batches` - Course batches
- `enrollments` - Student enrollments
- `videos` - Recorded course videos
- `certificates` - Course completion certificates
- `live_classes` - Scheduled live classes
- `attendances` - Student attendance records
- `community_queries` - Student questions/queries
- `hiring_applications` - Trainer hiring applications
- `course_trainer` - Pivot table for course-trainer assignments

## Routes

- `/` - Landing page with role selection
- `/admin/login` - Admin login
- `/admin/dashboard` - Admin dashboard
- `/trainer/login` - Trainer login
- `/trainer/dashboard` - Trainer dashboard
- `/student/login` - Student login
- `/student/dashboard` - Student dashboard

## Technology Stack

- **Backend:** Laravel 11
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript
- **Styling:** Custom CSS with modern design (ChatGPT-inspired theme)

## Role-Based Access Control

The system uses middleware to protect routes based on user roles:
- `role:admin` - Admin only
- `role:trainer` - Trainer only
- `role:student` - Student only

## Responsive Design

All pages are fully responsive and work on:
- Desktop
- Tablet
- Mobile devices

## License

This project is open-sourced software licensed under the MIT license.

