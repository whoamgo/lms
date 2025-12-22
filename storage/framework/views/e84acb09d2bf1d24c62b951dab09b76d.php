<?php $__env->startSection('title', 'Enroll Courses'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <a href="<?php echo e(route('student.dashboard')); ?>">Home</a> / Enroll Courses
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Welcome Banner with Stats -->
<div class="welcome-banner">
    <div class="welcome-banner-content">
        <div class="profile-avatar" style="margin-top: 0; width: 60px; height: 60px;">
            <?php if(Auth::user()->avatar): ?>
                <img src="<?php echo e(asset('storage/' . Auth::user()->avatar)); ?>" alt="Avatar">
            <?php else: ?>
                <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 30px; height: 30px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            <?php endif; ?>
        </div>
        <div>
            <h1>Welcome, <?php echo e(Auth::user()->name); ?>!</h1>
            <p>Student</p>
        </div>
    </div>
    <div style="display: flex; gap: 16px;">
        <div style="background: rgba(255,255,255,0.2); padding: 16px; border-radius: 8px; text-align: center;">
            <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 24px; height: 24px; margin: 0 auto 8px; opacity: 0.9;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <div style="font-size: 1.25rem; font-weight: 700;"><?php echo e($enrollments->count()); ?> Courses</div>
            <div style="font-size: 0.875rem; opacity: 0.9;">Enrolled</div>
        </div>
        <div style="background: rgba(255,255,255,0.2); padding: 16px; border-radius: 8px; text-align: center;">
            <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 24px; height: 24px; margin: 0 auto 8px; opacity: 0.9;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <div style="font-size: 1.25rem; font-weight: 700;"><?php echo e($enrollments->where('status', 'enrolled')->where('progress_percentage', '<', 100)->count()); ?> Courses</div>
            <div style="font-size: 0.875rem; opacity: 0.9;">In Progress</div>
        </div>
        <div style="background: rgba(255,255,255,0.2); padding: 16px; border-radius: 8px; text-align: center;">
            <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 24px; height: 24px; margin: 0 auto 8px; opacity: 0.9;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div style="font-size: 1.25rem; font-weight: 700;"><?php echo e($enrollments->where('status', 'completed')->count()); ?> Courses</div>
            <div style="font-size: 0.875rem; opacity: 0.9;">Completed</div>
        </div>
    </div>
</div>

<!-- Section Title -->
<div style="margin-bottom: 24px;">
    <h2 style="font-size: 1.5rem; font-weight: 600; color: #343541; margin: 0 0 8px 0;">My Enrolled Courses</h2>
    <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Continue learning and achieve your goals</p>
</div>

<!-- Course Tabs -->
<div class="course-tabs">
    <button class="course-tab <?php echo e($tab === 'all' ? 'active' : ''); ?>" onclick="window.location.href='<?php echo e(route('student.enroll-courses', ['tab' => 'all'])); ?>'">
        All Courses
    </button>
    <button class="course-tab <?php echo e($tab === 'active' ? 'active' : ''); ?>" onclick="window.location.href='<?php echo e(route('student.enroll-courses', ['tab' => 'active'])); ?>'">
        Active
    </button>
    <button class="course-tab <?php echo e($tab === 'completed' ? 'active' : ''); ?>" onclick="window.location.href='<?php echo e(route('student.enroll-courses', ['tab' => 'completed'])); ?>'">
        Completed
    </button>
</div>

<!-- Course Cards -->
<div class="card card-no-padding">
    <div id="coursesContainer" class="courses-grid">
        <?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="course-card course-item <?php if($index >= 3): ?> hidden-item <?php endif; ?>" data-index="<?php echo e($index); ?>">
            <div class="course-card-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.25rem;">
                CS COURSES
            </div>
            <div class="course-card-body">
                <span class="course-badge beginner">Beginner</span>
                <h3 class="course-card-title"><?php echo e($enrollment->course->title ?? 'Course Title'); ?></h3>
                <p class="course-card-instructor">By <?php echo e($enrollment->course->trainers->first()->name ?? 'Instructor'); ?></p>
                
                <?php if($enrollment->progress_percentage > 0): ?>
                <div class="course-progress">
                    <div class="course-progress-bar">
                        <div class="course-progress-fill" style="width: <?php echo e($enrollment->progress_percentage); ?>%;"></div>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php
                    $firstVideo = \App\Models\Video::where('course_id', $enrollment->course_id)
                        ->where('status', 'active')
                        ->orderBy('order', 'asc')
                        ->orderBy('created_at', 'asc')
                        ->first();
                ?>
                <?php if($firstVideo): ?>
                    <a href="<?php echo e(route('student.videos.watch', \App\Helpers\EncryptionHelper::encryptIdForUrl($firstVideo->id))); ?>" class="btn btn-purple btn-sm" style="width: 100%; justify-content: center; text-decoration: none;">Continue Learning</a>
                <?php else: ?>
                    <button class="btn btn-purple btn-sm" style="width: 100%; justify-content: center;" disabled>No Videos Available</button>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 48px; color: #6b7280;">
            <p>No courses found.</p>
        </div>
        <?php endif; ?>
    </div>
    
    <?php if($enrollments->count() > 3): ?>
    <div class="show-more-container">
        <button id="showMoreCoursesBtn" class="show-more-btn">
            Show More (<?php echo e($enrollments->count() - 3); ?> more)
        </button>
    </div>
    <?php endif; ?>
</div>
 
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    const $coursesContainer = $('#coursesContainer');
    const $showMoreBtn = $('#showMoreCoursesBtn');
    const totalCourses = <?php echo e($enrollments->count()); ?>;
    let showingAll = false;
    
    if (totalCourses > 3) {
        $('.course-item').each(function() {
            const index = $(this).data('index');
            if (index >= 3) {
                $(this).hide();
            }
        });
        
        $showMoreBtn.on('click', function() {
            const $btn = $(this);
            
            if (!showingAll) {
                $('.course-item').each(function() {
                    const index = $(this).data('index');
                    if (index >= 3) {
                        $(this).slideDown(300);
                    }
                });
                showingAll = true;
                $btn.html('Show Less');
            } else {
                $('.course-item').each(function() {
                    const index = $(this).data('index');
                    if (index >= 3) {
                        $(this).slideUp(300);
                    }
                });
                showingAll = false;
                $btn.html('Show More (' + (totalCourses - 3) + ' more)');
                
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: $coursesContainer.offset().top - 100
                    }, 300);
                }, 300);
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/ok/resources/views/student/enroll-courses.blade.php ENDPATH**/ ?>