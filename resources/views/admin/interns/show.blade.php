@extends('dashboard-layout.app')

@section('content')
<div class="container">
    <div class="page-title-container mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-7">
                <h1 class="mb-0 pb-0 display-4 text-primary fw-bold" id="title">Intern Profile</h1>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                    <ul class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.interns.index') }}" class="text-decoration-none">Interns</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $intern->first_name }} {{ $intern->last_name }}</li>
                    </ul>
                </nav>
            </div>
            <div class="col-12 col-md-5 d-flex align-items-center justify-content-md-end mt-3 mt-md-0 gap-2">
              
                <button type="button" class="btn btn-outline-danger btn-icon" data-bs-toggle="modal" data-bs-target="#deleteInternModal">
                    <i data-acorn-icon="bin" class="me-2"></i>Delete
                </button>
            </div>
        </div>
    </div>
    @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
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
                        <div class="rounded bg-opacity-10 mx-auto rounded-circle d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                            <span class="text-primary fs-1 fw-bold">{{ strtoupper(substr($intern->first_name, 0, 1)) }}{{ strtoupper(substr($intern->last_name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <h4 class="mb-1">{{ $intern->first_name }} {{ $intern->last_name }}</h4>
                    <p class="text-muted">
                        {{ $intern->email }}
                    </p>
                    
                    <div class="badge bg-{{ $intern->status == 'active' ? 'success' : ($intern->status == 'completed' ? 'primary' : 'warning') }} mb-3">
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
                                    @if($intern->onboardingSteps->count() > 0)
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
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="assignments-tab" data-bs-toggle="tab" data-bs-target="#assignments" type="button" role="tab" aria-controls="assignments" aria-selected="false">Certificates</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="progress-tab" data-bs-toggle="tab" data-bs-target="#progress" type="button" role="tab" aria-controls="progress" aria-selected="false">Progress</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="onboarding-tab" data-bs-toggle="tab" data-bs-target="#onboarding" type="button" role="tab" aria-controls="onboarding" aria-selected="false">Onboarding</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Details Tab -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
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
                                            <span class="badge bg-{{ $intern->status == 'active' ? 'success' : ($intern->status == 'completed' ? 'primary' : 'warning') }}">
                                                {{ ucfirst($intern->status ?? 'Active') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-muted small">Assigned Mentor</div>
                                        <div>
                                            @if($intern->mentor)
                                                <a  class="text-decoration-none">
                                                    {{ $intern->mentor->first_name }} {{ $intern->mentor->last_name }}
                                                </a>
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
                        <div class="tab-pane fade" id="assignments" role="tabpanel" aria-labelledby="assignments-tab">
                            @if($intern->certificates->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>Certificate</th>
                                                <th>Started</th>
                                                <th>Completed</th>
                                                <th>Exam Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($intern->certificates as $certificate)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($certificate->certificate && $certificate->certificate->provider)
                                                                <div class="me-3">
                                                                    @if($certificate->certificate->provider->logo)
                                                                        <img src="{{ asset('storage/' . $certificate->certificate->provider->logo) }}" alt="Provider" class="rounded" width="40">
                                                                    @else
                                                                        <div class="bg-light text-muted rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                            <i data-acorn-icon="certificate"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <div class="fw-medium">{{ $certificate->certificate->name ?? 'Unknown Certificate' }}</div>
                                                                <div class="text-muted small">{{ $certificate->certificate->provider->name ?? 'Unknown Provider' }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($certificate->started_at)
                                                            {{ \Carbon\Carbon::parse($certificate->started_at)->format('M d, Y') }}
                                                        @else
                                                            <span class="text-muted">Not started</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($certificate->completed_at)
                                                            {{ \Carbon\Carbon::parse($certificate->completed_at)->format('M d, Y') }}
                                                        @else
                                                            <span class="text-muted">In progress</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusBadge = 'secondary';
                                                            switch($certificate->exam_status) {
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
                                                            {{ ucfirst(str_replace('_', ' ', $certificate->exam_status ?? 'not_started')) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#certificateModal{{ $certificate->id }}">
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
                                        <i data-acorn-icon="certificate" style="font-size: 3rem;" class="text-muted"></i>
                                    </div>
                                    <h6 class="text-muted">No certificates assigned yet</h6>
                                  
                                </div>
                            @endif
                        </div>
                        
                        <!-- Progress Tab -->
                        <div class="tab-pane fade" id="progress" role="tabpanel" aria-labelledby="progress-tab">
                            <!-- Check if there are any progress updates -->
                            @php
                                $hasProgress = false;
                                foreach($intern->certificates as $certificate) {
                                    if(isset($certificate->progress) && $certificate->progress->count() > 0) {
                                        $hasProgress = true;
                                        break;
                                    }
                                }
                            @endphp
                            
                            @if($hasProgress)
                                <div class="timeline-container">
                                    @foreach($intern->certificates as $certificate)
                                        @if(isset($certificate->progress) && $certificate->progress->count() > 0)
                                            <div class="mb-4">
                                                <h6 class="fw-bold mb-3">{{ $certificate->certificate->name ?? 'Certificate' }}</h6>
                                                <div class="timeline">
                                                    @foreach($certificate->progress->sortByDesc('created_at') as $update)
                                                        <div class="timeline-item">
                                                            <div class="timeline-icon {{ $update->is_completed ? 'bg-success' : 'bg-warning' }}">
                                                                <i data-acorn-icon="{{ $update->is_completed ? 'check' : 'clock' }}" class="text-white"></i>
                                                            </div>
                                                            <div class="timeline-content">
                                                                <div class="time text-muted small">{{ \Carbon\Carbon::parse($update->created_at)->format('M d, Y h:i A') }}</div>
                                                                <div class="mb-2">
                                                                    <span class="badge bg-{{ $update->is_completed ? 'success' : 'warning' }}">
                                                                        {{ $update->is_completed ? 'Completed' : 'In Progress' }}
                                                                    </span>
                                                                    <span class="ms-2 small text-muted">{{ $update->course_id ? 'Course ID: ' . $update->course_id : '' }}</span>
                                                                </div>
                                                                <p class="mb-2">{{ $update->comment }}</p>
                                                                @if($update->proof_url)
                                                                    <div>
                                                                        <a href="{{ $update->proof_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                            <i data-acorn-icon="link" class="me-1"></i> View Proof
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                                @if($update->updated_by_mentor)
                                                                    <div class="mt-2">
                                                                        <span class="badge bg-info">Updated by Mentor</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i data-acorn-icon="chart" style="font-size: 3rem;" class="text-muted"></i>
                                    </div>
                                    <h6 class="text-muted">No progress updates recorded yet</h6>
                                   
                                </div>
                            @endif
                        </div>
                        
                        <!-- Onboarding Tab -->
                        <div class="tab-pane fade" id="onboarding" role="tabpanel" aria-labelledby="onboarding-tab">
                            @if($intern->onboardingSteps->count() > 0)
                                <div class="mb-3">
                                    @php
                                        $completedSteps = $intern->onboardingSteps->where('completed', true)->count();
                                        $totalSteps = $intern->onboardingSteps->count();
                                        $percentComplete = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
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
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentComplete }}%;" aria-valuenow="{{ $percentComplete }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th width="50">#</th>
                                                <th>Step Name</th>
                                                <th>Status</th>
                                                <th>Completed At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($intern->onboardingSteps->sortBy('step.order') as $onboardingStep)
                                                <tr>
                                                    <td>{{ $onboardingStep->step->order ?? $loop->iteration }}</td>
                                                    <td>
                                                        <div class="fw-medium">{{ $onboardingStep->step->name ?? 'Unknown Step' }}</div>
                                                        <div class="text-muted small">{{ $onboardingStep->step->description ?? '' }}</div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $onboardingStep->completed ? 'success' : 'warning' }}">
                                                            {{ $onboardingStep->completed ? 'Completed' : 'Pending' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($onboardingStep->completed_at)
                                                            {{ \Carbon\Carbon::parse($onboardingStep->completed_at)->format('M d, Y') }}
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!$onboardingStep->completed)
                                                            <button type="button" class="btn btn-sm btn-outline-success mark-complete-btn" data-step-id="{{ $onboardingStep->id }}">
                                                                <i data-acorn-icon="check" class="me-1"></i> Mark Complete
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-outline-warning mark-incomplete-btn" data-step-id="{{ $onboardingStep->id }}">
                                                                <i data-acorn-icon="refresh" class="me-1"></i> Mark Incomplete
                                                            </button>
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
                                        <i data-acorn-icon="list-check" style="font-size: 3rem;" class="text-muted"></i>
                                    </div>
                                    <h6 class="text-muted">No onboarding steps assigned yet</h6>
                                
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Sections - Actions, Notes, etc. -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">Admin Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#sendEmailModal">
                                <i data-acorn-icon="email" class="me-2"></i> Send Email
                            </button>
                        </div>
                    
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#changeMentorModal">
                                <i data-acorn-icon="user" class="me-2"></i> Change Mentor
                            </button>
                        </div>
                  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteInternModal" tabindex="-1" aria-labelledby="deleteInternModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteInternModalLabel">
                    <i data-acorn-icon="warning-hexagon" class="me-2"></i>Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $intern->first_name }} {{ $intern->last_name }}</strong>?</p>
                <p class="text-danger"><small><i data-acorn-icon="warning-hexagon" class="me-1"></i> This action cannot be undone. All associated data will be permanently removed.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.interns.destroy', $intern->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Permanently</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Additional Modals -->
<!-- Certificate Details Modal -->
@foreach($intern->certificates as $certificate)
    <div class="modal fade" id="certificateModal{{ $certificate->id }}" tabindex="-1" aria-labelledby="certificateModalLabel{{ $certificate->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="certificateModalLabel{{ $certificate->id }}">Certificate Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($certificate->certificate && $certificate->certificate->provider)
                            <div class="me-3">
                                @if($certificate->certificate->provider->logo)
                                    <img src="{{ asset('storage/' . $certificate->certificate->provider->logo) }}" alt="Provider" class="rounded" width="60">
                                @else
                                    <div class="bg-light text-muted rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i data-acorn-icon="certificate"></i>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div>
                            <h5 class="mb-1">{{ $certificate->certificate->name ?? 'Unknown Certificate' }}</h5>
                            <div class="text-muted">{{ $certificate->certificate->provider->name ?? 'Unknown Provider' }}</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="fw-medium mb-2">Certificate Information</div>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th width="40%" class="bg-light">Started Date</th>
                                        <td>
                                            @if($certificate->started_at)
                                                {{ \Carbon\Carbon::parse($certificate->started_at)->format('F d, Y') }}
                                            @else
                                                <span class="text-muted">Not started</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Completed Date</th>
                                        <td>
                                            @if($certificate->completed_at)
                                                {{ \Carbon\Carbon::parse($certificate->completed_at)->format('F d, Y') }}
                                            @else
                                                <span class="text-muted">In progress</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Exam Status</th>
                                        <td>
                                            @php
                                                $statusBadge = 'secondary';
                                                switch($certificate->exam_status) {
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
                                                {{ ucfirst(str_replace('_', ' ', $certificate->exam_status ?? 'not_started')) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Voucher ID</th>
                                        <td>
                                            @if($certificate->voucher_id)
                                                <code>{{ $certificate->voucher_id }}</code>
                                            @else
                                                <span class="text-muted">Not assigned</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Duration</th>
                                        <td>
                                            @if($certificate->started_at)
                                                @if($certificate->completed_at)
                                                    {{ \Carbon\Carbon::parse($certificate->started_at)->diffForHumans(\Carbon\Carbon::parse($certificate->completed_at), true) }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($certificate->started_at)->diffForHumans(null, true) }} (ongoing)
                                                @endif
                                            @else
                                                <span class="text-muted">Not started</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if(isset($certificate->progress) && $certificate->progress->count() > 0)
                        <div class="mt-4">
                            <div class="fw-medium mb-2">Progress Updates ({{ $certificate->progress->count() }})</div>
                            <div class="timeline-mini">
                                @foreach($certificate->progress->sortByDesc('created_at')->take(3) as $update)
                                    <div class="timeline-mini-item">
                                        <div class="timeline-mini-icon {{ $update->is_completed ? 'bg-success' : 'bg-warning' }}">
                                            <i data-acorn-icon="{{ $update->is_completed ? 'check' : 'clock' }}" class="text-white"></i>
                                        </div>
                                        <div class="timeline-mini-content">
                                            <div class="time text-muted small">{{ \Carbon\Carbon::parse($update->created_at)->format('M d, Y') }}</div>
                                            <p class="mb-0">{{ \Illuminate\Support\Str::limit($update->comment, 120) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                
                                @if($certificate->progress->count() > 3)
                                    <div class="text-center mt-2">
                                        <button class="btn btn-sm btn-link" type="button" data-bs-toggle="tab" data-bs-target="#progress">
                                            View all {{ $certificate->progress->count() }} updates
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 
                </div>
            </div>
        </div>
    </div>
@endforeach



<!-- Change Mentor Modal -->
<div class="modal fade" id="changeMentorModal" tabindex="-1" aria-labelledby="changeMentorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeMentorModalLabel">Change Assigned Mentor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.interns.update', $intern->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="update_type" value="mentor_only">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="assigned_mentor_id" class="form-label">Select Mentor</label>
                        <select class="form-select" id="assigned_mentor_id" name="assigned_mentor_id">
                            <option value="">None (Remove Current Mentor)</option>
                            @foreach($mentors as $mentor)
                                <option value="{{ $mentor->id }}"
                                    {{ $intern->assigned_mentor_id == $mentor->id ? 'selected' : '' }}>
                                    {{ $mentor->first_name }} {{ $mentor->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notify_mentor" name="notify_mentor" value="1" checked>
                        <label class="form-check-label" for="notify_mentor">
                            Notify mentor about this assignment
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notify_intern" name="notify_intern" value="1" checked>
                        <label class="form-check-label" for="notify_intern">
                            Notify intern about mentor change
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Mentor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Send Email Modal -->
<div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendEmailModalLabel">Send Email to Intern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.interns.send-email', $intern->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email_to" class="form-label">To</label>
                        <input type="email" class="form-control" id="email_to" value="{{ $intern->email }}" readonly>
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
                        <input class="form-check-input" type="checkbox" id="email_copy_me" name="copy_me" value="1" checked>
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
        background-color: var(--bs-white);
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
        
        // Handle onboarding step status changes
        const markCompleteButtons = document.querySelectorAll('.mark-complete-btn');
        const markIncompleteButtons = document.querySelectorAll('.mark-incomplete-btn');
        
        markCompleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                updateStepStatus(this.dataset.stepId, true);
            });
        });
        
        markIncompleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                updateStepStatus(this.dataset.stepId, false);
            });
        });
        
        function updateStepStatus(stepId, completed) {
            fetch(`/admin/onboarding-steps/${stepId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ completed: completed })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to show updated status
                    window.location.reload();
                } else {
                    alert('Error updating step status: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
        
        // Store the active tab in localStorage
        const tabTriggers = document.querySelectorAll('button[data-bs-toggle="tab"]');
        
        tabTriggers.forEach(tabTrigger => {
            tabTrigger.addEventListener('shown.bs.tab', function(event) {
                localStorage.setItem('activeInternProfileTab', event.target.id);
            });
        });
        
        // Restore active tab on page load
        const activeTabId = localStorage.getItem('activeInternProfileTab');
        
        if (activeTabId) {
            const activeTab = document.getElementById(activeTabId);
            if (activeTab) {
                const tab = new bootstrap.Tab(activeTab);
                tab.show();
            }
        }
    });
</script>
@endpush
@endsection