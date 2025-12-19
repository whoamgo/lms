@extends('layouts.trainer')

@section('title', 'Quiz List')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / <a href="{{ route('trainer.skillspace') }}">SkillSpace</a> / Quiz
@endsection

@section('content')
<div style="position: relative; margin-bottom: 24px;">
    <div style="background: linear-gradient(135deg, #9333ea 0%, #ec4899 100%); height: 60px; border-radius: 12px 12px 0 0;"></div>
    <div style="background: white; padding: 20px 24px; border-radius: 0 0 12px 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: space-between; gap: 16px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: -30px; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                @if(Auth::user()->avatar)
                    <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                @else
                    <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 30px; height: 30px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                @endif
            </div>
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 600; color: #343541; margin: 0;">{{ Auth::user()->name }}</h2>
                <p style="color: #6b7280; margin: 2px 0 0 0; font-size: 0.875rem;">Trainer</p>
            </div>
        </div>
        <button type="button" class="btn btn-primary" onclick="openAddQuizModal()">+ Add New Quiz</button>
    </div>
</div>

<div class="card">
    <div class="table-container">
        <table class="data-table" id="quizzesTable">
            <thead>
                <tr>
                    <th>Quiz Title</th>
                    <th>Type</th>
                    <th>Course</th>
                    <th>Questions</th>
                    <th>Views</th>
                    <th>Attempts</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quizzes as $quiz)
                <tr>
                    <td>
                        <div style="font-weight: 500;">{{ $quiz->title }}</div>
                        @if($quiz->description)
                            <div style="font-size: 0.75rem; color: #6b7280; margin-top: 4px;">{{ Str::limit($quiz->description, 50) }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-info">{{ ucfirst($quiz->quiz_type) }}</span>
                    </td>
                    <td>{{ $quiz->course->title ?? 'N/A' }}</td>
                    <td>{{ $quiz->total_questions }}</td>
                    <td>{{ number_format($quiz->views ?? 0) }}</td>
                    <td>{{ $quiz->attempts_count ?? 0 }}</td>
                    <td>
                        <span class="badge badge-{{ $quiz->status === 'published' ? 'success' : ($quiz->status === 'draft' ? 'info' : 'danger') }}">
                            {{ ucfirst($quiz->status) }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <a href="{{ route('trainer.quizzes.show', $quiz->id) }}" class="btn btn-primary btn-sm" style="background: #10b981; color: white;" title="View Report">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px; margin-right: 4px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Report
                            </a>
                            <button type="button" class="btn btn-primary btn-sm" onclick="openAddQuestionModal({{ $quiz->id }})" title="Add Question">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px; margin-right: 4px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Q
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="viewQuizQuestions({{ $quiz->id }})" style="background: #8b5cf6; color: white;" title="View Questions">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px; margin-right: 4px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Questions
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="editQuiz({{ $quiz->id }})" style="background: #f59e0b; color: white;" title="Edit Quiz">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px; margin-right: 4px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="deleteQuiz({{ $quiz->id }})" style="background: #ef4444; color: white;" title="Delete Quiz">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px; margin-right: 4px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Quiz Modal -->
<div id="addQuizModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
        <button class="modal-close" onclick="closeAddQuizModal()">&times;</button>
        <h2 id="quizModalTitle" style="margin-bottom: 24px;">Add New Quiz</h2>
        <form id="addQuizForm">
            @csrf
            <input type="hidden" id="quizId" name="quiz_id" value="">
            <div class="form-group">
                <label>Quiz Title*</label>
                <input type="text" name="title" id="quizTitle" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="quizDescription" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Quiz Type*</label>
                <select name="quiz_type" id="quizType" required>
                    <option value="">--Select Quiz Type--</option>
                    <option value="practice">Practice</option>
                    <option value="assessment">Assessment</option>
                    <option value="exam">Exam</option>
                </select>
            </div>
            <div class="form-group">
                <label>Course (Optional)</label>
                <select name="course_id" id="quizCourse">
                    <option value="">--Select Course Type--</option>
                    @foreach(Auth::user()->assignedCourses()->get() as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Time Limit (minutes)</label>
                <input type="number" name="time_limit" id="quizTimeLimit" min="1">
            </div>
            <div class="form-group">
                <label>Status*</label>
                <select name="status" id="quizStatus" required>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" onclick="closeAddQuizModal()" class="btn" style="background: #f3f4f6; color: #343541;">Cancel</button>
                <button type="submit" class="btn btn-primary" id="quizSubmitBtn">Add Quiz</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Question Modal -->
<div id="addQuestionModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 700px;">
        <button class="modal-close" onclick="closeAddQuestionModal()">&times;</button>
        <h2 style="margin-bottom: 24px;">Add Question</h2>
        <form id="addQuestionForm">
            @csrf
            <input type="hidden" id="questionQuizId" name="quiz_id">
            <div class="form-group">
                <label>Select Quiz Type*</label>
                <select id="questionQuizType" required>
                    <option value="">--Select Quiz Type--</option>
                    <option value="practice">Practice</option>
                    <option value="assessment">Assessment</option>
                    <option value="exam">Exam</option>
                </select>
            </div>
            <div class="form-group">
                <label>Select Course Type*</label>
                <select id="questionCourseType" required>
                    <option value="">--Select Course Type--</option>
                    @foreach(Auth::user()->assignedCourses()->get() as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Enter your question...*</label>
                <textarea name="question" id="questionText" rows="4" required placeholder="Enter your question..."></textarea>
            </div>
            <div id="answersContainer">
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
            </div>
            <button type="button" class="add-answer-btn" onclick="addAnswer()">+ Add Answer</button>
            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 24px;">Select one correct answer by clicking radio button</p>
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeAddQuestionModal()" class="btn" style="background: #f3f4f6; color: #343541;">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Question</button>
            </div>
        </form>
    </div>
</div>

<!-- View Questions Modal -->
<div id="viewQuestionsModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 800px;">
        <button class="modal-close" onclick="closeViewQuestionsModal()">&times;</button>
        <h2 style="margin-bottom: 24px;">Quiz Questions</h2>
        <div id="questionsList" style="max-height: 500px; overflow-y: auto;">
            <!-- Questions will be loaded here -->
        </div>
    </div>
</div>

@push('styles')
<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    align-items: center;
    justify-content: center;
}
.modal.active {
    display: flex;
}
.modal-content {
    background: white;
    border-radius: 12px;
    padding: 32px;
    max-width: 700px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
}
.modal-close {
    position: absolute;
    top: 16px;
    right: 16px;
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #6b7280;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.2s;
}
.modal-close:hover {
    background: #f3f4f6;
}
.answer-row {
    margin-bottom: 12px;
}
.answer-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    transition: all 0.2s;
}
.answer-item:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
}
.answer-radio {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #2563eb;
}
.answer-input {
    flex: 1;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: border-color 0.2s;
}
.answer-input:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}
.answer-delete-btn {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    padding: 8px;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    min-width: 36px;
    height: 36px;
}
.answer-delete-btn:hover {
    background: #fecaca;
    transform: scale(1.05);
}
.add-answer-btn {
    background: #dbeafe;
    color: #2563eb;
    border: 2px dashed #2563eb;
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    margin-bottom: 12px;
}
.add-answer-btn:hover {
    background: #bfdbfe;
    border-color: #1d4ed8;
}
</style>
@endpush

@push('scripts')
<script>
// Pass route URLs to JavaScript
const QUIZ_STORE_URL = '{{ route("trainer.quizzes.store") }}';
</script>
<script src="{{ asset('js/trainer-quiz.js') }}"></script>
@endpush
@endsection
