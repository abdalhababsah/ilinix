@extends('dashboard-layout.app')

@section('content')
<div class="container">
    <div class="page-title-container mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-7">
                <h1 class="mb-0 pb-0 display-4 text-primary fw-bold" id="title">Completed Certificates</h1>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                    <ul class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="{{ route('intern.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('intern.certificates.index') }}" class="text-decoration-none">Certificates</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Completed</li>
                    </ul>
                </nav>
            </div>
            <div class="col-12 col-md-5 d-flex justify-content-md-end mt-3 mt-md-0">
                <button class="btn btn-outline-primary" onclick="window.print()">
                    <i data-acorn-icon="print" class="me-2"></i> Print Certificates
                </button>
            </div>
        </div>
    </div>

    <!-- Achievement Banner -->
    <div class="card mb-5 bg-gradient-primary border-0 shadow-sm">
        <div class="card-body text-center text-white p-5">
            <i data-acorn-icon="trophy" class="text-white mb-3" style="font-size: 3rem;"></i>
            <h3 class="display-6 fw-bold text-white mb-1">Your Achievements</h3>
            <p class="mb-4">Congratulations on completing {{ count($completedCertificates) }} certification(s)!</p>
            
            <div class="row g-4 justify-content-center">
                @foreach($completedCertificates as $certificate)
                    <div class="col-md-4">
                        <div class="achievement-counter bg-white bg-opacity-10 rounded p-3">
                            <h5 class="mb-1 text-white">{{ $certificate->certificate->title }}</h5>
                            <p class="small mb-2 text-white">{{ $certificate->certificate->provider->name }}</p>
                            <div class="text-white-50 small">Completed on {{ $certificate->completed_at->format('F j, Y') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Certificates Grid -->
    <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
        @foreach($completedCertificates as $certificate)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            @if($certificate->certificate->provider->logo)
                                <img src="{{ Storage::url($certificate->certificate->provider->logo) }}" alt="{{ $certificate->certificate->provider->name }}" class="me-3" style="height: 60px; width: auto;">
                            @else
                                <div class="provider-logo-placeholder me-3">
                                    <i data-acorn-icon="building-large" class="text-primary"></i>
                                </div>
                            @endif
                            <div>
                                <h5 class="card-title mb-1">{{ $certificate->certificate->title }}</h5>
                                <div class="text-muted">{{ $certificate->certificate->provider->name }}</div>
                            </div>
                        </div>
                        
                        <div class="certificate-details mb-4">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="p-2 rounded bg-light">
                                        <div class="text-muted small">Started</div>
                                        <div class="fw-medium">{{ $certificate->started_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 rounded bg-light">
                                        <div class="text-muted small">Completed</div>
                                        <div class="fw-medium">{{ $certificate->completed_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 rounded bg-light">
                                        <div class="text-muted small">Exam Status</div>
                                        <div>
                                            <span class="badge bg-success">Passed</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 rounded bg-light">
                                        <div class="text-muted small">Duration</div>
                                        <div class="fw-medium">{{ $certificate->started_at->diffForHumans($certificate->completed_at, true) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('intern.certificates.show', $certificate->id) }}" class="btn btn-outline-primary">
                                <i data-acorn-icon="eye" class="me-1"></i> View Details
                            </a>
                            @if($certificate->exam_status == 'passed' && $certificate->voucher_id)
                                <a href="{{ route('intern.certificates.download', $certificate->id) }}" class="btn btn-primary">
                                    <i data-acorn-icon="download" class="me-1"></i> Download Certificate
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    @if(count($completedCertificates) == 0)
        <div class="text-center py-5">
            <i data-acorn-icon="certificate" class="text-muted mb-3" style="font-size: 3rem;"></i>
            <h4 class="text-muted">No Completed Certificates Yet</h4>
            <p class="text-muted">Keep working on your current certifications to earn your achievements!</p>
            <a href="{{ route('intern.certificates.index') }}" class="btn btn-outline-primary mt-3">
                <i data-acorn-icon="arrow-left" class="me-1"></i> Back to Certificates
            </a>
        </div>
    @endif
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
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary) 0%, #4f8ae5 100%);
    }
    
    @media print {
        .breadcrumb-container, 
        .col-md-5,
        .btn,
        nav,
        footer {
            display: none !important;
        }
        
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        
        .container {
            max-width: 100% !important;
        }
    }
</style>
@endpush
@endsection