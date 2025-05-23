@extends('dashboard-layout.app')

@section('content')
    <div class="container">
        <div class="page-title-container mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1 class="mb-0 pb-0 display-4 text-primary fw-bold" id="title">
                        Certificate Details
                    </h1>
                    <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{ route('intern.dashboard') }}"
                                    class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('intern.certificates.index') }}"
                                    class="text-decoration-none">Certificates</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $internCertificate->certificate->title }}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        @include('components._messages')

        <div class="row">
            <!-- Certificate Overview Card -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            @if ($internCertificate->certificate->provider->logo)
                                <img src="{{ Storage::url($internCertificate->certificate->provider->logo) }}"
                                    alt="{{ $internCertificate->certificate->provider->name }}" class="mb-3"
                                    style="height: 60px; width: auto;" />
                            @else
                                <div class="provider-logo-placeholder mx-auto mb-3">
                                    <i data-acorn-icon="building-large" class="text-primary"></i>
                                </div>
                            @endif
                            <h5 class="mb-1">{{ $internCertificate->certificate->title }}</h5>
                            <div class="text-muted">{{ $internCertificate->certificate->provider->name }}</div>

                            @if ($internCertificate->certificate->level)
                                <div class="mt-2">
                                    <span class="badge bg-info">{{ ucfirst($internCertificate->certificate->level) }}</span>
                                    <span
                                        class="badge bg-secondary">{{ ucfirst($internCertificate->certificate->type) }}</span>
                                </div>
                            @endif
                        </div>

                        <hr>

                        <h6 class="fw-bold mb-3">Certificate Status</h6>
                        <div class="mb-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="p-2 rounded bg-light">
                                        <div class="text-muted small">Started</div>
                                        <div class="fw-medium">{{ $internCertificate->started_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 rounded bg-light">
                                        <div class="text-muted small">Status</div>
                                        <div>
                                            @if ($internCertificate->completed_at)
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-warning">In Progress</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="fw-medium d-flex justify-content-between mb-1">
                                <span>Progress</span>
                                <span>{{ $percentComplete }}%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{ $percentComplete }}%;" aria-valuenow="{{ $percentComplete }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3">Exam Status</h6>
                        <div class="mb-3">
                            @php
                                $statusBadge = 'secondary';
                                $statusText = 'Not Started';

                                switch ($internCertificate->exam_status) {
                                    case 'scheduled':
                                        $statusBadge = 'info';
                                        $statusText = 'Scheduled';
                                        break;
                                    case 'passed':
                                        $statusBadge = 'success';
                                        $statusText = 'Passed';
                                        break;
                                    case 'failed':
                                        $statusBadge = 'danger';
                                        $statusText = 'Failed';
                                        break;
                                    default:
                                        $statusBadge = 'secondary';
                                        $statusText = 'Not Started';
                                }
                            @endphp

                            <div class="mb-3">
                                <div class="p-3 rounded bg-{{ $statusBadge }} bg-opacity-10 text-center">
                                    <div class="badge bg-{{ $statusBadge }} mb-2">{{ $statusText }}</div>
                                    <div class="text-muted small">
                                        @if ($internCertificate->exam_status == 'not_taken')
                                            You haven't scheduled your exam yet
                                        @elseif($internCertificate->exam_status == 'scheduled')
                                            Your exam is scheduled
                                        @elseif($internCertificate->exam_status == 'passed')
                                            Congratulations! You passed the exam.
                                        @elseif($internCertificate->exam_status == 'failed')
                                            Don't give up! You can try again.
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Voucher Status Section - IMPROVED -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between text-muted small mb-1">
                                    <span>Voucher Status</span>
                                    <span>
                                        @if ($internCertificate->voucher_id)
                                            <i data-acorn-icon="check" class="text-success me-1"></i>Assigned
                                        @elseif($voucherRequestExists)
                                            <i data-acorn-icon="clock" class="text-warning me-1"></i>Requested
                                        @else
                                            <i data-acorn-icon="minus" class="text-muted me-1"></i>Not Requested
                                        @endif
                                    </span>
                                </div>

                                @if (!$voucherRequestExists && !$internCertificate->completed_at)
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100 mt-2"
                                        data-bs-toggle="modal" data-bs-target="#requestVoucherModal"
                                        {{ !$allCoursesCompleted ? 'disabled' : '' }}
                                        title="{{ !$allCoursesCompleted ? 'Complete all courses to request a voucher' : 'Request an exam voucher' }}">
                                        <i data-acorn-icon="ticket" class="me-1"></i> Request Exam Voucher
                                    </button>
                                @elseif($voucherRequestExists && !$internCertificate->voucher_id)
                                    <div class="alert alert-info py-2 mb-0 mt-2 small">
                                        <i data-acorn-icon="info" class="me-1"></i> Voucher requested on
                                        {{ $internCertificate->progress->where('study_status', 'requested_voucher')->first()->created_at->format('M d, Y') }}.
                                        Your mentor will be in touch.
                                    </div>
                                @elseif($internCertificate->voucher_id)
                                    <div class="alert alert-success py-2 mb-0 mt-2 small">
                                        <i data-acorn-icon="check" class="me-1"></i> Voucher assigned. Check your email
                                        for details.
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($internCertificate->certificate->description)
                            <h6 class="fw-bold mb-2">Description</h6>
                            <div class="text-muted small">
                                {!! $internCertificate->certificate->description !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Certificate Progress & Courses -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light py-3">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="courses-tab" data-bs-toggle="tab"
                                    data-bs-target="#courses" type="button" role="tab" aria-controls="courses"
                                    aria-selected="true">
                                    <i data-acorn-icon="notebook" class="me-1"></i> Courses
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="progress-tab" data-bs-toggle="tab"
                                    data-bs-target="#progress" type="button" role="tab" aria-controls="progress"
                                    aria-selected="false">
                                    <i data-acorn-icon="chart" class="me-1"></i> Progress Timeline
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-0">
                        <div class="tab-content">
                            <!-- Courses Tab -->
                            <div class="tab-pane fade show active" id="courses" role="tabpanel"
                                aria-labelledby="courses-tab">
                                <div class="p-4">
                                    <h6 class="mb-3">Course Checklist</h6>

                                    @if (count($coursesWithProgress) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 50px;">#</th>
                                                        <th>Course</th>
                                                        <th style="width: 150px;">Duration</th>
                                                        <th style="width: 120px;">Status</th>
                                                        <th style="width: 120px;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($coursesWithProgress as $course)
                                                        <tr>
                                                            <td>{{ $course['step_order'] }}</td>
                                                            <td>
                                                                <div class="fw-medium">{{ $course['title'] }}</div>
                                                                @if ($course['description'])
                                                                    <div class="text-muted small">
                                                                        {{ \Illuminate\Support\Str::limit(strip_tags($course['description']), 80) }}
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>{{ $course['estimated_minutes'] ?? '--' }} minutes</td>
                                                            <td>
                                                                @if ($course['is_completed'])
                                                                    <span class="badge bg-success"><i
                                                                            data-acorn-icon="check" class="me-1"></i>
                                                                        Completed</span>
                                                                @else
                                                                    <span class="badge bg-warning"><i
                                                                            data-acorn-icon="clock" class="me-1"></i> In
                                                                        Progress</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    @if ($course['resource_link'])
                                                                        <a href="{{ $course['resource_link'] }}"
                                                                            target="_blank"
                                                                            class="btn btn-sm btn-outline-primary"
                                                                            data-bs-toggle="tooltip"
                                                                            title="View Resource">
                                                                            <i data-acorn-icon="link"></i>
                                                                        </a>
                                                                    @endif

                                                                    @if ($course['digital_link'])
                                                                        <a href="{{ $course['digital_link'] }}"
                                                                            target="_blank"
                                                                            class="btn btn-sm btn-outline-primary"
                                                                            data-bs-toggle="tooltip"
                                                                            title="Digital Course">
                                                                            <i data-acorn-icon="screen"></i>
                                                                        </a>
                                                                    @endif

                                                                    <!-- Only show the update button if course is not completed -->
                                                                    @if ($course['can_update'])
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-primary update-progress-btn"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#updateCourseProgressModal"
                                                                            data-course-id="{{ $course['id'] }}"
                                                                            data-course-title="{{ $course['title'] }}"
                                                                            data-is-completed="{{ $course['is_completed'] ? 1 : 0 }}"
                                                                            data-comment="{{ $course['comment'] }}"
                                                                            data-proof-url="{{ $course['proof_url'] }}">
                                                                            <i data-acorn-icon="edit"></i>
                                                                        </button>
                                                                    @else
                                                                        <!-- Show view-only button for completed courses -->
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-secondary view-progress-btn"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#viewCourseProgressModal"
                                                                            data-course-id="{{ $course['id'] }}"
                                                                            data-course-title="{{ $course['title'] }}"
                                                                            data-comment="{{ $course['comment'] }}"
                                                                            data-proof-url="{{ $course['proof_url'] }}">
                                                                            <i data-acorn-icon="eye"></i>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i data-acorn-icon="notebook-empty" class="text-muted mb-3"
                                                style="font-size: 2.5rem;"></i>
                                            <h6 class="text-muted">No courses found for this certificate program</h6>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Progress Timeline Tab -->
                            <div class="tab-pane fade" id="progress" role="tabpanel" aria-labelledby="progress-tab">
                                <div class="p-4">
                                    <h6 class="mb-3">Progress Timeline</h6>

                                    @if (count($progressTimeline) > 0)
                                        <div class="timeline mb-3">
                                            @foreach ($progressTimeline as $progress)
                                                <div class="timeline-item">
                                                    <div class="timeline-icon bg-primary">
                                                        <i data-acorn-icon="{{ $progress['icon'] }}" class="text-white"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <div>
                                                                <span class="badge bg-{{ $progress['badge_color'] }}">{{ $progress['status_text'] }}</span>

                                                                @if ($progress['updated_by_mentor'])
                                                                    <span class="badge bg-info ms-1">Mentor Updated</span>
                                                                @endif
                                                            </div>
                                                            <span class="text-muted small">{{ \Carbon\Carbon::parse($progress['created_at'])->format('M d, Y h:i A') }}</span>
                                                        </div>

                                                        @if ($progress['notes'])
                                                            <p class="mb-2">{{ $progress['notes'] }}</p>
                                                        @endif

                                                        @if ($progress['voucher_requested_at'] || $progress['exam_date'])
                                                            <div class="text-muted small">
                                                                @if ($progress['voucher_requested_at'])
                                                                    <div><i data-acorn-icon="tag" class="me-1"></i>
                                                                        Voucher requested on:
                                                                        {{ \Carbon\Carbon::parse($progress['voucher_requested_at'])->format('M d, Y') }}
                                                                    </div>
                                                                @endif

                                                                @if ($progress['exam_date'])
                                                                    <div><i data-acorn-icon="calendar" class="me-1"></i>
                                                                        Exam date:
                                                                        {{ \Carbon\Carbon::parse($progress['exam_date'])->format('M d, Y') }}</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if (!$internCertificate->completed_at)
                                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#updateProgressModal">
                                                <i data-acorn-icon="plus" class="me-1"></i> Add Progress Update
                                            </button>
                                        @endif
                                    @else
                                        <div class="text-center py-4">
                                            <i data-acorn-icon="chart" class="text-muted mb-3"
                                                style="font-size: 2.5rem;"></i>
                                            <h6 class="text-muted">No progress updates yet</h6>
                                            <button type="button" class="btn btn-outline-primary mt-2"
                                                data-bs-toggle="modal" data-bs-target="#updateProgressModal">
                                                <i data-acorn-icon="plus" class="me-1"></i> Add First Progress Update
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Progress Modal -->
        <div class="modal fade" id="updateProgressModal" tabindex="-1" aria-labelledby="updateProgressModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('intern.certificates.update-progress', $internCertificate->id) }}"
                        method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateProgressModalLabel">Update Certificate Progress</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="study_status" class="form-label">Study Status</label>
                                <select class="form-select" id="study_status" name="study_status" required>
                                    <option value="in_progress">In Progress</option>
                                    <option value="studying_for_exam">Studying for Exam</option>
                                    <option value="took_exam">Took Exam</option>
                                    <option value="passed">Passed Exam</option>
                                    <option value="failed">Failed Exam</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"
                                    placeholder="Add any notes about your current progress..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Progress</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Request Voucher Modal -->
        <div class="modal fade" id="requestVoucherModal" tabindex="-1" aria-labelledby="requestVoucherModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('intern.certificates.request-voucher', $internCertificate->id) }}"
                        method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="requestVoucherModalLabel">Request Exam Voucher</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i data-acorn-icon="info" class="me-2"></i>
                                By requesting a voucher, you're confirming that you've completed your course materials and
                                are ready to schedule your exam.
                            </div>

                            <div class="mb-3">
                                <label for="voucher_notes" class="form-label">Additional Notes (Optional)</label>
                                <textarea class="form-control" id="voucher_notes" name="notes" rows="3"
                                    placeholder="Add any notes for your mentor about your exam voucher request..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Request Voucher</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Course Progress Modal -->
        <div class="modal fade" id="updateCourseProgressModal" tabindex="-1"
            aria-labelledby="updateCourseProgressModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('intern.certificates.update-course-progress', $internCertificate->id) }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="course_id" id="course_id">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateCourseProgressModalLabel">Update Course Progress</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <h6 id="course_title" class="mb-1"></h6>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_completed"
                                        name="is_completed" value="1">
                                    <label class="form-check-label" for="is_completed">
                                        Mark as completed
                                    </label>
                                    <div class="form-text text-warning mt-1">
                                        <i data-acorn-icon="warning-hexagon" class="me-1"></i> 
                                        Note: Once a course is marked as completed, it cannot be changed back.
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">Comments</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3"
                                    placeholder="Add any comments about your progress on this course..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="proof_url" class="form-label">Proof URL (Optional)</label>
                                <input type="url" class="form-control" id="proof_url" name="proof_url"
                                    placeholder="https://example.com/my-completion-proof">
                                <div class="form-text">Add a link to a screenshot or other proof of completion</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Course Progress</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- View Course Progress Modal (Read-only for completed courses) -->
        <div class="modal fade" id="viewCourseProgressModal" tabindex="-1"
            aria-labelledby="viewCourseProgressModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewCourseProgressModalLabel">Course Progress Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <h6 id="view_course_title" class="mb-1"></h6>
                        </div>

                        <div class="alert alert-success mb-3">
                            <i data-acorn-icon="check-circle" class="me-2"></i>
                            This course has been marked as completed and cannot be modified.
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Comments</label>
                            <div class="p-3 bg-light rounded" id="view_comment">
                                <em class="text-muted">No comments provided</em>
                            </div>
                        </div>

                        <div class="mb-3" id="proof_url_container">
                            <label class="form-label">Proof URL</label>
                            <div class="p-3 bg-light rounded">
                                <a href="#" id="view_proof_url" target="_blank">View Proof</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .provider-logo-placeholder {
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: rgba(var(--primary-rgb), 0.1);
                border-radius: 4px;
            }

            /* Timeline Styles */
            .timeline {
                position: relative;
                padding-left: 40px;
            }

            .timeline::before {
                content: '';
                position: absolute;
                top: 0;
                left: 15px;
                width: 1px;
                height: 100%;
                background-color: var(--bs-gray-300);
            }

            .timeline-item {
                position: relative;
                margin-bottom: 25px;
            }

            .timeline-icon {
                position: absolute;
                left: -40px;
                top: 0;
                width: 30px;
                height: 30px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .timeline-content {
                padding: 15px;
                border-radius: 5px;
                border: 1px solid var(--bs-gray-200);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Handle course progress update button clicks
                const updateProgressBtns = document.querySelectorAll('.update-progress-btn');
                updateProgressBtns.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const courseId = this.getAttribute('data-course-id');
                        const courseTitle = this.getAttribute('data-course-title');
                        const isCompleted = this.getAttribute('data-is-completed') === '1';
                        const comment = this.getAttribute('data-comment');
                        const proofUrl = this.getAttribute('data-proof-url');

                        document.getElementById('course_id').value = courseId;
                        document.getElementById('course_title').textContent = courseTitle;
                        document.getElementById('is_completed').checked = isCompleted;
                        document.getElementById('comment').value = comment || '';
                        document.getElementById('proof_url').value = proofUrl || '';
                    });
                });
                
                // Handle view progress button clicks for completed courses
                const viewProgressBtns = document.querySelectorAll('.view-progress-btn');
                viewProgressBtns.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const courseTitle = this.getAttribute('data-course-title');
                        const comment = this.getAttribute('data-comment');
                        const proofUrl = this.getAttribute('data-proof-url');
                        
                        document.getElementById('view_course_title').textContent = courseTitle;
                        
                        // Set comment text or show default message
                        const commentEl = document.getElementById('view_comment');
                        if (comment && comment.trim() !== '') {
                            commentEl.textContent = comment;
                            commentEl.classList.remove('text-muted');
                        } else {
                            commentEl.innerHTML = '<em class="text-muted">No comments provided</em>';
                        }
                        
                        // Handle proof URL
                        const proofUrlContainer = document.getElementById('proof_url_container');
                        const proofUrlLink = document.getElementById('view_proof_url');
                        
                        if (proofUrl && proofUrl.trim() !== '') {
                            proofUrlLink.href = proofUrl;
                            proofUrlContainer.style.display = 'block';
                        } else {
                            proofUrlContainer.style.display = 'none';
                        }
                    });
                });
                
                // Auto-dismiss alerts after 5 seconds
                setTimeout(function() {
                    const alerts = document.querySelectorAll('.alert.alert-dismissible');
                    alerts.forEach(function(alert) {
                        const bsAlert = bootstrap.Alert.getInstance(alert);
                        if (bsAlert) {
                            bsAlert.close();
                        }
                    });
                }, 5000);
                
                // Filter out requested_voucher option from study status dropdown if already requested
                const studyStatusSelect = document.getElementById('study_status');
                if (studyStatusSelect) {
                    // Check if voucher has been requested
                    const voucherRequested = {{ $voucherRequestExists ? 'true' : 'false' }};
                    
                    if (voucherRequested) {
                        // Find and disable the option
                        for (let i = 0; i < studyStatusSelect.options.length; i++) {
                            if (studyStatusSelect.options[i].value === 'requested_voucher') {
                                studyStatusSelect.options[i].disabled = true;
                                studyStatusSelect.options[i].text += ' (Already Requested)';
                                break;
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection