<?php $__env->startSection('title', 'My Certificates'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <a href="<?php echo e(route('student.dashboard')); ?>">Home</a> / My Certificates
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Welcome Banner -->
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
</div>

<!-- Certificate Tabs -->
<div class="course-tabs" style="margin-top: 24px;">
    <button class="course-tab <?php echo e($tab === 'current' ? 'active' : ''); ?>" onclick="window.location.href='<?php echo e(route('student.certificates', ['tab' => 'current'])); ?>'">
        Current
    </button>
    <button class="course-tab <?php echo e($tab === 'past' ? 'active' : ''); ?>" onclick="window.location.href='<?php echo e(route('student.certificates', ['tab' => 'past'])); ?>'">
        Past
    </button>
    <button class="course-tab <?php echo e($tab === 'upcoming' ? 'active' : ''); ?>" onclick="window.location.href='<?php echo e(route('student.certificates', ['tab' => 'upcoming'])); ?>'">
        Upcoming Certificates
    </button>
</div>

<?php $__empty_1 = true; $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<div style="margin-top: 32px;">
    <?php if($loop->first): ?>
    <!-- Certificate Heading -->
    <div style="margin-bottom: 24px;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #343541; margin: 0 0 8px 0;">
            This Certificate was issued to <?php echo e(strtolower($certificate->student->name)); ?>

        </h2>
        <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Continue learning and achieve your goals</p>
    </div>
    <?php endif; ?>

    <!-- Certificate Display -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Certificate Visual -->
        <div class="card" style="padding: 0; background: white; position: relative; overflow: hidden;">
            <div class="certificate-container">
                <div class="certificate-design">
                    <!-- Decorative Corner Shapes -->
                    <div class="cert-shape cert-shape-top-left">
                        <div class="cert-shape-top-left-outer"></div>
                        <div class="cert-shape-top-left-inner"></div>
                    </div>
                    <div class="cert-shape cert-shape-bottom-right">
                        <div class="cert-shape-bottom-right-outer"></div>
                        <div class="cert-shape-bottom-right-inner"></div>
                    </div>
                    
                    <!-- Certificate Content -->
                    <div class="certificate-content">
                        <div class="cert-association">• GINGER PLANT ASSOSIATION •</div>
                        <div class="cert-main-title">CERTIFICATE</div>
                        <div class="cert-subtitle">OF COMPLETION</div>
                        
                        <div class="cert-presentation-bar">
                            This certificate is proudly presented to
                        </div>
                        
                        <div class="cert-recipient-name">
                            <?php echo e(ucwords(strtolower($certificate->student->name))); ?>

                        </div>
                        
                        <div class="cert-description">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                        </div>
                        
                        <div class="cert-diploma-badge">DIPLOMA</div>
                        
                        <div class="cert-ribbon-icon">
                            <div class="cert-ribbon-badge"></div>
                        </div>
                        
                        <div class="cert-signatures">
                            <div class="cert-signature-left">
                                <div class="cert-signature-name">P. Ann ORecital</div>
                                <div class="cert-signature-role">DIRECTOR</div>
                            </div>
                            <div class="cert-seal-center">
                                <div class="cert-ribbon-badge" style="width: 60px; height: 60px;"></div>
                            </div>
                            <div class="cert-signature-right">
                                <div class="cert-signature-name">Lee A. Sun</div>
                                <div class="cert-signature-role">TRAINER</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certificate Details -->
        <div class="card">
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #343541; margin-bottom: 24px;">Certificate Details</h3>
            
            <div style="margin-bottom: 24px;">
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Learner Name</div>
                    <div style="font-size: 0.875rem; font-weight: 500; color: #343541;"><?php echo e($certificate->student->name); ?></div>
                </div>
                
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Institute Name</div>
                    <div style="font-size: 0.875rem; font-weight: 500; color: #343541;">Skillwaala</div>
                </div>
                
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Course Name</div>
                    <div style="font-size: 0.875rem; font-weight: 500; color: #343541;"><?php echo e($certificate->course->title ?? 'Course'); ?></div>
                </div>
                
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Certificate ID</div>
                    <div style="font-size: 0.875rem; font-weight: 500; color: #343541;"><?php echo e($certificate->certificate_number); ?></div>
                </div>
                
                <div style="margin-bottom: 16px;">
                    <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 4px;">Issued On</div>
                    <div style="font-size: 0.875rem; font-weight: 500; color: #343541;"><?php echo e($certificate->issued_at->format('l, M d, Y')); ?></div>
                </div>
            </div>
            
            <div style="padding: 20px; background: #f9fafb; border-radius: 8px; margin-bottom: 24px; text-align: center;">
                <div style="font-size: 0.75rem; color: #6b7280; margin-bottom: 8px;">This Certificate has been issued by</div>
                <div style="font-size: 1.25rem; font-weight: 700; color: #9333ea;">SKILLWAALA</div>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <a href="<?php echo e(route('student.certificates.download', \App\Helpers\EncryptionHelper::encryptIdForUrl($certificate->id))); ?>" 
                   class="btn btn-purple" 
                   style="width: 100%; justify-content: center; text-decoration: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download
                </a>
                
                <button onclick="shareOnLinkedIn('<?php echo e(route('student.certificates.download', \App\Helpers\EncryptionHelper::encryptIdForUrl($certificate->id))); ?>', '<?php echo e($certificate->course->title ?? 'Course'); ?>')" 
                        class="btn btn-purple" 
                        style="width: 100%; justify-content: center;">
                    <svg fill="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    Share on LinkedIn
                </button>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div class="card" style="text-align: center; padding: 48px;">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px; color: #9ca3af; margin: 0 auto 16px;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
    </svg>
    <p style="color: #6b7280; font-size: 1rem;">No certificates found.</p>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
        .certificate-container {
            padding: 60px;
            background: white;
            min-height: 800px;
            position: relative;
        }
        
        .certificate-design {
            position: relative;
            width: 100%;
            min-height: 700px;
            background: white;
            border: 2px solid #e5e7eb;
        }
        
        /* Decorative Corner Shapes */
        .cert-shape {
            position: absolute;
            z-index: 1;
        }
        
        .cert-shape-top-left {
            top: 0;
            left: 0;
            width: 250px;
            height: 250px;
        }
        
        .cert-shape-top-left-outer {
            position: absolute;
            top: 0;
            left: 0;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            clip-path: polygon(0 0, 100% 0, 0 100%);
        }
        
        .cert-shape-top-left-inner {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            clip-path: polygon(0 0, 100% 0, 0 100%);
        }
        
        .cert-shape-bottom-right {
            bottom: 0;
            right: 0;
            width: 250px;
            height: 250px;
        }
        
        .cert-shape-bottom-right-outer {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            clip-path: polygon(100% 0, 100% 100%, 0 100%);
        }
        
        .cert-shape-bottom-right-inner {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            clip-path: polygon(100% 0, 100% 100%, 0 100%);
        }
        
        .certificate-content {
            position: relative;
            z-index: 2;
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .cert-association {
            font-size: 0.875rem;
            color: #4b5563;
            margin-bottom: 30px;
            letter-spacing: 2px;
            font-weight: 500;
            font-family: Arial, sans-serif;
        }
        
        .cert-main-title {
            font-size: 4rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
            letter-spacing: 4px;
            font-family: 'Times New Roman', 'Georgia', serif;
        }
        
        .cert-subtitle {
            font-size: 1.75rem;
            color: #111827;
            margin-bottom: 50px;
            letter-spacing: 2px;
            font-weight: 700;
            font-family: 'Times New Roman', 'Georgia', serif;
        }
        
        .cert-presentation-bar {
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            color: white;
            padding: 14px 30px;
            border-radius: 6px;
            display: inline-block;
            margin: 0 auto 30px;
            font-size: 0.875rem;
            font-weight: 500;
            font-family: Arial, sans-serif;
        }
        
        .cert-recipient-name {
            font-size: 2.5rem;
            font-weight: 600;
            color: #111827;
            margin: 50px 0 40px 0;
            font-family: 'Georgia', 'Times New Roman', serif;
            font-style: italic;
            text-decoration: underline;
            text-decoration-thickness: 2px;
            text-underline-offset: 8px;
        }
        
        .cert-description {
            margin: 40px auto;
            color: #2563eb;
            font-size: 0.875rem;
            line-height: 1.8;
            max-width: 550px;
            font-family: Arial, sans-serif;
        }
        
        .cert-description p {
            margin: 10px 0;
        }
        
        .cert-diploma-badge {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin: 40px 0 30px 0;
            letter-spacing: 2px;
            font-family: 'Times New Roman', 'Georgia', serif;
            text-transform: uppercase;
        }
        
        .cert-ribbon-icon {
            margin: 30px auto;
            width: 120px;
            height: 120px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .cert-ribbon-badge {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            border-radius: 50%;
            position: relative;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
        .cert-ribbon-badge::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 90px;
            height: 30px;
            background: linear-gradient(135deg, #93c5fd 0%, #60a5fa 100%);
            border-radius: 50% 50% 0 0;
            clip-path: polygon(0 0, 100% 0, 90% 100%, 10% 100%);
        }
        
        .cert-ribbon-badge::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 40px;
            background: white;
            clip-path: polygon(20% 0, 80% 0, 100% 100%, 0 100%);
        }
        
        .cert-signatures {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 80px;
            padding: 0 40px;
        }
        
        .cert-signature-left,
        .cert-signature-right {
            flex: 1;
            text-align: center;
        }
        
        .cert-signature-name {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-style: italic;
            font-size: 1.125rem;
            color: #111827;
            margin-bottom: 10px;
            text-decoration: underline;
            text-decoration-thickness: 1px;
        }
        
        .cert-signature-role {
            font-size: 0.75rem;
            color: #4b5563;
            font-weight: 500;
            letter-spacing: 1px;
            font-family: Arial, sans-serif;
            text-transform: uppercase;
        }
        
        .cert-seal-center {
            width: 80px;
            height: 80px;
            margin: 0 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

@media (max-width: 1024px) {
    .certificate-container {
        padding: 40px 30px;
    }
    
    .certificate-content {
        padding: 30px 20px;
    }
    
    .cert-main-title {
        font-size: 2.5rem;
    }
    
    .cert-recipient-name {
        font-size: 1.5rem;
    }
}

@media (max-width: 768px) {
    .certificate-display {
        grid-template-columns: 1fr;
    }
    
    .certificate-container {
        padding: 20px;
    }
    
    .cert-main-title {
        font-size: 2rem;
    }
    
    .cert-signatures {
        flex-direction: column;
        gap: 24px;
        align-items: center;
    }
    
    .cert-seal {
        margin: 20px 0;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function shareOnLinkedIn(certificateUrl, courseTitle) {
    const url = encodeURIComponent(window.location.origin + certificateUrl);
    const title = encodeURIComponent('I completed ' + courseTitle + ' on Skillwaala!');
    const summary = encodeURIComponent('Check out my certificate of completion!');
    
    const linkedInUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}&title=${title}&summary=${summary}`;
    window.open(linkedInUrl, '_blank', 'width=600,height=400');
}
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/ok/resources/views/student/certificates.blade.php ENDPATH**/ ?>