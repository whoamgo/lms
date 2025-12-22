// Trainer Quiz Management - AJAX
let answerIndex = 3;

$(document).ready(function() {
    // Check if DataTable is already initialized and destroy it first
    if ($.fn.DataTable.isDataTable('#quizzesTable')) {
        $('#quizzesTable').DataTable().destroy();
    }
    
    // Initialize DataTable
    $('#quizzesTable').DataTable({
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        order: [[0, 'desc']],
        columnDefs: [
            { orderable: false, targets: [7] } // Actions column
        ],
        language: {
            search: "",
            searchPlaceholder: "Search...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries to show",
            zeroRecords: "No matching records found"
        }
    });

    // Add/Edit Quiz Form Submission
    $('#addQuizForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!validateQuizForm()) {
            return false;
        }

        const quizId = $('#quizId').val();
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        const isEdit = quizId && quizId !== '';
        
        submitBtn.prop('disabled', true);
        submitBtn.html(isEdit ? 'Updating...' : 'Adding...');

        // Add _method for PUT request
        if (isEdit) {
            formData += '&_method=PUT';
        }
        
        $.ajax({
            url: isEdit ? `/trainer/quizzes/${quizId}` : (typeof QUIZ_STORE_URL !== 'undefined' ? QUIZ_STORE_URL : '/trainer/quizzes'),
            type: isEdit ? 'POST' : 'POST', // Laravel uses POST with _method=PUT
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
            },
            success: function(response) {
                showAlert('success', response.message);
                closeAddQuizModal();
                setTimeout(function() {
                    location.reload();
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
                submitBtn.html(originalText);
            }
        });
    });

    // Add Question Form Submission
    $('#addQuestionForm').on('submit', function(e) {
        e.preventDefault();
        
        if (!validateQuestionForm()) {
            return false;
        }

        const quizId = $('#questionQuizId').val();
        const formData = {
            question: $('#questionText').val(),
            options: [],
            correct_answer_index: $('input[name="correct_answer"]:checked').val(),
            points: 1,
            _token: $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
        };

        $('.answer-input').each(function() {
            if ($(this).val().trim()) {
                formData.options.push($(this).val().trim());
            }
        });

        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true);
        submitBtn.html('Adding...');

        $.ajax({
            url: `/trainer/quizzes/${quizId}/questions`,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': formData._token
            },
            success: function(response) {
                showAlert('success', response.message);
                closeAddQuestionModal();
                setTimeout(function() {
                    location.reload();
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
                submitBtn.html(originalText);
            }
        });
    });
});

// Modal Functions
function openAddQuizModal() {
    $('#addQuizModalLabel').text('Add New Quiz');
    $('#quizId').val('');
    $('#quizSubmitBtn').text('Add Quiz');
    $('#addQuizForm')[0].reset();
    const modal = new bootstrap.Modal(document.getElementById('addQuizModal'));
    modal.show();
}

function closeAddQuizModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('addQuizModal'));
    if (modal) {
        modal.hide();
    }
    $('#addQuizForm')[0].reset();
    $('#quizId').val('');
}

function editQuiz(quizId) {
    $.ajax({
        url: `/trainer/quizzes/${quizId}/edit`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                const quiz = response.quiz;
                $('#addQuizModalLabel').text('Edit Quiz');
                $('#quizSubmitBtn').text('Update Quiz');
                $('#quizId').val(quiz.id);
                $('#quizTitle').val(quiz.title);
                $('#quizDescription').val(quiz.description);
                $('#quizType').val(quiz.quiz_type);
                $('#quizCourse').val(quiz.course_id);
                $('#quizTimeLimit').val(quiz.time_limit);
                $('#quizStatus').val(quiz.status);
                const modal = new bootstrap.Modal(document.getElementById('addQuizModal'));
                modal.show();
            }
        },
        error: function() {
            showAlert('error', 'Failed to load quiz data.');
        }
    });
}

function deleteQuiz(quizId) {
    if (!confirm('Are you sure you want to delete this quiz? This action cannot be undone.')) {
        return;
    }
    
    $.ajax({
        url: `/trainer/quizzes/${quizId}`,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }
        },
        error: function(xhr) {
            let errorMessage = 'Failed to delete quiz.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            showAlert('error', errorMessage);
        }
    });
}

function openAddQuestionModal(quizId) {
    $('#questionQuizId').val(quizId);
    const modal = new bootstrap.Modal(document.getElementById('addQuestionModal'));
    modal.show();
}

function closeAddQuestionModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('addQuestionModal'));
    if (modal) {
        modal.hide();
    }
    $('#addQuestionForm')[0].reset();
    // Reset answers to default 3
    resetAnswers();
}

// Answer Management
function addAnswer() {
    const container = $('#answersContainer');
    const newIndex = answerIndex++;
    
    const answerRow = $(`
        <div class="answer-row" data-index="${newIndex}">
            <div class="answer-item">
                <input type="radio" name="correct_answer" value="${newIndex}" required class="answer-radio">
                <input type="text" name="options[]" class="answer-input" placeholder="Answer ${newIndex + 1}" required>
                <button type="button" class="answer-delete-btn" onclick="removeAnswer(this)">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    `);
    
    container.append(answerRow);
    updateAnswerNumbers();
}

function removeAnswer(button) {
    const answerRows = $('.answer-row');
    if (answerRows.length <= 2) {
        showAlert('error', 'You must have at least 2 answer options.');
        return;
    }
    
    $(button).closest('.answer-row').remove();
    updateAnswerNumbers();
    updateRadioValues();
}

