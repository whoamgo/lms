// Trainer Upload Video - AJAX with Progress Bar
$(document).ready(function() {
    const form = $('#uploadVideoForm');
    const submitBtn = form.find('button[type="submit"]');
    const originalBtnText = submitBtn.html();

    // Handle thumbnail upload preview
    window.handleThumbnailUpload = function(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('thumbnailPreview');
                preview.innerHTML = `<img src="${e.target.result}" style="max-width: 300px; border-radius: 8px; margin-top: 12px; border: 1px solid #e5e5e6;">`;
                document.getElementById('thumbnailFileStatus').textContent = file.name;
            };
            reader.readAsDataURL(file);
        }
    };

    // Handle video file select
    window.handleVideoFileSelect = function(input) {
        const file = input.files[0];
        if (file) {
            document.getElementById('videoFileStatus').textContent = file.name + ' (' + formatFileSize(file.size) + ')';
        }
    };

    // Drag and drop handlers
    window.handleDragOver = function(e) {
        e.preventDefault();
        e.stopPropagation();
        document.getElementById('videoDropZone').classList.add('drag-over');
    };

    window.handleDragLeave = function(e) {
        e.preventDefault();
        e.stopPropagation();
        document.getElementById('videoDropZone').classList.remove('drag-over');
    };

    window.handleDrop = function(e) {
        e.preventDefault();
        e.stopPropagation();
        document.getElementById('videoDropZone').classList.remove('drag-over');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const fileInput = document.getElementById('videoFile');
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(files[0]);
            fileInput.files = dataTransfer.files;
            handleVideoFileSelect(fileInput);
        }
    };

    // Toggle playlist section
    window.togglePlaylistSection = function() {
        const checkbox = document.getElementById('createPlaylist');
        const section = document.getElementById('playlistSection');
        const chevron = document.getElementById('playlistChevron');
        
        if (checkbox.checked) {
            section.style.display = 'block';
            chevron.style.transform = 'rotate(180deg)';
        } else {
            section.style.display = 'none';
            chevron.style.transform = 'rotate(0deg)';
        }
    };

    // Form submission with AJAX and progress bar
    form.on('submit', function(e) {
        e.preventDefault();
        
        // Validation
        if (!validateForm()) {
            return false;
        }

        // Disable submit button
        submitBtn.prop('disabled', true);
        submitBtn.html('<span style="display: inline-block; width: 16px; height: 16px; border: 2px solid #ffffff; border-top-color: transparent; border-radius: 50%; animation: spin 0.6s linear infinite;"></span> Uploading...');

        // Show progress bar
        const progressContainer = document.getElementById('videoProgressContainer');
        const progressBar = document.getElementById('videoProgressBar');
        const progressText = document.getElementById('videoProgressText');
        progressContainer.style.display = 'block';
        progressBar.style.width = '0%';
        progressText.textContent = '0%';

        // Create FormData
        const formData = new FormData(this);

        // AJAX request with progress tracking
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                const xhr = new window.XMLHttpRequest();
                // Upload progress
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        progressBar.style.width = percentComplete + '%';
                        progressText.textContent = Math.round(percentComplete) + '%';
                    }
                }, false);
                return xhr;
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
            },
            success: function(response) {
                progressBar.style.width = '100%';
                progressText.textContent = '100%';
                showAlert('success', response.message || 'Video uploaded successfully!');
                setTimeout(function() {
                    const redirectUrl = typeof VIDEOS_INDEX_URL !== 'undefined' ? VIDEOS_INDEX_URL : '/trainer/videos';
                    window.location.href = redirectUrl;
                }, 1500);
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('<br>');
                }
                
                showAlert('error', errorMessage);
                submitBtn.prop('disabled', false);
                submitBtn.html(originalBtnText);
                progressContainer.style.display = 'none';
            }
        });
    });

    // Playlist form submission
    $('#playlistForm').on('submit', function(e) {
        e.preventDefault();
        
        const title = $('#playlistTitle').val().trim();
        if (!title) {
            showAlert('error', 'Playlist title is required.');
            return false;
        }

        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true);
        submitBtn.html('Creating...');

        $.ajax({
            url: typeof PLAYLIST_STORE_URL !== 'undefined' ? PLAYLIST_STORE_URL : '/trainer/videos/playlist',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
            },
            success: function(response) {
                showAlert('success', response.message);
                closePlaylistModal();
                // Optionally refresh playlist list or add to select
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('<br>');
                }
                showAlert('error', errorMessage);
                submitBtn.prop('disabled', false);
                submitBtn.html(originalText);
            }
        });
    });

    function validateForm() {
        const title = $('#videoTitle').val().trim();
        const videoFile = document.getElementById('videoFile').files[0];
        const videoUrl = $('#videoUrl').val().trim();

        if (!title) {
            showAlert('error', 'Video title is required.');
            $('#videoTitle').focus();
            return false;
        }

        if (!videoFile && !videoUrl) {
            showAlert('error', 'Please select a video file or provide a video URL.');
            return false;
        }

        return true;
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
        const icon = type === 'success' 
            ? '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            : '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        
        const alert = $(`
            <div class="${alertClass}" style="position: fixed; top: 80px; right: 24px; z-index: 9999; min-width: 300px; padding: 12px 16px; border-radius: 8px; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                ${icon}
                <div>${message}</div>
            </div>
        `);
        
        $('body').append(alert);
        
        setTimeout(function() {
            alert.fadeOut(500, function() {
                $(this).remove();
            });
        }, 5000);
    }
});

// Modal Functions
function openPlaylistModal() {
    $('#playlistModal').addClass('active').css('display', 'flex');
}

function closePlaylistModal() {
    $('#playlistModal').removeClass('active').css('display', 'none');
    $('#playlistForm')[0].reset();
}

// Close modals when clicking outside
$(document).on('click', '.modal', function(e) {
    if (e.target === this) {
        $(this).removeClass('active').css('display', 'none');
    }
});

// Add CSS for spinner animation
if (!document.getElementById('spinner-style')) {
    const style = document.createElement('style');
    style.id = 'spinner-style';
    style.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
    document.head.appendChild(style);
}

