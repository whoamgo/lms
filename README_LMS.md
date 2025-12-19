# LMS - Learning Management System

A comprehensive Learning Management System built with Laravel 11 and MySQL, featuring role-based access for Admin, Trainer (Instructor), and Student.

## 📚 Complete Documentation

For detailed feature documentation, see [FEATURES.md](./FEATURES.md)

## Features

### Admin Module
- Dashboard with system overview
- Total Student Enroll management
- Active Courses management
- Community Query management
- Trainer Dashboard view
- Hiring Portal
- Notifications system

### Trainer Module
- Dashboard with assigned courses
- My Profile management
- Assigned Courses view (default 3, "Show More" button)
- Active Batch management (default 3, "Show More" button, Create/Edit functionality)
- Upcoming Live Classes
- Uploaded Videos management
- Quiz System (Create, View, Reports)
- Satsang Management
- Notifications (Header dropdown + Sidebar)
- Standalone video player page

### Student Module
- Dashboard with enrolled courses, statistics, continue learning, upcoming courses
- My Profile management (Account Management, Profile Information, Contact Info, About)
- Enroll Courses (Tabs: All/Active/Completed, default 3, "Show More" button)
- My Certificate (PDF generation, Download, Share on LinkedIn, Tabs: Current/Past/Upcoming)
- Attendance Record (Calendar view, Charts, Filters, Year/Month select, Date range)
- Recorded Course videos (Course modal, Video list, Progress tracking)
- Notifications (Header dropdown + Sidebar + Notifications page)
- Standalone video player page

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
- **Styling:** 
  - Bootstrap 5.3.0
  - Custom CSS files (admin.css, trainer.css, student.css)
  - No inline CSS (all styles externalized)
- **Libraries:**
  - jQuery 3.7.1
  - Chart.js 4.4.0
  - DataTables.js 1.13.7
  - DomPDF 3.1 (for certificate PDF generation)

## Code Quality & Architecture

### CSS Organization
- **Modular CSS:** All styles in dedicated files (admin.css, trainer.css, student.css)
- **Section-wise Organization:** CSS organized by components
- **No Inline CSS:** All inline styles removed and moved to CSS files
- **Mobile Responsive:** All pages optimized for mobile, tablet, and desktop

### Error Handling & Logging
- **Centralized Logging:** `LogHelper` class for structured logging
- **Module-based Logs:** Separate log files per module (student, trainer, admin)
- **Try-Catch Blocks:** All controllers have proper error handling
- **User-friendly Errors:** Graceful error messages for users

### Security
- **Encrypted URLs:** All sensitive IDs encrypted using `EncryptionHelper`
- **Role-based Access:** Middleware protection for all routes
- **CSRF Protection:** All forms protected
- **Password Hashing:** Secure password storage

### Performance
- **Caching:** Dashboard statistics and frequently accessed data cached
- **Database Optimization:** Eager loading, indexed columns
- **Query Optimization:** Efficient database queries

## Error Pages

- **404 Page:** Custom 404 error page with navigation options

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

