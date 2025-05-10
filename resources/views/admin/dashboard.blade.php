@extends('dashboard-layout.app')

@section('content')
<div class="container">
    <!-- Title and Top Buttons Start -->
    <div class="page-title-container">
        <div class="row">
            <!-- Title Start -->
            <div class="col-12 col-md-7">
                <h1 class="mb-0 pb-0 display-4" id="title">Admin Dashboard</h1>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                    <ul class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    </ul>
                </nav>
            </div>
            <!-- Title End -->
            <div class="col-12 col-md-5 d-flex align-items-center justify-content-md-end">
                <div class="btn-group ms-1 check-all-container">
                    <div class="dropdown-menu dropdown-menu-end custom-sort">
                        <a class="dropdown-item" href="{{ route('admin.interns.index') }}">
                            <i data-acorn-icon="user" class="me-2"></i>
                            <span class="align-middle">View Interns</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.certificate-programs.index') }}">
                            <i data-acorn-icon="certificate" class="me-2"></i>
                            <span class="align-middle">View Certificates</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Title and Top Buttons End -->

    <!-- Content Start -->
    <div class="row">
        <!-- Key Stats Start -->
        <div class="col-12 mb-5">
           

            <div class="row g-2">
                <!-- Total Interns Card -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card sh-13 sh-lg-15 sh-xl-14">
                        <div class="h-100 row g-0 card-body align-items-center py-3">
                            <div class="col-auto pe-3">
                                <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center">
                                    <i data-acorn-icon="user" class="text-white"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row gx-2 d-flex align-content-center">
                                    <div class="col-12 col-xl d-flex">
                                        <div class="d-flex align-items-center lh-1-25">Total Interns</div>
                                    </div>
                                    <div class="col-12 col-xl-auto">
                                        <div class="cta-2 text-primary">{{ $totalInterns }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Interns Card -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card sh-13 sh-lg-15 sh-xl-14">
                        <div class="h-100 row g-0 card-body align-items-center py-3">
                            <div class="col-auto pe-3">
                                <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center">
                                    <i data-acorn-icon="check" class="text-white"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row gx-2 d-flex align-content-center">
                                    <div class="col-12 col-xl d-flex">
                                        <div class="d-flex align-items-center lh-1-25">Active Interns</div>
                                    </div>
                                    <div class="col-12 col-xl-auto">
                                        <div class="cta-2 text-success">{{ $activeInterns }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Certificates Card -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card sh-13 sh-lg-15 sh-xl-14">
                        <div class="h-100 row g-0 card-body align-items-center py-3">
                            <div class="col-auto pe-3">
                                <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center">
                                    <i data-acorn-icon="book" class="text-white"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row gx-2 d-flex align-content-center">
                                    <div class="col-12 col-xl d-flex">
                                        <div class="d-flex align-items-center lh-1-25">Total Certificates</div>
                                    </div>
                                    <div class="col-12 col-xl-auto">
                                        <div class="cta-2 text-primary">{{ $totalCertificates }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Exams Card -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card sh-13 sh-lg-15 sh-xl-14">
                        <div class="h-100 row g-0 card-body align-items-center py-3">
                            <div class="col-auto pe-3">
                                <div class="bg-gradient-light sh-5 sw-5 rounded-xl d-flex justify-content-center align-items-center">
                                    <i data-acorn-icon="graduation" class="text-white"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row gx-2 d-flex align-content-center">
                                    <div class="col-12 col-xl d-flex">
                                        <div class="d-flex align-items-center lh-1-25">Passed Exams</div>
                                    </div>
                                    <div class="col-12 col-xl-auto">
                                        <div class="cta-2 text-info">{{ $passedExams }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Key Stats End -->

        <!-- Statistics Charts Start -->
        <div class="col-12 col-xl-6 mb-5">
            <div class="card h-100">
                <div class="card-header">
                    <h2 class="small-title">Monthly Activity</h2>
                </div>
                <div class="card-body">
                    <div class="h-100">
                        <canvas id="internActivityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6 mb-5">
            <div class="card h-100">
                <div class="card-header">
                    <h2 class="small-title">Certification Status</h2>
                </div>
                <div class="card-body">
                    <div class="h-100">
                        <canvas id="certificationStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Statistics Charts End -->

        <!-- Top Certificates and Interns Start -->
        <div class="col-12 col-xl-6 mb-5">
            <h2 class="small-title">Top Certificates</h2>
            <div class="scroll-out">
                <div class="scroll-by-count" data-count="4">
                    @foreach($topCertificates as $certificate)
                        <div class="card mb-2">
                            <div class="row g-0 sh-14">
                                <div class="col-auto">
                                    <div class="d-flex h-100 align-items-center justify-content-center me-2 ms-3">
                                        @if($certificate->certificate && $certificate->certificate->provider)
                                            @if($certificate->certificate->provider->logo)
                                                <img src="{{ asset('storage/' . $certificate->certificate->provider->logo) }}" alt="Provider" class="rounded" width="40">
                                            @else
                                                <div class="bg-primary text-white d-flex rounded-xl align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i data-acorn-icon="certificate"></i>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card-body pt-0 pb-0 h-100 d-flex align-items-center">
                                        <div class="w-100">
                                            <div class="d-flex flex-row justify-content-between mb-2">
                                                <div class="font-heading mb-1">{{ $certificate->certificate->title ?? 'Unknown Certificate' }}</div>
                                                <div class="text-muted">{{ $certificate->assignments }} Assignments</div>
                                            </div>
                                            <div class="mb-2">
                                                <div class="text-small text-muted">{{ $certificate->certificate->provider->name ?? 'Unknown Provider' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6 mb-5">
            <h2 class="small-title">Recent Activity</h2>
            <div class="card h-100-card">
                <div class="card-body mb-n2 scroll-out h-100">
                    <div class="scroll h-100">
                        @if($recentProgressUpdates->count() > 0)
                            <div class="mb-4">
                                <div class="border-bottom border-separator-light mb-2 pb-2">
                                    <h6 class="text-primary">Recent Course Progress</h6>
                                </div>
                                @foreach($recentProgressUpdates as $update)
                                    <div class="row g-0 mb-2">
                                        <div class="col-auto">
                                            <div class="sw-3 d-inline-block d-flex justify-content-start align-items-center h-100">
                                                <div class="sh-3">
                                                    <i data-acorn-icon="{{ $update->is_completed ? 'check-circle' : 'clock' }}" class="text-{{ $update->is_completed ? 'success' : 'warning' }}"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card-body d-flex flex-column pt-0 pb-0 ps-3 pe-0 h-100 justify-content-center">
                                                <div class="d-flex flex-column">
                                                    <div class="text-alternate mt-0 mb-1">
                                                        <strong>{{ $update->intern->first_name }} {{ $update->intern->last_name }}</strong> 
                                                        {{ $update->is_completed ? 'completed' : 'made progress on' }} 
                                                        <strong>{{ $update->course->title ?? 'a course' }}</strong>
                                                    </div>
                                                    <div class="text-small text-muted">{{ $update->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($recentCertificateProgress->count() > 0)
                            <div>
                                <div class="border-bottom border-separator-light mb-2 pb-2">
                                    <h6 class="text-primary">Recent Certificate Progress</h6>
                                </div>
                                @foreach($recentCertificateProgress as $progress)
                                    @php
                                        $statusIcon = 'check';
                                        $statusClass = 'success';
                                        
                                        if($progress->study_status == 'in_progress') {
                                            $statusIcon = 'clock';
                                            $statusClass = 'warning';
                                        } elseif($progress->study_status == 'studying_for_exam') {
                                            $statusIcon = 'book';
                                            $statusClass = 'info';
                                        } elseif($progress->study_status == 'requested_voucher') {
                                            $statusIcon = 'ticket';
                                            $statusClass = 'primary';
                                        } elseif($progress->study_status == 'took_exam') {
                                            $statusIcon = 'file-text';
                                            $statusClass = 'info';
                                        } elseif($progress->study_status == 'failed') {
                                            $statusIcon = 'close';
                                            $statusClass = 'danger';
                                        }
                                    @endphp
                                    <div class="row g-0 mb-2">
                                        <div class="col-auto">
                                            <div class="sw-3 d-inline-block d-flex justify-content-start align-items-center h-100">
                                                <div class="sh-3">
                                                    <i data-acorn-icon="{{ $statusIcon }}" class="text-{{ $statusClass }}"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card-body d-flex flex-column pt-0 pb-0 ps-3 pe-0 h-100 justify-content-center">
                                                <div class="d-flex flex-column">
                                                    <div class="text-alternate mt-0 mb-1">
                                                        <strong>{{ $progress->internCertificate->user->first_name ?? 'Unknown' }} {{ $progress->internCertificate->user->last_name ?? 'Intern' }}</strong> 
                                                        <span class="badge bg-{{ $statusClass }} ms-1 me-1">{{ ucfirst(str_replace('_', ' ', $progress->study_status)) }}</span>
                                                        <strong>{{ $progress->internCertificate->certificate->title ?? 'Unknown Certificate' }}</strong>
                                                    </div>
                                                    @if($progress->notes)
                                                        <div class="text-muted text-truncate">{{ $progress->notes }}</div>
                                                    @endif
                                                    <div class="text-small text-muted">{{ $progress->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($recentProgressUpdates->count() == 0 && $recentCertificateProgress->count() == 0)
                            <div class="text-center py-5">
                                <i data-acorn-icon="activity" class="text-muted mb-2" style="font-size: 3rem;"></i>
                                <p class="text-muted">No recent activity to display</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Top Certificates and Interns End -->

<!-- Progress and Status Indicators Start -->
<div class="col-12 mb-5">
    <h2 class="small-title">Intern Status</h2>
    <div class="card mb-2">
        <div class="card-body">
            <div class="row g-0 align-items-center mb-3">
                <div class="col-auto">
                    <div class="bg-gradient-light sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                        <i data-acorn-icon="user" class="text-white"></i>
                    </div>
                </div>
                <div class="col ps-3">
                    <div class="row g-0">
                        <div class="col">
                            <div class="sh-4 d-flex align-items-center lh-1-25">Active</div>
                        </div>
                        <div class="col-auto">
                            <div class="sh-4 d-flex align-items-center fw-bold text-success">{{ $activeInterns }}</div>
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalInterns > 0 ? ($activeInterns / $totalInterns * 100) : 0 }}%" aria-valuenow="{{ $activeInterns }}" aria-valuemin="0" aria-valuemax="{{ $totalInterns }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-0 align-items-center mb-3">
                <div class="col-auto">
                    <div class="bg-gradient-light sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                        <i data-acorn-icon="check" class="text-white"></i>
                    </div>
                </div>
                <div class="col ps-3">
                    <div class="row g-0">
                        <div class="col">
                            <div class="sh-4 d-flex align-items-center lh-1-25">Completed</div>
                        </div>
                        <div class="col-auto">
                            <div class="sh-4 d-flex align-items-center fw-bold text-primary">{{ $completedInterns }}</div>
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $totalInterns > 0 ? ($completedInterns / $totalInterns * 100) : 0 }}%" aria-valuenow="{{ $completedInterns }}" aria-valuemin="0" aria-valuemax="{{ $totalInterns }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-0 align-items-center mb-3">
                <div class="col-auto">
                    <div class="bg-gradient-light sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                        <i data-acorn-icon="error-hexagon" class="text-white"></i>
                    </div>
                </div>
                <div class="col ps-3">
                    <div class="row g-0">
                        <div class="col">
                            <div class="sh-4 d-flex align-items-center lh-1-25">Inactive</div>
                        </div>
                        <div class="col-auto">
                            <div class="sh-4 d-flex align-items-center fw-bold text-warning">{{ $inactiveInterns }}</div>
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $totalInterns > 0 ? ($inactiveInterns / $totalInterns * 100) : 0 }}%" aria-valuenow="{{ $inactiveInterns }}" aria-valuemin="0" aria-valuemax="{{ $totalInterns }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-0 align-items-center">
                <div class="col-auto">
                    <div class="bg-gradient-light sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                        <i data-acorn-icon="minus" class="text-white"></i>
                    </div>
                </div>
                <div class="col ps-3">
                    <div class="row g-0">
                        <div class="col">
                            <div class="sh-4 d-flex align-items-center lh-1-25">Unassigned</div>
                        </div>
                        <div class="col-auto">
                            <div class="sh-4 d-flex align-items-center fw-bold text-danger">{{ $unassignedInterns }}</div>
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col">
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $totalInterns > 0 ? ($unassignedInterns / $totalInterns * 100) : 0 }}%" aria-valuenow="{{ $unassignedInterns }}" aria-valuemin="0" aria-valuemax="{{ $totalInterns }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Progress and Status Indicators End -->

<!-- Certificate Progress Section - FULL WIDTH -->
<div class="col-12 mb-5">
    <h2 class="small-title">Certificate Progress</h2>
    <div class="card mb-2">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="row g-0 align-items-center">
                        <div class="col-auto">
                            <div class="bg-gradient-light sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                                <i data-acorn-icon="book-open" class="text-white"></i>
                            </div>
                        </div>
                        <div class="col ps-3">
                            <div class="row g-0">
                                <div class="col">
                                    <div class="sh-4 d-flex align-items-center lh-1-25">In Progress</div>
                                </div>
                                <div class="col-auto">
                                    <div class="sh-4 d-flex align-items-center fw-bold text-warning">{{ $certProgressByStatus['in_progress'] ?? 0 }}</div>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $totalCertificateAssignments > 0 ? (($certProgressByStatus['in_progress'] ?? 0) / $totalCertificateAssignments * 100) : 0 }}%" aria-valuenow="{{ $certProgressByStatus['in_progress'] ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $totalCertificateAssignments }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="row g-0 align-items-center">
                        <div class="col-auto">
                            <div class="bg-gradient-light sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                                <i data-acorn-icon="book" class="text-white"></i>
                            </div>
                        </div>
                        <div class="col ps-3">
                            <div class="row g-0">
                                <div class="col">
                                    <div class="sh-4 d-flex align-items-center lh-1-25">Studying for Exam</div>
                                </div>
                                <div class="col-auto">
                                    <div class="sh-4 d-flex align-items-center fw-bold text-info">{{ $certProgressByStatus['studying_for_exam'] ?? 0 }}</div>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $totalCertificateAssignments > 0 ? (($certProgressByStatus['studying_for_exam'] ?? 0) / $totalCertificateAssignments * 100) : 0 }}%" aria-valuenow="{{ $certProgressByStatus['studying_for_exam'] ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $totalCertificateAssignments }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="row g-0 align-items-center">
                        <div class="col-auto">
                            <div class="bg-gradient-light sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                                <i data-acorn-icon="tag" class="text-white"></i>
                            </div>
                        </div>
                        <div class="col ps-3">
                            <div class="row g-0">
                                <div class="col">
                                    <div class="sh-4 d-flex align-items-center lh-1-25">Voucher Requested</div>
                                </div>
                                <div class="col-auto">
                                    <div class="sh-4 d-flex align-items-center fw-bold text-primary">{{ $certProgressByStatus['requested_voucher'] ?? 0 }}</div>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $totalCertificateAssignments > 0 ? (($certProgressByStatus['requested_voucher'] ?? 0) / $totalCertificateAssignments * 100) : 0 }}%" aria-valuenow="{{ $certProgressByStatus['requested_voucher'] ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $totalCertificateAssignments }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="row g-0 align-items-center">
                        <div class="col-auto">
                            <div class="bg-gradient-light sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                                <i data-acorn-icon="graduation" class="text-white"></i>
                            </div>
                        </div>
                        <div class="col ps-3">
                            <div class="row g-0">
                                <div class="col">
                                    <div class="sh-4 d-flex align-items-center lh-1-25">Passed/Completed</div>
                                </div>
                                <div class="col-auto">
                                    <div class="sh-4 d-flex align-items-center fw-bold text-success">{{ $certProgressByStatus['passed'] ?? 0 }}</div>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalCertificateAssignments > 0 ? (($certProgressByStatus['passed'] ?? 0) / $totalCertificateAssignments * 100) : 0 }}%" aria-valuenow="{{ $certProgressByStatus['passed'] ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $totalCertificateAssignments }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Resources Status Start - Placed side by side on large screens -->
<div class="row">
    <div class="col-lg-6 mb-5">
        <h2 class="small-title">Certification Providers</h2>
        <div class="card h-100">
            <div class="card-body">
                @if($providerStats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-muted text-small text-uppercase">Provider</th>
                                    <th scope="col" class="text-muted text-small text-uppercase">Certificates</th>
                                    <th scope="col" class="text-muted text-small text-uppercase text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($providerStats as $provider)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($provider->logo)
                                                    <div class="me-2">
                                                        <img src="{{ asset('storage/' . $provider->logo) }}" alt="{{ $provider->name }}" class="rounded-xl" width="32" height="32">
                                                    </div>
                                                @else
                                                    <div class="me-2 bg-primary p-2 text-white rounded-xl d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                        <i data-acorn-icon="building"></i>
                                                    </div>
                                                @endif
                                                <span>{{ $provider->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $provider->certificates_count }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.providers.index') }}" class="btn btn-sm btn-sm-admin btn-icon btn-outline-primary ms-1">
                                                <i data-acorn-icon="eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i data-acorn-icon="building" class="text-muted mb-2" style="font-size: 3rem;"></i>
                        <p class="text-muted">No providers available</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-5">
        <h2 class="small-title">Voucher Status</h2>
        <div class="card h-max-100">
            <div class="card-body">
                <div class="row h-100">
                    <div class="col-12 col-sm-6 d-flex flex-column justify-content-between">
                        <div class="d-flex flex-column align-items-center mb-4">
                            <div class="bg-gradient-light sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center mb-3">
                                <i data-acorn-icon="tag" class="text-white"></i>
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <p class="mb-0 text-muted">Available Vouchers</p>
                                <p class="display-6 text-primary mb-0">{{ $availableVouchers }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('admin.vouchers.index', ['used' => '0']) }}" class="btn btn-sm btn-sm-admin btn-icon btn-icon-start btn-outline-primary">
                                <i data-acorn-icon="eye"></i>
                                <span>View Available</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 d-flex flex-column justify-content-between mt-4 mt-sm-0">
                        <div class="d-flex flex-column align-items-center mb-4">
                            <div class="bg-gradient-light sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center mb-3">
                                <i data-acorn-icon="check" class="text-white"></i>
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <p class="mb-0 text-muted">Used Vouchers</p>
                                <p class="display-6 text-primary mb-0">{{ $usedVouchers }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('admin.vouchers.index', ['used' => '1']) }}" class="btn btn-sm btn-sm-admin btn-icon btn-icon-start btn-outline-primary">
                                <i data-acorn-icon="eye"></i>
                                <span>View Used</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Resources Status End -->
        
        @push('scripts')
        <script>
            // Document ready function
            document.addEventListener('DOMContentLoaded', function() {
                // Chart js initialization
                if (typeof Chart !== 'undefined') {
                    // Monthly Activity Chart
                    const internActivityCanvas = document.getElementById('internActivityChart');
                    if (internActivityCanvas) {
                        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        
                        // Prepare data for the chart
                        const signupData = Array(12).fill(0);
                        const completionData = Array(12).fill(0);
                        
                        // Fill in actual data from the backend
                        @foreach($monthlySignups as $monthData)
                            signupData[{{ $monthData->month - 1 }}] = {{ $monthData->total }};
                        @endforeach
                        
                        @foreach($monthlyCertificatesCompleted as $monthData)
                            completionData[{{ $monthData->month - 1 }}] = {{ $monthData->total }};
                        @endforeach
                        
                        const internActivityChart = new Chart(internActivityCanvas, {
                            type: 'bar',
                            data: {
                                labels: monthNames,
                                datasets: [
                                    {
                                        label: 'New Interns',
                                        data: signupData,
                                        backgroundColor: 'rgba(61, 142, 248, 0.2)',
                                        borderColor: 'rgba(61, 142, 248, 1)',
                                        borderWidth: 2,
                                        borderRadius: 10,
                                        yAxisID: 'y',
                                    },
                                    {
                                        label: 'Completed Certificates',
                                        data: completionData,
                                        type: 'line',
                                        backgroundColor: 'transparent',
                                        borderColor: 'rgba(93, 203, 142, 1)',
                                        borderWidth: 2,
                                        pointBackgroundColor: 'rgba(93, 203, 142, 1)',
                                        tension: 0.5,
                                        yAxisID: 'y1',
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'New Interns'
                                        }
                                    },
                                    y1: {
                                        beginAtZero: true,
                                        position: 'right',
                                        grid: {
                                            drawOnChartArea: false,
                                        },
                                        title: {
                                            display: true,
                                            text: 'Completed Certificates'
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    tooltip: {
                                        mode: 'index',
                                        intersect: false,
                                    }
                                },
                            }
                        });
                    }
                    
                    // Certification Status Chart
                    const certStatusCanvas = document.getElementById('certificationStatusChart');
                    if (certStatusCanvas) {
                        const certStatusChart = new Chart(certStatusCanvas, {
                            type: 'doughnut',
                            data: {
                                labels: ['Not Taken', 'Scheduled', 'Passed', 'Failed'],
                                datasets: [
                                    {
                                        data: [
                                            {{ $certificationStatusData['notTaken'] }},
                                            {{ $certificationStatusData['scheduled'] }},
                                            {{ $certificationStatusData['passed'] }},
                                            {{ $certificationStatusData['failed'] }}
                                        ],
                                        backgroundColor: [
                                            'rgba(120, 120, 120, 0.7)',
                                            'rgba(61, 142, 248, 0.7)',
                                            'rgba(93, 203, 142, 0.7)',
                                            'rgba(248, 92, 92, 0.7)'
                                        ],
                                        borderColor: [
                                            'rgba(120, 120, 120, 1)',
                                            'rgba(61, 142, 248, 1)',
                                            'rgba(93, 203, 142, 1)',
                                            'rgba(248, 92, 92, 1)'
                                        ],
                                        borderWidth: 2
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const label = context.label || '';
                                                const value = context.raw || 0;
                                                const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                                const percentage = Math.round((value / total) * 100);
                                                return `${label}: ${value} (${percentage}%)`;
                                            }
                                        }
                                    }
                                },
                                cutout: '70%',
                            }
                        });
                    }
                }
            });
        </script>
        @endpush
        @endsection