// Trainer Satsang Form - AJAX Upload
$(document).ready(function() {
    const form = $('#satsangForm');
    const submitBtn = form.find('button[type="submit"]');
    const originalBtnText = submitBtn.html();

    // Handle thumbnail upload preview
    window.handleSatsangThumbnailUpload = function(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('satsangThumbnailPreview');
                preview.innerHTML = `<img src="${e.target.result}" style="max-width: 300px; border-radius: 8px; margin-top: 12px; border: 1px solid #e5e5e6;">`;
                document.getElementById('satsangFileStatus').textContent = file.name;
            };
            reader.readAsDataURL(file);
        }
    };

    // Form submission with AJAX
    form.on('submit', function(e) {
        e.preventDefault();
        
        // Validation
        if (!validateSatsangForm()) {
            return false;
        }

        // Disable submit button
        submitBtn.prop('disabled', true);
        submitBtn.html('<span style="display: inline-block; width: 16px; height: 16px; border: 2px solid #ffffff; border-top-color: transparent; border-radius: 50%; animation: spin 0.6s linear infinite;"></span> Uploading...');

        // Create FormData
        const formData = new FormData(this);

        // AJAX request
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
            },
            success: function(response) {
                showAlert('success', response.message || 'Career Satsang scheduled successfully!');
                setTimeout(function() {
                    window.location.href = '{{ route("trainer.satsangs.index") }}';
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
            }
        });
    });

    function validateSatsangForm() {
        const title = $('#satsangTitle').val().trim();
        const date = $('#satsangDate').val();
        const time = $('#satsangTime').val();

        if (!title) {
            showAlert('error', 'Class title is required.');
            $('#satsangTitle').focus();
            return false;
        }

        if (!date) {
            showAlert('error', 'Schedule date is required.');
            $('#satsangDate').focus();
            return false;
        }

        if (!time) {
            showAlert('error', 'Time is required.');
            $('#satsangTime').focus();
            return false;
        }

        // Check if date is in the future
        const scheduledDateTime = new Date(date + ' ' + time);
        if (scheduledDateTime <= new Date()) {
            showAlert('error', 'Schedule date and time must be in the future.');
            return false;
        }

        return true;
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
