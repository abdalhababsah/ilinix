@extends('dashboard-layout.app')

@section('content')
<div class="container">
    <div class="page-title-container mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-7">
                <h1 class="mb-0 pb-0 display-4 text-primary fw-bold" id="title">My Certificates</h1>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                    <ul class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="{{ route('intern.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Certificates</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i data-acorn-icon="check" class="me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i data-acorn-icon="warning-hexagon" class="me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Progress Overview -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h5 class="mb-3">Your Certificate Progress</h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="text-muted small mb-1">Available</div>
                                                <h4 class="mb-0">{{ count($availablePrograms) }}</h4>
                                            </div>
                                            <div class="rounded-circle bg-opacity-10 p-3">
                                                <i data-acorn-icon="graduation" class="text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="text-muted small mb-1">In Progress</div>
                                                <h4 class="mb-0">{{ count($startedCertificates) }}</h4>
                                            </div>
                                            <div class="rounded-circle bg-opacity-10 p-3">
                                                <i data-acorn-icon="clock" class="text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="text-muted small mb-1">Completed</div>
                                                <h4 class="mb-0">{{ count($completedCertificates) }}</h4>
                                            </div>
                                            <div class="rounded-circle bg-opacity-10 p-3">
                                                <i data-acorn-icon="check" class="text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4 mt-lg-0">
                            <div class="h-100 d-flex flex-column justify-content-center">
                                <div class="text-muted mb-2">Overall Certification Progress</div>
                                <div class="progress mb-2" style="height: 24px;">
                                    @php
                                        $totalCertificates = count($startedCertificates) + count($completedCertificates);
                                        $percentComplete = $totalCertificates > 0 ? round((count($completedCertificates) / $totalCertificates) * 100) : 0;
                                    @endphp
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentComplete }}%;" aria-valuenow="{{ $percentComplete }}" aria-valuemin="0" aria-valuemax="100">{{ $percentComplete }}%</div>
                                </div>
                                <div class="text-muted small">
                                    {{ count($completedCertificates) }} completed out of {{ $totalCertificates }} total certificates
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- In Progress Certificates -->
    @if(count($startedCertificates) > 0)
        <h5 class="mb-3">Certificates In Progress</h5>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
            @foreach($startedCertificates as $certificate)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                @if($certificate->certificate->provider->logo)
                                    <img src="{{ Storage::url($certificate->certificate->provider->logo) }}" alt="{{ $certificate->certificate->provider->name }}" class="me-3" style="height: 40px; width: auto;" />
                                @else
                                    <div class="provider-logo-placeholder me-3">
                                        <i data-acorn-icon="building-large" class="text-primary"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="card-title mb-0">{{ $certificate->certificate->title }}</h6>
                                    <div class="text-muted small">{{ $certificate->certificate->provider->name }}</div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <span class="badge bg-warning">In Progress</span>
                                @php
                                    // Check if voucher request already exists
                                    $voucherRequestExists = $certificate->progress
                                        ->where('study_status', 'requested_voucher')
                                        ->count() > 0;
                                @endphp
                                @if($voucherRequestExists)
                                    <span class="badge bg-info ms-1">Voucher Requested</span>
                                @endif
                                @if($certificate->exam_status != 'not_taken')
                                    <span class="badge bg-primary ms-1">{{ ucfirst(str_replace('_', ' ', $certificate->exam_status)) }}</span>
                                @endif
                            </div>
                            
                            <div class="text-muted small mb-2">Started: {{ $certificate->started_at->format('M d, Y') }}</div>
                            
                            @php
                                $latestProgress = $certificate->progress->sortByDesc('created_at')->first();
                                $status = $latestProgress ? $latestProgress->study_status : 'in_progress';
                                $statusBadge = 'warning';
                                
                                switch($status) {
                                    case 'studying_for_exam':
                                        $statusBadge = 'info';
                                        break;
                                    case 'requested_voucher':
                                        $statusBadge = 'primary';
                                        break;
                                    case 'took_exam':
                                        $statusBadge = 'secondary';
                                        break;
                                    case 'passed':
                                        $statusBadge = 'success';
                                        break;
                                    case 'failed':
                                        $statusBadge = 'danger';
                                        break;
                                }
                            @endphp
                            
                            <div class="mb-3">
                                <div class="text-muted small mb-1">Current status</div>
                                <span class="badge bg-{{ $statusBadge }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                            </div>
                            
                            <div class="mt-auto">
                                <a href="{{ route('intern.certificates.show', $certificate->id) }}" class="btn btn-primary w-100">
                                    <i data-acorn-icon="eye" class="me-1"></i> View Certificate
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Completed Certificates -->
    @if(count($completedCertificates) > 0)
        <h5 class="mb-3">Completed Certificates</h5>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
            @foreach($completedCertificates as $certificate)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                @if($certificate->certificate->provider->logo)
                                    <img src="{{ Storage::url($certificate->certificate->provider->logo) }}" alt="{{ $certificate->certificate->provider->name }}" class="me-3" style="height: 40px; width: auto;" />
                                @else
                                    <div class="provider-logo-placeholder me-3">
                                        <i data-acorn-icon="building-large" class="text-primary"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="card-title mb-0">{{ $certificate->certificate->title }}</h6>
                                    <div class="text-muted small">{{ $certificate->certificate->provider->name }}</div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <span class="badge bg-success">Completed</span>
                                @if($certificate->exam_status == 'passed')
                                    <span class="badge bg-success ms-1">Exam Passed</span>
                                @endif
                            </div>
                            
                            <div class="text-muted small mb-2">
                                <div>Started: {{ $certificate->started_at->format('M d, Y') }}</div>
                                <div>Completed: {{ $certificate->completed_at->format('M d, Y') }}</div>
                                <div>Duration: {{ $certificate->started_at->diffForHumans($certificate->completed_at, true) }}</div>
                            </div>
                            
                            <div class="mt-auto">
                                <a href="{{ route('intern.certificates.show', $certificate->id) }}" class="btn btn-outline-primary w-100">
                                    <i data-acorn-icon="eye" class="me-1"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Available Certificates -->
    <h5 class="mb-3">Available Certificates</h5>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($availablePrograms as $program)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            @if($program->provider->logo)
                                <img src="{{ Storage::url($program->provider->logo) }}" alt="{{ $program->provider->name }}" class="me-3" style="height: 40px; width: auto;" />
                            @else
                                <div class="provider-logo-placeholder me-3">
                                    <i data-acorn-icon="building-large" class="text-primary"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="card-title mb-0">{{ $program->title }}</h6>
                                <div class="text-muted small">{{ $program->provider->name }}</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            @if($program->level)
                                <span class="badge bg-info">{{ ucfirst($program->level) }}</span>
                            @endif
                            <span class="badge bg-secondary ms-1">{{ ucfirst($program->type) }}</span>
                        </div>

                        @if($program->image_path)
                            <div class="certificate-image-container mb-3">
                                <img src="{{ Storage::url($program->image_path) }}" alt="{{ $program->title }}" class="img-fluid rounded" />
                            </div>
                        @endif
                        
                        <div class="text-muted small mb-3">
                            @if($program->description)
                                {{ \Illuminate\Support\Str::limit(strip_tags($program->description), 120) }}
                            @else
                                No description available.
                            @endif
                        </div>
                        
                        <div class="mt-auto">
                            <button type="button" class="btn btn-outline-primary w-100 start-certificate-btn" 
                                    data-certificate-id="{{ $program->id }}"
                                    data-certificate-title="{{ $program->title }}">
                                <i data-acorn-icon="plus" class="me-1"></i> Start Certificate
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i data-acorn-icon="certificate" class="text-muted mb-3" style="font-size: 2.5rem;"></i>
                        <h6 class="text-muted">No available certificates found</h6>
                        <p class="text-muted small mb-0">You've started all available certificate programs.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Start Certificate Confirmation Modal -->
