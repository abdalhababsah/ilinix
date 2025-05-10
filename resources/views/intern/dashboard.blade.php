@extends('dashboard-layout.app')

@section('content')


<div class="container">
    <!-- Title and Top Info Start -->
    <div class="page-title-container mb-4">
        <div class="row">
            <div class="col-12 col-md-7">
                <h1 class="mb-0 pb-0 display-4" id="title">Welcome, {{ $intern->first_name }}!</h1>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                    <ul class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="{{ route('intern.dashboard') }}">Dashboard</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- Title and Top Buttons End -->

    <!-- Overall Progress Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-3 mb-lg-0">
                            <h2 class="small-title">Your Learning Progress</h2>
                            <div class="mb-2">
                                <div class="text-small text-muted mb-1">OVERALL PROGRESS</div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-small text-alternate">{{ $overallProgress }}% Complete</span>
                                    <span class="text-small text-alternate">{{ $totalCompletedCourses }}/{{ $totalCourses }} Courses</span>
                                </div>
                                <div class="progress mt-2" style="height: 12px;">
                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="{{ $overallProgress }}" 
                                        aria-valuemin="0" aria-valuemax="100" style="width: {{ $overallProgress }}%"></div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <div class="text-small text-muted">CERTIFICATES IN PROGRESS</div>
                                <h4 class="fw-bold">{{ $certificatesWithProgress->count() }}</h4>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            @if($intern->mentor)
                                <div class="card border h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Your Mentor</h5>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                                <span class="text-white fw-bold">{{ strtoupper(substr($intern->mentor->first_name, 0, 1)) }}{{ strtoupper(substr($intern->mentor->last_name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $intern->mentor->first_name }} {{ $intern->mentor->last_name }}</h6>
                                                <div class="text-muted">{{ $intern->mentor->email }}</div>
                                            </div>
                                        </div>
                                        <p class="card-text mb-0">Your mentor is here to guide you through your certification journey. Don't hesitate to reach out if you need help!</p>
                                    </div>
                                </div>
                            @else
                                <div class="card border h-100">
                                    <div class="card-body text-center d-flex align-items-center justify-content-center">
                                        <div>
                                            <i data-acorn-icon="user" class="text-primary mb-3" style="font-size: 2rem;"></i>
                                            <h5 class="card-title">No Mentor Assigned Yet</h5>
                                            <p class="card-text mb-0">A mentor will be assigned to you soon to help guide your learning journey.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Your Certificates Section -->
    <h2 class="small-title">Your Certificates</h2>
    
    @if($certificatesWithProgress->count() > 0)
        <div class="row mb-5">
            <!-- Certificate Cards -->
            @foreach($certificatesWithProgress as $certificate)
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    @if($certificate['provider'] && $certificate['provider']->logo)
                                        <img src="{{ asset('storage/' . $certificate['provider']->logo) }}" alt="Provider" class="me-3" style="height: 40px;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i data-acorn-icon="certificate" class="text-primary"></i>
                                        </div>
                                    @endif
                                    <h5 class="mb-0 lh-sm">{{ $certificate['certificate']->title }}</h5>
                                </div>
                                <span class="badge bg-{{ $certificate['progress_percentage'] == 100 ? 'success' : 'primary' }}">
                                    {{ $certificate['progress_percentage'] }}%
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                        style="width: {{ $certificate['progress_percentage'] }}%;" 
                                        aria-valuenow="{{ $certificate['progress_percentage'] }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">{{ $certificate['completed_courses'] }}/{{ $certificate['total_courses'] }} courses</small>
                                    <small class="text-muted">Started: {{ \Carbon\Carbon::parse($certificate['started_at'])->format('M d, Y') }}</small>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <strong>Level:</strong> 
                                        <span class="badge bg-light text-dark">{{ ucfirst($certificate['certificate']->level ?? 'N/A') }}</span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Exam Status:</strong>
                                        @php
                                            $statusBadge = 'secondary';
                                            switch($certificate['exam_status']) {
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
                                            {{ ucfirst(str_replace('_', ' ', $certificate['exam_status'])) }}
                                        </span>
                                    </div>
                                </div>
                                
                                @if($certificate['latest_certificate_progress'])
                                    <div class="alert alert-light border small mb-0">
                                        <strong>Status Update:</strong> 
                                        <span class="badge bg-{{ $certificate['latest_certificate_progress']->study_status == 'in_progress' ? 'warning' : ($certificate['latest_certificate_progress']->study_status == 'completed' ? 'success' : 'info') }} mb-2">
                                            {{ ucfirst(str_replace('_', ' ', $certificate['latest_certificate_progress']->study_status)) }}
                                        </span>
                                        @if($certificate['latest_certificate_progress']->notes)
                                            <br>{{ $certificate['latest_certificate_progress']->notes }}
                                        @endif
                                    </div>
                                @endif
                            </div>
                            
                            <a href="{{ route('intern.certificates.show', $certificate['intern_certificate']->id) }}" class="btn btn-primary">
                                <i data-acorn-icon="eye" class="me-1"></i> View Certificate
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Courses in Progress -->
        <h2 class="small-title">Current Courses</h2>
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="scroll-out mb-n2">
                            <div class="scroll-by-count" data-count="4">
                                @php
                                    $inProgressCourses = collect();
                                    foreach($certificatesWithProgress as $cert) {
                                        foreach($cert['course_progress'] as $courseProgress) {
                                            if(!$courseProgress['is_completed']) {
                                                $inProgressCourses->push([
                                                    'course' => $courseProgress['course'],
                                                    'progress' => $courseProgress['progress'],
                                                    'certificate' => $cert['certificate']
                                                ]);
                                            }
                                        }
                                    }
                                @endphp
                                
                                @if($inProgressCourses->count() > 0)
                                    @foreach($inProgressCourses as $course)
                                        <div class="card mb-2 sh-14 sh-md-10">
                                            <div class="card-body pt-0 pb-0 h-100">
                                                <div class="row g-0 h-100 align-content-center">
                                                    <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0">
                                                        <a href="#" class="body-link text-truncate">{{ $course['course']->title }}</a>
                                                    </div>
                                                    <div class="col-12 col-md-2 d-flex align-items-center mb-2 mb-md-0">
                                                        <span class="badge bg-primary">{{ $course['certificate']->title }}</span>
                                                    </div>
                                                    <div class="col-12 col-md-3 d-flex align-items-center mb-2 mb-md-0">
                                                        <span class="text-muted">Est: {{ $course['course']->estimated_minutes }} min</span>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-5">
                                        <i data-acorn-icon="book-open" style="font-size: 3rem;" class="text-primary mb-3"></i>
                                        <h6 class="mb-1">No courses in progress</h6>
                                        <p class="text-muted">Looks like you've completed all your assigned courses so far!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <h2 class="small-title">Recent Activity</h2>
        <div class="row">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-body">
                        @if($recentProgressUpdates->count() > 0)
                            <div class="timeline">
                                @foreach($recentProgressUpdates as $update)
                                    <div class="timeline-item">
                                        <div class="timeline-icon {{ $update->is_completed ? 'bg-success' : 'bg-warning' }}">
                                            <i data-acorn-icon="{{ $update->is_completed ? 'check' : 'clock' }}" class="text-white"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="d-flex flex-column flex-md-row justify-content-between mb-2">
                                                <div class="fw-bold">{{ $update->course->title }}</div>
                                                <div class="text-muted small">{{ $update->created_at->format('M d, Y h:i A') }}</div>
                                            </div>
                                            <div class="mb-2">
                                                <span class="badge bg-{{ $update->is_completed ? 'success' : 'warning' }}">
                                                    {{ $update->is_completed ? 'Completed' : 'In Progress' }}
                                                </span>
                                                <span class="badge bg-light text-dark">
                                                    {{ $update->certificate->title }}
                                                </span>
                                            </div>
                                            @if($update->comment)
                                                <p class="mb-0">{{ $update->comment }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i data-acorn-icon="activity" style="font-size: 3rem;" class="text-primary mb-3"></i>
                                <h6 class="mb-1">No recent activity</h6>
                                <p class="text-muted">Your activity will appear here as you make progress on your courses.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- No Certificates Yet -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-body text-center py-5">
                        <i data-acorn-icon="certificate" style="font-size: 4rem;" class="text-primary mb-3"></i>
                        <h5 class="mb-3">No Certificates Started Yet</h5>
                        <p class="mb-4">You haven't started any certification programs yet. Your administrator or mentor will assign certificates to you soon.</p>
                        @if($intern->mentor)
                            <div class="alert alert-info w-md-50 mx-auto">
                                <i data-acorn-icon="user" class="me-1"></i>
                                Your mentor is <strong>{{ $intern->mentor->first_name }} {{ $intern->mentor->last_name }}</strong>. Feel free to reach out if you have any questions!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

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
</style>
@endpush
@endsection