function updateAnswerNumbers() {
    $('.answer-row').each(function(index) {
        $(this).find('.answer-input').attr('placeholder', `Answer ${index + 1}`);
    });
}

function updateRadioValues() {
    $('.answer-row').each(function(index) {
        $(this).find('input[type="radio"]').val(index);
    });
}

function resetAnswers() {
    $('#answersContainer').html(`
        <div class="answer-row" data-index="0">
            <div class="answer-item">
                <input type="radio" name="correct_answer" value="0" required class="answer-radio">
                <input type="text" name="options[]" class="answer-input" placeholder="Answer 1" required>
                <button type="button" class="answer-delete-btn" onclick="removeAnswer(this)">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="answer-row" data-index="1">
            <div class="answer-item">
                <input type="radio" name="correct_answer" value="1" required class="answer-radio">
                <input type="text" name="options[]" class="answer-input" placeholder="Answer 2" required>
                <button type="button" class="answer-delete-btn" onclick="removeAnswer(this)">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="answer-row" data-index="2">
            <div class="answer-item">
                <input type="radio" name="correct_answer" value="2" required class="answer-radio">
                <input type="text" name="options[]" class="answer-input" placeholder="Answer 3" required>
                <button type="button" class="answer-delete-btn" onclick="removeAnswer(this)">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    `);
    answerIndex = 3;
}

// Validation Functions
function validateQuizForm() {
    const title = $('#quizTitle').val().trim();
    const quizType = $('#quizType').val();
    const status = $('#quizStatus').val();

    if (!title) {
        showAlert('error', 'Quiz title is required.');
        $('#quizTitle').focus();
        return false;
    }

    if (!quizType) {
        showAlert('error', 'Quiz type is required.');
        $('#quizType').focus();
        return false;
    }

    if (!status) {
        showAlert('error', 'Status is required.');
        $('#quizStatus').focus();
        return false;
    }

    return true;
}

function validateQuestionForm() {
    const question = $('#questionText').val().trim();
    const correctAnswer = $('input[name="correct_answer"]:checked').val();
    const answers = [];

    $('.answer-input').each(function() {
        const val = $(this).val().trim();
        if (val) {
            answers.push(val);
        }
    });

    if (!question) {
        showAlert('error', 'Question is required.');
        $('#questionText').focus();
        return false;
    }

    if (answers.length < 2) {
        showAlert('error', 'You must have at least 2 answer options.');
        return false;
    }

    if (correctAnswer === undefined) {
        showAlert('error', 'Please select the correct answer.');
        return false;
    }

    return true;
}

// Alert Function
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

// View Quiz Questions
function viewQuizQuestions(quizId) {
    $.ajax({
        url: `/trainer/quizzes/${quizId}/questions`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                const questions = response.questions;
                let html = '';
                
                if (questions.length === 0) {
                    html = '<p style="text-align: center; color: #6b7280; padding: 24px;">No questions added yet.</p>';
                } else {
                    questions.forEach(function(q, index) {
                        const options = Array.isArray(q.options) ? q.options : JSON.parse(q.options);
                        html += `
                            <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; color: #343541; margin-bottom: 8px;">Q${index + 1}: ${q.question}</div>
                                        <div style="margin-top: 12px;">
                                            ${options.map((opt, optIndex) => `
                                                <div style="display: flex; align-items: center; gap: 8px; padding: 8px; background: ${optIndex === q.correct_answer_index ? '#d1fae5' : '#f9fafb'}; border-radius: 4px; margin-bottom: 4px;">
                                                    <input type="radio" ${optIndex === q.correct_answer_index ? 'checked' : ''} disabled style="width: 16px; height: 16px;">
                                                    <span style="color: #6b7280;">${opt}</span>
                                                    ${optIndex === q.correct_answer_index ? '<span style="color: #10b981; font-size: 0.75rem; margin-left: auto;">✓ Correct</span>' : ''}
                                                </div>
                                            `).join('')}
                                        </div>
                                        <div style="margin-top: 8px; font-size: 0.875rem; color: #6b7280;">Points: ${q.points}</div>
                                    </div>
                                    <button type="button" onclick="deleteQuestion(${q.quiz_id}, ${q.id})" class="btn" style="background: #fee2e2; color: #dc2626; padding: 8px 12px; margin-left: 12px;">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                }
                
                $('#questionsList').html(html);
                const modal = new bootstrap.Modal(document.getElementById('viewQuestionsModal'));
                modal.show();
            }
        },
        error: function() {
            showAlert('error', 'Failed to load questions.');
        }
    });
}

function closeViewQuestionsModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('viewQuestionsModal'));
    if (modal) {
        modal.hide();
    }
    $('#questionsList').html('');
}

function deleteQuestion(quizId, questionId) {
    if (!confirm('Are you sure you want to delete this question?')) {
        return;
    }
    
    $.ajax({
        url: `/trainer/quizzes/${quizId}/questions/${questionId}`,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                viewQuizQuestions(quizId); // Reload questions
                setTimeout(function() {
                    location.reload(); // Reload page to update question count
                }, 1000);
            }
        },
        error: function(xhr) {
            let errorMessage = 'Failed to delete question.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            showAlert('error', errorMessage);
        }
    });
}

// Close modals when clicking outside
$(document).on('click', '.modal', function(e) {
    if (e.target === this) {
        $(this).removeClass('active').css('display', 'none');
    }
});

