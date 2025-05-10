@extends('dashboard-layout.app')

@section('content')
    <div class="container">
        <div class="page-title-container mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1 class="mb-0 pb-0 display-4 text-primary fw-bold" id="title">Intern Profile</h1>
                    <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{ route('mentor.dashboard') }}"
                                    class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('mentor.interns.index') }}"
                                    class="text-decoration-none">Interns</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $intern->first_name }}
                                {{ $intern->last_name }}</li>
                        </ul>
                    </nav>
                </div>
                <div class="col-12 col-md-5 d-flex align-items-center justify-content-md-end mt-3 mt-md-0 gap-2">
                    @if ($currentFlag)
                        <div class="alert alert-danger mb-0 d-flex align-items-center">
                            <i data-acorn-icon="flag" class="me-2"></i>
                            <div>
                                <strong>Flagged:</strong>
                                {{ \Carbon\Carbon::parse($currentFlag->flagged_at)->diffForHumans() }}
                                <div class="small">Status: {{ ucfirst($currentFlag->status) }}</div>
                            </div>
                        </div>
                    @else
                        <button type="button" class="btn btn-outline-warning btn-icon" data-bs-toggle="modal"
                            data-bs-target="#nudgeInternModal"
                            {{ count($nudges) > 0 && $nudges->first()->nudged_at->diffInDays(now()) < 7 ? 'disabled' : '' }}>
                            <i data-acorn-icon="notification" class="me-2"></i>Nudge
                            @if (count($nudges) > 0 && $nudges->first()->nudged_at->diffInDays(now()) < 7)
                                <span class="small">(Already nudged)</span>
                            @endif
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-icon" data-bs-toggle="modal"
                            data-bs-target="#flagInternModal">
                            <i data-acorn-icon="flag" class="me-2"></i>Flag
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Success or Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i data-acorn-icon="check" class="me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i data-acorn-icon="warning-hexagon" class="me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Intern Overview -->
        <div class="row mb-4">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <!-- Profile Card -->
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="rounded bg-opacity-10 mx-auto rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 120px; height: 120px;">
                                <span
                                    class="text-primary fs-1 fw-bold">{{ strtoupper(substr($intern->first_name, 0, 1)) }}{{ strtoupper(substr($intern->last_name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <h4 class="mb-1">{{ $intern->first_name }} {{ $intern->last_name }}</h4>
                        <p class="text-muted">
                            {{ $intern->email }}
                        </p>

                        <div
                            class="badge bg-{{ $intern->status == 'active' ? 'success' : ($intern->status == 'completed' ? 'primary' : 'warning') }} mb-3">
                            {{ ucfirst($intern->status ?? 'Active') }}
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-6">
                                <div class="border rounded-3 py-2 h-100">
                                    <div class="text-muted small">Certificates</div>
                                    <div class="fw-bold">{{ $intern->certificates->count() }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded-3 py-2 h-100">
                                    <div class="text-muted small">Onboarding</div>
                                    <div class="fw-bold">
                                        @if ($intern->onboardingSteps->count() > 0)
                                            {{ $intern->onboardingSteps->where('completed', true)->count() }}/{{ $intern->onboardingSteps->count() }}
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light py-3">
                        <div class="row">
                            <div class="col-6 text-center">
                                <div class="text-muted small">Joined</div>
                                <div>{{ $intern->created_at->format('M d, Y') }}</div>
                            </div>
                            <div class="col-6 text-center">
                                <div class="text-muted small">Last Active</div>
                                <div>{{ $intern->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Details Card -->
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light py-3">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                                    data-bs-target="#details" type="button" role="tab" aria-controls="details"
                                    aria-selected="true">Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="assignments-tab" data-bs-toggle="tab"
                                    data-bs-target="#assignments" type="button" role="tab"
                                    aria-controls="assignments" aria-selected="false">Certificates</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="progress-tab" data-bs-toggle="tab"
                                    data-bs-target="#progress" type="button" role="tab" aria-controls="progress"
                                    aria-selected="false">Progress</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="onboarding-tab" data-bs-toggle="tab"
                                    data-bs-target="#onboarding" type="button" role="tab"
                                    aria-controls="onboarding" aria-selected="false">Onboarding</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Details Tab -->
                            <div class="tab-pane fade show active" id="details" role="tabpanel"
                                aria-labelledby="details-tab">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3">Personal Information</h6>
                                        <div class="mb-2">
                                            <div class="text-muted small">Full Name</div>
                                            <div>{{ $intern->first_name }} {{ $intern->last_name }}</div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="text-muted small">Email Address</div>
                                            <div>{{ $intern->email }}</div>
                                        </div>

                                        <div class="mb-2">
                                            <div class="text-muted small">Role</div>
                                            <div>{{ $intern->role ? ucfirst($intern->role->role) : 'Intern' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-3">Program Information</h6>
                                        <div class="mb-2">
                                            <div class="text-muted small">Status</div>
                                            <div>
                                                <span
                                                    class="badge bg-{{ $intern->status == 'active' ? 'success' : ($intern->status == 'completed' ? 'primary' : 'warning') }}">
                                                    {{ ucfirst($intern->status ?? 'Active') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="text-muted small">Assigned Mentor</div>
                                            <div>
                                                @if ($intern->mentor)
                                                    <span class="text-primary">
                                                        {{ $intern->mentor->first_name }} {{ $intern->mentor->last_name }}
                                                        @if ($intern->mentor->id == Auth::id())
                                                            <span class="badge bg-info">You</span>
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="text-muted">No mentor assigned</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="text-muted small">Joined On</div>
                                            <div>{{ $intern->created_at->format('F d, Y') }}</div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="text-muted small">Last Updated</div>
                                            <div>{{ $intern->updated_at->format('F d, Y h:i A') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Certificates Tab -->
                            <div class="tab-pane fade" id="assignments" role="tabpanel"
                                aria-labelledby="assignments-tab">
                                @if ($intern->certificates->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Certificate</th>
                                                    <th>Started</th>
                                                    <th>Completed</th>
                                                    <th>Exam Status</th>
                                                    <th>Study Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($intern->certificates as $internCertificate)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @if ($internCertificate->certificate && $internCertificate->certificate->provider)
                                                                    <div class="me-3">
                                                                        @if ($internCertificate->certificate->provider->logo)
                                                                            <img src="{{ asset('storage/' . $internCertificate->certificate->provider->logo) }}"
                                                                                alt="Provider" class="rounded"
                                                                                width="40">
                                                                        @else
                                                                            <div class="bg-light text-muted rounded d-flex align-items-center justify-content-center"
                                                                                style="width: 40px; height: 40px;">
                                                                                <i data-acorn-icon="certificate"></i>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                                <div>
                                                                    <div class="fw-medium">
                                                                        {{ $internCertificate->certificate->title ?? 'Unknown Certificate' }}
                                                                    </div>
                                                                    <div class="text-muted small">
                                                                        {{ $internCertificate->certificate->provider->name ?? 'Unknown Provider' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($internCertificate->started_at)
                                                                {{ \Carbon\Carbon::parse($internCertificate->started_at)->format('M d, Y') }}
                                                            @else
                                                                <span class="text-muted">Not started</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($internCertificate->completed_at)
                                                                {{ \Carbon\Carbon::parse($internCertificate->completed_at)->format('M d, Y') }}
                                                            @else
                                                                <span class="text-muted">In progress</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $statusBadge = 'secondary';
                                                                switch ($internCertificate->exam_status) {
                                                                    case 'scheduled':
                                                                        $statusBadge = 'info';
                                                                        break;
                                                                    case 'passed':
                                                                        $statusBadge = 'success';
                                                                        break;
                                                                    case 'failed':
                                                                        $statusBadge = 'danger';
                                                                        break;
                                                                    default:
                                                                        $statusBadge = 'secondary';
                                                                }
                                                            @endphp
                                                            <span class="badge bg-{{ $statusBadge }}">
                                                                {{ ucfirst(str_replace('_', ' ', $internCertificate->exam_status ?? 'not_started')) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @php
                                                                $latestProgress = $internCertificate->progress
                                                                    ->sortByDesc('created_at')
                                                                    ->first();
                                                                $studyStatusBadge = 'secondary';
                                                                $studyStatus = 'Not started';

                                                                if ($latestProgress) {
                                                                    switch ($latestProgress->study_status) {
                                                                        case 'in_progress':
                                                                            $studyStatusBadge = 'warning';
                                                                            $studyStatus = 'In Progress';
                                                                            break;
                                                                        case 'completed':
                                                                            $studyStatusBadge = 'success';
                                                                            $studyStatus = 'Completed';
                                                                            break;
                                                                        case 'needs_help':
                                                                            $studyStatusBadge = 'danger';
                                                                            $studyStatus = 'Needs Help';
                                                                            break;
                                                                        default:
                                                                            $studyStatusBadge = 'secondary';
                                                                            $studyStatus = 'Not Started';
                                                                    }
                                                                }
                                                            @endphp
                                                            <span class="badge bg-{{ $studyStatusBadge }}">
                                                                {{ $studyStatus }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary" type="button"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#certificateModal{{ $internCertificate->id }}">
                                                                <i data-acorn-icon="eye"></i>
                                                            </button>
                                                
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i data-acorn-icon="certificate" style="font-size: 3rem;"
                                                class="text-muted"></i>
                                        </div>
                                        <h6 class="text-muted">No certificates assigned yet</h6>
                                    </div>
                                @endif
                            </div>

                            <!-- Progress Tab -->
                            <div class="tab-pane fade" id="progress" role="tabpanel" aria-labelledby="progress-tab">
                                @php
                                    $hasCertificates = $intern->certificates->count() > 0;
                                @endphp

                                @if ($hasCertificates)
                                    <div class="mb-4">
                                        <h5 class="fw-bold mb-3">Certificate Progress</h5>
                                        <div class="row g-3">
                                            @foreach ($intern->certificates as $internCertificate)
                                                <div class="col-lg-6 mb-3">
                                                    <div class="card certificate-progress-card h-100">
                                                        <div class="card-body certificate-card-front">
                                                            <div
                                                                class="d-flex justify-content-between align-items-start mb-3">
                                                                <div class="d-flex align-items-center">
                                                                    @if ($internCertificate->certificate && $internCertificate->certificate->provider)
                                                                        <div class="me-3">
                                                                            @if ($internCertificate->certificate->provider->logo)
                                                                                <img src="{{ asset('storage/' . $internCertificate->certificate->provider->logo) }}"
                                                                                    alt="Provider" class="rounded"
                                                                                    width="40">
                                                                            @else
                                                                                <div class="bg-light text-muted rounded d-flex align-items-center justify-content-center"
                                                                                    style="width: 40px; height: 40px;">
                                                                                    <i data-acorn-icon="certificate"></i>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                    <h6 class="mb-0">
                                                                        {{ $internCertificate->certificate->title ?? 'Unknown Certificate' }}
                                                                    </h6>
                                                                </div>
                                                                <div>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-primary toggle-certificate-details"
                                                                        data-certificate-id="{{ $internCertificate->id }}">
                                                                        <i data-acorn-icon="arrow-bottom" class="icon-default"></i>
                                                                        <i data-acorn-icon="arrow-top" class="icon-expanded d-none"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div class="certificate-status-panel mb-3">
                                                                <div class="row g-2">
                                                                    <div class="col-6">
                                                                        <div class="border rounded p-2">
                                                                            <div class="text-muted small">Started</div>
                                                                            <div class="fw-medium">
                                                                                @if ($internCertificate->started_at)
                                                                                    {{ \Carbon\Carbon::parse($internCertificate->started_at)->format('M d, Y') }}
                                                                                @else
                                                                                    <span class="text-muted">Not
                                                                                        started</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="border rounded p-2">
                                                                            <div class="text-muted small">Completed</div>
                                                                            <div class="fw-medium">
                                                                                @if ($internCertificate->completed_at)
                                                                                    {{ \Carbon\Carbon::parse($internCertificate->completed_at)->format('M d, Y') }}
                                                                                @else
                                                                                    <span class="text-muted">In
                                                                                        progress</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="border rounded p-2">
                                                                            <div class="text-muted small">Exam Status</div>
                                                                            <div class="fw-medium">
                                                                                @php
                                                                                    $statusBadge = 'secondary';
                                                                                    switch (
                                                                                        $internCertificate->exam_status
                                                                                    ) {
                                                                                        case 'scheduled':
                                                                                            $statusBadge = 'info';
                                                                                            break;
                                                                                        case 'passed':
                                                                                            $statusBadge = 'success';
                                                                                            break;
                                                                                        case 'failed':
                                                                                            $statusBadge = 'danger';
                                                                                            break;
                                                                                        default:
                                                                                            $statusBadge = 'secondary';
                                                                                    }
                                                                                @endphp
                                                                                <span
                                                                                    class="badge bg-{{ $statusBadge }}">
                                                                                    {{ ucfirst(str_replace('_', ' ', $internCertificate->exam_status ?? 'not_taken')) }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="border rounded p-2">
                                                                            <div class="text-muted small">Study Status
                                                                            </div>
                                                                            <div class="fw-medium">
                                                                                @php
                                                                                    $latestProgress = $internCertificate->progress
                                                                                        ->sortByDesc('created_at')
                                                                                        ->first();
                                                                                    $studyStatusBadge = 'secondary';
                                                                                    $studyStatus = 'Not started';

                                                                                    if ($latestProgress) {
                                                                                        switch (
                                                                                            $latestProgress->study_status
                                                                                        ) {
                                                                                            case 'in_progress':
                                                                                                $studyStatusBadge =
                                                                                                    'warning';
                                                                                                $studyStatus =
                                                                                                    'In Progress';
                                                                                                break;
                                                                                            case 'studying_for_exam':
                                                                                                $studyStatusBadge =
                                                                                                    'info';
                                                                                                $studyStatus =
                                                                                                    'Studying for Exam';
                                                                                                break;
                                                                                            case 'requested_voucher':
                                                                                                $studyStatusBadge =
                                                                                                    'primary';
                                                                                                $studyStatus =
                                                                                                    'Voucher Requested';
                                                                                                break;
                                                                                            case 'took_exam':
                                                                                                $studyStatusBadge =
                                                                                                    'info';
                                                                                                $studyStatus =
                                                                                                    'Took Exam';
                                                                                                break;
                                                                                            case 'passed':
                                                                                                $studyStatusBadge =
                                                                                                    'success';
                                                                                                $studyStatus = 'Passed';
                                                                                                break;
                                                                                            case 'failed':
                                                                                                $studyStatusBadge =
                                                                                                    'danger';
                                                                                                $studyStatus = 'Failed';
                                                                                                break;
                                                                                            default:
                                                                                                $studyStatusBadge =
                                                                                                    'secondary';
                                                                                                $studyStatus =
                                                                                                    'Not Started';
                                                                                        }
                                                                                    }
                                                                                @endphp
                                                                                <span
                                                                                    class="badge bg-{{ $studyStatusBadge }}">
                                                                                    {{ $studyStatus }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Certificate Progress Timeline (Collapsed by Default) -->
                                                            <div class="certificate-timeline-container collapse"
                                                                id="certificateTimeline{{ $internCertificate->id }}">
                                                                @if ($internCertificate->progress->count() > 0)
                                                                    <h6 class="fw-medium mb-2">Certificate Progress
                                                                        Timeline</h6>
                                                                    <div class="timeline">
                                                                        @foreach ($internCertificate->progress->sortByDesc('created_at') as $certProgress)
                                                                            <div class="timeline-item">
                                                                                <div class="timeline-icon bg-primary">
                                                                                    <i data-acorn-icon="note"
                                                                                        class="text-white"></i>
                                                                                </div>
                                                                                <div class="timeline-content">
                                                                                    <div class="time text-muted small">
                                                                                        {{ \Carbon\Carbon::parse($certProgress->created_at)->format('M d, Y h:i A') }}
                                                                                    </div>
                                                                                    <div class="mb-2">
                                                                                        <span
                                                                                            class="badge bg-{{ $certProgress->study_status == 'passed'
                                                                                                ? 'success'
                                                                                                : ($certProgress->study_status == 'failed'
                                                                                                    ? 'danger'
                                                                                                    : ($certProgress->study_status == 'studying_for_exam'
                                                                                                        ? 'info'
                                                                                                        : ($certProgress->study_status == 'requested_voucher'
                                                                                                            ? 'primary'
                                                                                                            : ($certProgress->study_status == 'took_exam'
                                                                                                                ? 'info'
                                                                                                                : 'warning')))) }}">
                                                                                            {{ ucfirst(str_replace('_', ' ', $certProgress->study_status ?? 'Not Started')) }}
                                                                                        </span>

                                                                                        @if ($certProgress->voucher_requested_at)
                                                                                            <span
                                                                                                class="badge bg-info ms-2">Voucher
                                                                                                Requested</span>
                                                                                        @endif

                                                                                        @if ($certProgress->exam_date)
                                                                                            <span
                                                                                                class="badge bg-primary ms-2">Exam
                                                                                                Scheduled</span>
                                                                                        @endif
                                                                                    </div>

                                                                                    @if ($certProgress->notes)
                                                                                        <p class="mb-2">
                                                                                            {{ $certProgress->notes }}</p>
                                                                                    @endif

                                                                                    @if ($certProgress->updated_by_mentor)
                                                                                        <div class="mt-2">
                                                                                            <span
                                                                                                class="badge bg-info">Updated
                                                                                                by Mentor</span>
                                                                                        </div>
                                                                                    @endif

                                                                                    <div class="mt-2RetryClaude hit the max length for a message and has paused its response. You can write Continue to keep the chat going.AContinueEditphpclass="mt-2
                                                                                        d-flex flex-wrap gap-2">
                                                                                        @if ($certProgress->exam_date)
                                                                                            <div class="small text-muted">
                                                                                                <i data-acorn-icon="calendar"
                                                                                                    class="me-1"></i>
                                                                                                Exam:
                                                                                                {{ \Carbon\Carbon::parse($certProgress->exam_date)->format('M d, Y') }}
                                                                                            </div>
                                                                                        @endif

                                                                                        @if ($certProgress->voucher_requested_at)
                                                                                            <div class="small text-muted">
                                                                                                <i data-acorn-icon="ticket"
                                                                                                    class="me-1"></i>
                                                                                                Voucher:
                                                                                                {{ \Carbon\Carbon::parse($certProgress->voucher_requested_at)->format('M d, Y') }}
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <div class="text-center py-3">
                                                                        <span class="text-muted">No certificate progress
                                                                            updates yet</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="text-center mt-2">
                                                                <button
                                                                    class="btn btn-sm btn-outline-primary toggle-certificate-courses"
                                                                    data-certificate-id="{{ $internCertificate->id }}">
                                                                    <i data-acorn-icon="chevron-right"
                                                                        class="me-1 flip-icon"></i>
                                                                    View Course Progress
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- Course Progress Side (Hidden by Default) -->
                                                        <div class="card-body certificate-card-back d-none">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-3">
                                                                <h6 class="mb-0">Course Progress -
                                                                    {{ $internCertificate->certificate->title }}</h6>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-primary toggle-certificate-courses"
                                                                    data-certificate-id="{{ $internCertificate->id }}">
                                                                    <i data-acorn-icon="chevron-left"
                                                                        class="me-1 flip-icon"></i>
                                                                    Back to Certificate
                                                                </button>
                                                            </div>

                                                            @php
                                                                // Get progress updates for this specific certificate
                                                                $courseProgressUpdates = $intern->progressUpdates->where(
                                                                    'certificate_id',
                                                                    $internCertificate->certificate_id,
                                                                );
                                                            @endphp

                                                            @if ($courseProgressUpdates->count() > 0)
                                                                <div class="course-progress-timeline">
                                                                    @foreach ($courseProgressUpdates->sortByDesc('created_at') as $update)
                                                                        <div
                                                                            class="card mb-2 border-{{ $update->is_completed ? 'success' : 'warning' }}">
                                                                            <div class="card-body p-3">
                                                                                <div
                                                                                    class="d-flex justify-content-between" style="max-height: 20px;" >
                                                                                    <div class="fw-medium">
                                                                                        {{ $update->course->title ?? 'Unknown Course' }}
                                                                                    </div>
                                                                                    <span
                                                                                        class="badge bg-{{ $update->is_completed ? 'success' : 'warning' }}">
                                                                                        {{ $update->is_completed ? 'Completed' : 'In Progress' }}
                                                                                    </span>
                                                                                </div>

                                                                                <div class="text-muted small mt-4">
                                                                                    Updated:
                                                                                    {{ \Carbon\Carbon::parse($update->created_at)->format('M d, Y') }}
                                                                                </div>

                                                                                @if ($update->comment)
                                                                                    <p class="mt-2 mb-1 small">
                                                                                        {{ $update->comment }}</p>
                                                                                @endif

                                                                                <div class="mt-2 d-flex flex-wrap gap-2">
                                                                                    @if ($update->proof_url)
                                                                                        <a href="{{ $update->proof_url }}"
                                                                                            target="_blank"
                                                                                            class="btn btn-sm btn-outline-primary">
                                                                                            <i data-acorn-icon="link"
                                                                                                class="me-1"></i> Proof
                                                                                        </a>
                                                                                    @endif

                                                                                    @if ($update->updated_by_mentor)
                                                                                        <span class="badge bg-info">Mentor
                                                                                            Updated</span>
                                                                                    @endif

                                                                                    @if ($update->completed_at)
                                                                                        <span
                                                                                            class="badge bg-light text-dark">
                                                                                            Completed:
                                                                                            {{ \Carbon\Carbon::parse($update->completed_at)->format('M d, Y') }}
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <div class="text-center py-3">
                                                                    <span class="text-muted">No course progress updates
                                                                        yet</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i data-acorn-icon="chart" style="font-size: 3rem;" class="text-muted"></i>
                                        </div>
                                        <h6 class="text-muted">No certificates or progress updates recorded yet</h6>
                                    </div>
                                @endif
                            </div>

                            <!-- Onboarding Tab -->
                            <div class="tab-pane fade" id="onboarding" role="tabpanel" aria-labelledby="onboarding-tab">
                                @if ($intern->onboardingSteps->count() > 0)
                                    <div class="mb-3">
                                        @php
                                            $completedSteps = $intern->onboardingSteps
                                                ->where('completed', true)
                                                ->count();
                                            $totalSteps = $intern->onboardingSteps->count();
                                            $percentComplete =
                                                $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
                                        @endphp
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <span class="fw-medium">Onboarding Progress</span>
                                            </div>
                                            <div>
                                                <span class="badge bg-primary">{{ $percentComplete }}% complete</span>
                                            </div>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $percentComplete }}%;"
                                                aria-valuenow="{{ $percentComplete }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th width="50">#</th>
                                                    <th width="60%">Step Name</th>
                                                    <th>Status</th>
                                                    <th>Completed At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($intern->onboardingSteps->sortBy('step.order') as $onboardingStep)
                                                    <tr>
                                                        <td>{{ $onboardingStep->step->order ?? $loop->iteration }}</td>
                                                        <td>
                                                            <div class="fw-medium">
                                                                {{ $onboardingStep->step->title ?? 'Unknown Step' }}</div>
                                                            <div class="text-muted small">
                                                                {!! nl2br(e($onboardingStep->step->description ?? '')) !!}</div>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge bg-{{ $onboardingStep->completed ? 'success' : 'warning' }}">
                                                                {{ $onboardingStep->completed ? 'Completed' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if ($onboardingStep->completed_at)
                                                                {{ \Carbon\Carbon::parse($onboardingStep->completed_at)->format('M d, Y') }}
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i data-acorn-icon="list-check" style="font-size: 3rem;"
                                                class="text-muted"></i>
                                        </div>
                                        <h6 class="text-muted">No onboarding steps taken yet</h6>

                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mentor Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h5 class="card-title mb-0">Mentor Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#sendEmailModal">
                                    <i data-acorn-icon="email" class="me-2"></i> Send Email
                                </button>
                            </div>


                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-info w-100" data-bs-toggle="modal"
                                    data-bs-target="#scheduleSessionModal">
                                    <i data-acorn-icon="calendar" class="me-2"></i> Schedule Session
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('mentor.interns.flag-nudge-modals')
    <!-- Certificate Details Modals -->
    @foreach ($intern->certificates as $internCertificate)
        <div class="modal fade" id="certificateModal{{ $internCertificate->id }}" tabindex="-1"
            aria-labelledby="certificateModalLabel{{ $internCertificate->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="certificateModalLabel{{ $internCertificate->id }}">
                            Certificate Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <!-- Certificate Header -->
                        <div class="bg-light p-3 border-bottom">
                            <div class="d-flex align-items-center">
                                @if ($internCertificate->certificate && $internCertificate->certificate->provider)
                                    <div class="me-3">
                                        @if ($internCertificate->certificate->provider->logo)
                                            <img src="{{ asset('storage/' . $internCertificate->certificate->provider->logo) }}"
                                                alt="Provider" class="rounded" width="60">
                                        @else
                                            <div class="bg-light text-muted rounded d-flex align-items-center justify-content-center"
                                                style="width: 60px; height: 60px;">
                                                <i data-acorn-icon="certificate"></i>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-1">
                                        {{ $internCertificate->certificate->title ?? 'Unknown Certificate' }}</h5>
                                    <div class="text-muted">
                                        {{ $internCertificate->certificate->provider->name ?? 'Unknown Provider' }}
                                        @if ($internCertificate->certificate->level)
                                            <span
                                                class="badge bg-info ms-2">{{ ucfirst($internCertificate->certificate->level) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs nav-fill" id="certificateDetailTabs{{ $internCertificate->id }}"
                            role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="overview-tab{{ $internCertificate->id }}"
                                    data-bs-toggle="tab" data-bs-target="#overview{{ $internCertificate->id }}"
                                    type="button" role="tab" aria-selected="true">
                                    Overview
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="certificate-progress-tab{{ $internCertificate->id }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#certificate-progress{{ $internCertificate->id }}" type="button"
                                    role="tab" aria-selected="false">
                                    Certificate Progress
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="course-progress-tab{{ $internCertificate->id }}"
                                    data-bs-toggle="tab" data-bs-target="#course-progress{{ $internCertificate->id }}"
                                    type="button" role="tab" aria-selected="false">
                                    Course Progress
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content p-3" id="certificateDetailTabsContent{{ $internCertificate->id }}">
                            <!-- Overview Tab -->
                            <div class="tab-pane fade show active" id="overview{{ $internCertificate->id }}"
                                role="tabpanel">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-header py-2 bg-light">
                                                <h6 class="mb-0">Certificate Information</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-2">
                                                    <div class="text-muted small">Started Date</div>
                                                    <div class="fw-medium">
                                                        @if ($internCertificate->started_at)
                                                            {{ \Carbon\Carbon::parse($internCertificate->started_at)->format('F d, Y') }}
                                                        @else
                                                            <span class="text-muted">Not started</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <div class="text-muted small">Completed Date</div>
                                                    <div class="fw-medium">
                                                        @if ($internCertificate->completed_at)
                                                            {{ \Carbon\Carbon::parse($internCertificate->completed_at)->format('F d, Y') }}
                                                        @else
                                                            <span class="text-muted">In progress</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <div class="text-muted small">Duration</div>
                                                    <div class="fw-medium">
                                                        @if ($internCertificate->started_at)
                                                            @if ($internCertificate->completed_at)
                                                                {{ \Carbon\Carbon::parse($internCertificate->started_at)->diffForHumans(\Carbon\Carbon::parse($internCertificate->completed_at), true) }}
                                                            @else
                                                                {{ \Carbon\Carbon::parse($internCertificate->started_at)->diffForHumans(null, true) }}
                                                                (ongoing)
                                                            @endif
                                                        @else
                                                            <span class="text-muted">Not started</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-header py-2 bg-light">
                                                <h6 class="mb-0">Exam Information</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-2">
                                                    <div class="text-muted small">Exam Status</div>
                                                    <div class="fw-medium">
                                                        @php
                                                            $statusBadge = 'secondary';
                                                            switch ($internCertificate->exam_status) {
                                                                case 'scheduled':
                                                                    $statusBadge = 'info';
                                                                    break;
                                                                case 'passed':
                                                                    $statusBadge = 'success';
                                                                    break;
                                                                case 'failed':
                                                                    $statusBadge = 'danger';
                                                                    break;
                                                                default:
                                                                    $statusBadge = 'secondary';
                                                            }
                                                        @endphp
                                                        <span class="badge bg-{{ $statusBadge }} fs-6">
                                                            {{ ucfirst(str_replace('_', ' ', $internCertificate->exam_status ?? 'not_taken')) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <div class="text-muted small">Voucher ID</div>
                                                    <div class="fw-medium">
                                                        @if ($internCertificate->voucher_id)
                                                            <code>{{ $internCertificate->voucher_id }}</code>
                                                        @else
                                                            <span class="text-muted">Not assigned</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <div class="text-muted small">Study Status</div>
                                                    <div class="fw-medium">
                                                        @php
                                                            $latestProgress = $internCertificate->progress
                                                                ->sortByDesc('created_at')
                                                                ->first();
                                                            $studyStatusBadge = 'secondary';
                                                            $studyStatus = 'Not started';

                                                            if ($latestProgress) {
                                                                switch ($latestProgress->study_status) {
                                                                    case 'in_progress':
                                                                        $studyStatusBadge = 'warning';
                                                                        $studyStatus = 'In Progress';
                                                                        break;
                                                                    case 'studying_for_exam':
                                                                        $studyStatusBadge = 'info';
                                                                        $studyStatus = 'Studying for Exam';
                                                                        break;
                                                                    case 'requested_voucher':
                                                                        $studyStatusBadge = 'primary';
                                                                        $studyStatus = 'Voucher Requested';
                                                                        break;
                                                                    case 'took_exam':
                                                                        $studyStatusBadge = 'info';
                                                                        $studyStatus = 'Took Exam';
                                                                        break;
                                                                    case 'passed':
                                                                        $studyStatusBadge = 'success';
                                                                        $studyStatus = 'Passed';
                                                                        break;
                                                                    case 'failed':
                                                                        $studyStatusBadge = 'danger';
                                                                        $studyStatus = 'Failed';
                                                                        break;
                                                                    default:
                                                                        $studyStatusBadge = 'secondary';
                                                                        $studyStatus = 'Not Started';
                                                                }
                                                            }
                                                        @endphp
                                                        <span class="badge bg-{{ $studyStatusBadge }} fs-6">
                                                            {{ $studyStatus }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($internCertificate->certificate && $internCertificate->certificate->description)
                                    <div class="mb-3">
                                        <h6 class="fw-medium mb-2">Certificate Description</h6>
                                        <div class="p-3 bg-light rounded">
                                            {!! nl2br(e($internCertificate->certificate->description)) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Certificate Progress Tab -->
                            <div class="tab-pane fade" id="certificate-progress{{ $internCertificate->id }}"
                                role="tabpanel">
                                @if ($internCertificate->progress->count() > 0)
                                    <h6 class="fw-medium mb-3">Certificate Progress History</h6>
                                    <div class="timeline">
                                        @foreach ($internCertificate->progress->sortByDesc('created_at') as $certProgress)
                                            <div class="timeline-item">
                                                <div class="timeline-icon bg-primary">
                                                    <i data-acorn-icon="note" class="text-white"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <div class="time text-muted small">
                                                        {{ \Carbon\Carbon::parse($certProgress->created_at)->format('M d, Y h:i A') }}
                                                    </div>
                                                    <div class="mb-2">
                                                        <span
                                                            class="badge bg-{{ $certProgress->study_status == 'passed'
                                                                ? 'success'
                                                                : ($certProgress->study_status == 'failed'
                                                                    ? 'danger'
                                                                    : ($certProgress->study_status == 'studying_for_exam'
                                                                        ? 'info'
                                                                        : ($certProgress->study_status == 'requested_voucher'
                                                                            ? 'primary'
                                                                            : ($certProgress->study_status == 'took_exam'
                                                                                ? 'info'
                                                                                : 'warning')))) }}">
                                                            {{ ucfirst(str_replace('_', ' ', $certProgress->study_status ?? 'Not Started')) }}
                                                        </span>

                                                        @if ($certProgress->voucher_requested_at)
                                                            <span class="badge bg-info ms-2">Voucher Requested</span>
                                                        @endif

                                                        @if ($certProgress->exam_date)
                                                            <span class="badge bg-primary ms-2">Exam Scheduled</span>
                                                        @endif
                                                    </div>

                                                    @if ($certProgress->notes)
                                                        <p class="mb-2">{{ $certProgress->notes }}</p>
                                                    @endif

                                                    @if ($certProgress->updated_by_mentor)
                                                        <div class="mt-2">
                                                            <span class="badge bg-info">Updated by Mentor</span>
                                                        </div>
                                                    @endif

                                                    <div class="mt-2 d-flex flex-wrap gap-2">
                                                        @if ($certProgress->exam_date)
                                                            <div class="small text-muted">
                                                                <i data-acorn-icon="calendar" class="me-1"></i>
                                                                Exam:
                                                                {{ \Carbon\Carbon::parse($certProgress->exam_date)->format('M d, Y') }}
                                                            </div>
                                                        @endif

                                                        @if ($certProgress->voucher_requested_at)
                                                            <div class="small text-muted">
                                                                <i data-acorn-icon="ticket" class="me-1"></i>
                                                                Voucher:
                                                                {{ \Carbon\Carbon::parse($certProgress->voucher_requested_at)->format('M d, Y') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i data-acorn-icon="chart" style="font-size: 3rem;" class="text-muted"></i>
                                        </div>
                                        <h6 class="text-muted">No certificate progress updates recorded yet</h6>
                                    </div>
                                @endif
                            </div>

                            <!-- Course Progress Tab -->
                            <div class="tab-pane fade" id="course-progress{{ $internCertificate->id }}"
                                role="tabpanel">
                                @php
                                    // Get progress updates for this specific certificate
                                    $courseProgressUpdates = $intern->progressUpdates->where(
                                        'certificate_id',
                                        $internCertificate->certificate_id,
                                    );

                                    // Get all courses for this certificate
                                    $certificateCourses = $internCertificate->certificate->courses ?? collect();

                                    // Group progress by course
                                    $courseProgressMap = collect();
                                    foreach ($certificateCourses as $course) {
                                        $courseProgress = $courseProgressUpdates
                                            ->where('course_id', $course->id)
                                            ->sortByDesc('created_at')
                                            ->first();
                                        $courseProgressMap->put($course->id, [
                                            'course' => $course,
                                            'progress' => $courseProgress,
                                            'all_updates' => $courseProgressUpdates
                                                ->where('course_id', $course->id)
                                                ->sortByDesc('created_at'),
                                        ]);
                                    }
                                @endphp

                                @if ($certificateCourses->count() > 0)
                                    <div class="mb-3">
                                        <h6 class="fw-medium mb-3">Course Progress Summary</h6>
                                        <div class="progress" style="height: 24px;">
                                            @php
                                                $completedCourses = $courseProgressMap
                                                    ->filter(function ($item) {
                                                        return $item['progress'] && $item['progress']->is_completed;
                                                    })
                                                    ->count();

                                                $inProgressCourses = $courseProgressMap
                                                    ->filter(function ($item) {
                                                        return $item['progress'] && !$item['progress']->is_completed;
                                                    })
                                                    ->count();

                                                $notStartedCourses =
                                                    $certificateCourses->count() -
                                                    $completedCourses -
                                                    $inProgressCourses;

                                                $completedPercent =
                                                    $certificateCourses->count() > 0
                                                        ? round(
                                                            ($completedCourses / $certificateCourses->count()) * 100,
                                                        )
                                                        : 0;

                                                $inProgressPercent =
                                                    $certificateCourses->count() > 0
                                                        ? round(
                                                            ($inProgressCourses / $certificateCourses->count()) * 100,
                                                        )
                                                        : 0;

                                                $notStartedPercent = 100 - $completedPercent - $inProgressPercent;
                                            @endphp

                                            @if ($completedPercent > 0)
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ $completedPercent }}%"
                                                    aria-valuenow="{{ $completedPercent }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    {{ $completedCourses }} Completed
                                                </div>
                                            @endif

                                            @if ($inProgressPercent > 0)
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: {{ $inProgressPercent }}%"
                                                    aria-valuenow="{{ $inProgressPercent }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    {{ $inProgressCourses }} In Progress
                                                </div>
                                            @endif

                                            @if ($notStartedPercent > 0)
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: {{ $notStartedPercent }}%"
                                                    aria-valuenow="{{ $notStartedPercent }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    {{ $notStartedCourses }} Not Started
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="accordion" id="coursesAccordion{{ $internCertificate->id }}">
                                        @foreach ($certificateCourses->sortBy('step_order') as $course)
                                            @php
                                                $courseData = $courseProgressMap->get($course->id);
                                                $courseProgress = $courseData ? $courseData['progress'] : null;
                                                $allUpdates = $courseData ? $courseData['all_updates'] : collect();
                                                $statusClass = !$courseProgress
                                                    ? 'secondary'
                                                    : ($courseProgress->is_completed
                                                        ? 'success'
                                                        : 'warning');

                                                $statusText = !$courseProgress
                                                    ? 'Not Started'
                                                    : ($courseProgress->is_completed
                                                        ? 'Completed'
                                                        : 'In Progress');
                                            @endphp

                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="courseHeading{{ $course->id }}">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#courseCollapse{{ $course->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="courseCollapse{{ $course->id }}">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center w-100 me-3">
                                                            <div>
                                                                <span
                                                                    class="badge bg-secondary me-2">{{ $course->step_order }}</span>
                                                                {{ $course->title }}
                                                            </div>
                                                            <span
                                                                class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="courseCollapse{{ $course->id }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="courseHeading{{ $course->id }}"
                                                    data-bs-parent="#coursesAccordion{{ $internCertificate->id }}">
                                                    <div class="accordion-body">
                                                        <div class="mb-3">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <div class="text-muted small">Estimated Duration</div>
                                                                    <div>{{ $course->estimated_minutes }} minutes</div>
                                                                </div>
                                                                @if ($course->resource_link)
                                                                    <div>
                                                                        <a href="{{ $course->resource_link }}"
                                                                            target="_blank"
                                                                            class="btn btn-sm btn-outline-primary">
                                                                            <i data-acorn-icon="book" class="me-1"></i>
                                                                            View Resource
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        @if ($course->description)
                                                            <div class="mb-3">
                                                                <div class="text-muted small mb-1">Description</div>
                                                                <p>{!! nl2br(e($course->description)) !!}</p>
                                                            </div>
                                                        @endif

                                                        @if ($allUpdates->count() > 0)
                                                            <div class="mt-4">
                                                                <h6 class="fw-medium mb-2">Progress Updates</h6>
                                                                <div class="timeline-mini">
                                                                    @foreach ($allUpdates as $update)
                                                                        <div class="timeline-mini-item">
                                                                            <div
                                                                                class="timeline-mini-icon {{ $update->is_completed ? 'bg-success' : 'bg-warning' }}">
                                                                                <i data-acorn-icon="{{ $update->is_completed ? 'check' : 'clock' }}"
                                                                                    class="text-white"></i>
                                                                            </div>
                                                                            <div class="timeline-mini-content">
                                                                                <div
                                                                                    class="d-flex justify-content-between">
                                                                                    <div class="time text-muted small">
                                                                                        {{ \Carbon\Carbon::parse($update->created_at)->format('M d, Y') }}
                                                                                    </div>
                                                                                    <span
                                                                                        class="badge bg-{{ $update->is_completed ? 'success' : 'warning' }}">
                                                                                        {{ $update->is_completed ? 'Completed' : 'In Progress' }}
                                                                                    </span>
                                                                                </div>
                                                                                @if ($update->comment)
                                                                                    <p class="my-2">
                                                                                        {{ $update->comment }}</p>
                                                                                @endif
                                                                                <div class="d-flex flex-wrap gap-2 mt-2">
                                                                                    @if ($update->proof_url)
                                                                                        <a href="{{ $update->proof_url }}"
                                                                                            target="_blank"
                                                                                            class="btn btn-sm btn-outline-primary">
                                                                                            <i data-acorn-icon="link"
                                                                                                class="me-1"></i> View
                                                                                            Proof
                                                                                        </a>
                                                                                    @endif

                                                                                    @if ($update->completed_at)
                                                                                        <span
                                                                                            class="badge bg-light text-dark">
                                                                                            Completed:
                                                                                            {{ \Carbon\Carbon::parse($update->completed_at)->format('M d, Y') }}
                                                                                        </span>
                                                                                    @endif

                                                                                    @if ($update->updated_by_mentor)
                                                                                        <span class="badge bg-info">Mentor
                                                                                            Updated</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="alert alert-light border text-center my-3">
                                                                <i data-acorn-icon="notebook-empty" class="me-1"></i>
                                                                No progress updates for this course yet
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i data-acorn-icon="notebook-empty" style="font-size: 3rem;"
                                                class="text-muted"></i>
                                        </div>
                                        <h6 class="text-muted">No courses found for this certificate</h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @if ($internCertificate->certificate && $internCertificate->certificate->courses->count() > 0)
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#updateCertificateModal{{ $internCertificate->id }}">
                                <i data-acorn-icon="edit" class="me-1"></i> Update Progress
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <!-- Send Email Modal -->
    <div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendEmailModalLabel">Send Email to {{ $intern->first_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('mentor.interns.send-email', $intern->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email_to" class="form-label">To</label>
                            <input type="email" class="form-control" id="email_to" value="{{ $intern->email }}"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="email_subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="email_subject" name="subject" required>
                        </div>

                        <div class="mb-3">
                            <label for="email_message" class="form-label">Message</label>
                            <textarea class="form-control" id="email_message" name="message" rows="6" required></textarea>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="email_copy_me" name="copy_me"
                                value="1" checked>
                            <label class="form-check-label" for="email_copy_me">
                                Send a copy to me
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Schedule Session Modal -->
    <div class="modal fade" id="scheduleSessionModal" tabindex="-1" aria-labelledby="scheduleSessionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="scheduleSessionModalLabel">Schedule Mentoring Session</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('mentor.sessions.store', ['intern' => $intern->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="mentor_id" value="{{ Auth::id() }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="session_title" class="form-label">Session Title</label>
                            <input type="text" class="form-control" id="session_title" name="title" required
                                placeholder="E.g., Weekly Progress Check, Exam Preparation"
                                value="Mentoring Session with {{ $intern->first_name }}">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="session_date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="session_date" name="session_date"
                                    required min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="session_time" class="form-label">Time</label>
                                <input type="time" class="form-control" id="session_time" name="session_time"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="session_duration" class="form-label">Duration (minutes)</label>
                            <select class="form-select" id="session_duration" name="duration" required>
                                <option value="15">15 minutes</option>
                                <option value="30" selected>30 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="60">60 minutes</option>
                                <option value="90">90 minutes</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="meeting_link" class="form-label">Meeting Link (Optional)</label>
                            <input type="url" class="form-control" id="meeting_link" name="meeting_link"
                                placeholder="https://zoom.us/j/123456789">
                            <small class="form-text text-muted">Enter a Zoom, Teams, or other video conferencing
                                link</small>
                        </div>

                        <div class="mb-3">
                            <label for="session_status" class="form-label">Status</label>
                            <select class="form-select" id="session_status" name="status">
                                <option value="scheduled" selected>Scheduled</option>
                                <option value="rescheduled">Rescheduled</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="session_agenda" class="form-label">Agenda</label>
                            <textarea class="form-control" id="session_agenda" name="agenda" rows="3"
                                placeholder="Topics to discuss, things to prepare, etc."></textarea>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="intern_notified" name="intern_notified"
                                value="1" checked>
                            <label class="form-check-label" for="intern_notified">
                                Send calendar invite to intern
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Schedule Session</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add this to your existing script section
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle recurrence options based on checkbox
            const isRecurringCheckbox = document.getElementById('is_recurring');
            const recurrenceOptions = document.getElementById('recurrence_options');

            if (isRecurringCheckbox && recurrenceOptions) {
                isRecurringCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        recurrenceOptions.style.display = 'block';
                    } else {
                        recurrenceOptions.style.display = 'none';
                    }
                });
            }
        });
    </script>

    @push('styles')
        <style>
            /* Timeline Styles */
            .timeline {
                position: relative;
                padding-left: 40px;
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

            .timeline::before {
                content: '';
                position: absolute;
                top: 0;
                left: -25px;
                width: 1px;
                height: 100%;
                background: var(--bs-gray-300);
            }

            /* Mini Timeline */
            .timeline-mini {
                position: relative;
                padding-left: 30px;
            }

            .timeline-mini-item {
                position: relative;
                margin-bottom: 15px;
            }

            .timeline-mini-icon {
                position: absolute;
                left: -30px;
                top: 0;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .timeline-mini::before {
                content: '';
                position: absolute;
                top: 0;
                left: -20px;
                width: 1px;
                height: 100%;
                background: var(--bs-gray-300);
            }

            /* Certificate Card Styles */
            .certificate-progress-card {
                transition: all 0.3s ease;
            }

            .certificate-card-front,
            .certificate-card-back {
                transition: all 0.3s ease;
            }

            .flip-icon {
                transition: transform 0.3s ease;
            }

            .flip-icon.flipped {
                transform: rotate(180deg);
            }

            .course-progress-timeline {
                max-height: 300px;
                overflow-y: auto;
                padding-right: 5px;
            }

            .course-progress-timeline::-webkit-scrollbar {
                width: 6px;
            }

            .course-progress-timeline::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .course-progress-timeline::-webkit-scrollbar-thumb {
                background: #d1d1d1;
                border-radius: 10px;
            }

            .course-progress-timeline::-webkit-scrollbar-thumb:hover {
                background: #aaa;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Initialize Select2 for dropdowns if available
                if (typeof $.fn.select2 !== 'undefined') {
                    $('.form-select').select2({
                        theme: 'bootstrap-5',
                        width: '100%'
                    });
                }

                // Store the active tab in localStorage
                const tabTriggers = document.querySelectorAll('button[data-bs-toggle="tab"]');

                tabTriggers.forEach(tabTrigger => {
                    tabTrigger.addEventListener('shown.bs.tab', function(event) {
                        localStorage.setItem('activeMentorInternTab', event.target.id);
                    });
                });

                // Restore active tab on page load
                const activeTabId = localStorage.getItem('activeMentorInternTab');

                if (activeTabId) {
                    const activeTab = document.getElementById(activeTabId);
                    if (activeTab) {
                        const tab = new bootstrap.Tab(activeTab);
                        tab.show();
                    }
                }

                // Toggle certificate details
                const toggleCertificateButtons = document.querySelectorAll('.toggle-certificate-details');
                toggleCertificateButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const certificateId = this.dataset.certificateId;
                        const timelineElement = document.getElementById('certificateTimeline' +
                            certificateId);

                        // Toggle the timeline
                        if (timelineElement) {
                            if (timelineElement.classList.contains('show')) {
                                timelineElement.classList.remove('show');
                                this.querySelector('.icon-default').classList.remove('d-none');
                                this.querySelector('.icon-expanded').classList.add('d-none');
                            } else {
                                timelineElement.classList.add('show');
                                this.querySelector('.icon-default').classList.add('d-none');
                                this.querySelector('.icon-expanded').classList.remove('d-none');
                            }
                        }
                    });
                });

                // Handle card flip for course progress
                const toggleCourseButtons = document.querySelectorAll('.toggle-certificate-courses');
                toggleCourseButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const certificateId = this.dataset.certificateId;
                        const cardElement = this.closest('.certificate-progress-card');

                        if (cardElement) {
                            const frontSide = cardElement.querySelector('.certificate-card-front');
                            const backSide = cardElement.querySelector('.certificate-card-back');

                            // Toggle the card sides
                            if (frontSide.classList.contains('d-none')) {
                                frontSide.classList.remove('d-none');
                                backSide.classList.add('d-none');
                            } else {
                                frontSide.classList.add('d-none');
                                backSide.classList.remove('d-none');
                            }

                            // Animation for flip icon
                            this.querySelector('.flip-icon').classList.toggle('flipped');
                        }
                    });
                });

                // Dynamic loading of courses based on certificate selection
                const certificateSelect = document.getElementById('certificate_id');
                const courseSelect = document.getElementById('course_id');

                if (certificateSelect && courseSelect) {
                    // Store course data by certificate ID
                    const coursesByCategory = {
                        @foreach ($intern->certificates as $cert)
                            {{ $cert->certificate_id }}: [
                                @foreach ($cert->certificate->courses ?? [] as $course)
                                    {
                                        id: {{ $course->id }},
                                        title: "{{ $course->title }}"
                                    },
                                @endforeach
                            ],
                        @endforeach
                    };

                    certificateSelect.addEventListener('change', function() {
                        // Clear course select
                        courseSelect.innerHTML = '';

                        // Get selected certificate
                        const selectedCertId = this.value;

                        if (selectedCertId) {
                            // Enable course select
                            courseSelect.disabled = false;

                            // Add option placeholder
                            const placeholderOption = document.createElement('option');
                            placeholderOption.value = '';
                            placeholderOption.text = 'Select Course';
                            courseSelect.appendChild(placeholderOption);

                            // Add courses for selected certificate
                            if (coursesByCategory[selectedCertId]) {
                                coursesByCategory[selectedCertId].forEach(course => {
                                    const option = document.createElement('option');
                                    option.value = course.id;
                                    option.text = course.title;
                                    courseSelect.appendChild(option);
                                });
                            }
                        } else {
                            // Disable course select if no certificate selected
                            courseSelect.disabled = true;
                            const option = document.createElement('option');
                            option.value = '';
                            option.text = 'Select Certificate First';
                            courseSelect.appendChild(option);
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