<div class="modal fade" id="startCertificateModal" tabindex="-1" aria-labelledby="startCertificateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="startCertificateModalLabel">Start Certificate Program</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to start the certificate program: <strong id="certificateTitleText"></strong>?</p>
                <p>Once started, you'll be able to track your progress through the program's courses and request exam vouchers when you're ready.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="startCertificateForm" action="{{ route('intern.certificates.start') }}" method="POST">
                    @csrf
                    <input type="hidden" name="certificate_id" id="certificateIdInput">
                    <button type="submit" class="btn btn-primary">
                        <i data-acorn-icon="plus" class="me-1"></i> Start Program
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .provider-logo-placeholder {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(var(--primary-rgb), 0.1);
        border-radius: 4px;
    }
    
    .certificate-image-container {
        height: 120px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border-radius: 6px;
    }
    
    .certificate-image-container img {
        max-height: 100%;
        object-fit: contain;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize modal functionality for starting certificates
        const startCertificateModal = document.getElementById('startCertificateModal');
        const certificateTitleText = document.getElementById('certificateTitleText');
        const certificateIdInput = document.getElementById('certificateIdInput');
        const startButtons = document.querySelectorAll('.start-certificate-btn');
        
        // Set up event listeners for all start buttons
        startButtons.forEach(button => {
            button.addEventListener('click', function() {
                const certificateId = this.getAttribute('data-certificate-id');
                const certificateTitle = this.getAttribute('data-certificate-title');
                
                // Update modal with certificate info
                certificateTitleText.textContent = certificateTitle;
                certificateIdInput.value = certificateId;
                
                // Show the modal
                const modal = new bootstrap.Modal(startCertificateModal);
                modal.show();
            });
        });
        
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert.alert-dismissible');
            alerts.forEach(function(alert) {
                try {
                    const bsAlert = bootstrap.Alert.getInstance(alert);
                    if (bsAlert) {
                        bsAlert.close();
                    }
                } catch(e) {
                    // Fallback if bootstrap alert instance isn't available
                    alert.classList.remove('show');
                    setTimeout(() => {
                        alert.remove();
                    }, 150);
                }
            });
        }, 5000);
    });
</script>
@endpush
@endsection