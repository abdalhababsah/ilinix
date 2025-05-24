@extends('dashboard-layout.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-lg-8">
            <h1 class="display-4 fw-bold mb-1">
                <span class="text-gradient">Your Onboarding Journey</span>
            </h1>
            <p class="text-muted">Complete all steps to unlock full platform access</p>
        </div>
        <div class="col-lg-4 d-flex align-items-center justify-content-lg-end mt-4 mt-lg-0">
            <div class="progress-wrapper w-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-semibold">Overall Progress</span>
                    <span class="badge progress-badge">{{ $progressPercentage }}%</span>
                </div>
                <div class="progress progress-modern">
                    <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%;" 
                         aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success-modern alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger-modern alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Content -->
    <div class="card border-0 shadow-card">
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Step Navigation Sidebar -->
                <div class="col-lg-4 border-end-lg">
                    <div class="step-sidebar">
                        <div class="step-sidebar-header p-4 border-bottom">
                            <h5 class="mb-0 fw-semibold">
                                <i class="fas fa-tasks me-2 text-primary"></i>
                                Onboarding Path
                            </h5>
                        </div>
                        <div class="step-list p-2">
                            @foreach($userSteps as $userStep)
                                <div class="step-item {{ $activeStep && $activeStep->onboarding_step_id == $userStep->onboarding_step_id ? 'active' : '' }}"
                                     data-step-id="{{ $userStep->step->id }}">
                                    <div class="step-link d-flex align-items-center p-3">
                                        <div class="step-number me-3 {{ $userStep->is_completed ? 'completed' : ($activeStep && $activeStep->onboarding_step_id == $userStep->onboarding_step_id ? 'active' : '') }}">
                                            @if($userStep->is_completed)
                                                <i class="fas fa-check"></i>
                                            @else
                                                {{ $loop->iteration }}
                                            @endif
                                        </div>
                                        <div class="step-info flex-grow-1">
                                            <h6 class="step-title mb-0">{{ $userStep->step->title }}</h6>
                                            @if($userStep->is_completed)
                                                <div class="step-status text-success">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Completed 
                                                    @if($userStep->completed_at)
                                                        <span class="text-muted">{{ \Carbon\Carbon::parse($userStep->completed_at)->format('M d, Y') }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="step-arrow">
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Step Content Area -->
                <div class="col-lg-8">
                    <div class="step-content p-lg-5 p-4">
                        @if($activeStep)
                            <div class="step-content-header mb-4">
                                <h2 class="step-content-title mb-2" id="stepTitle">{{ $activeStep->step->title }}</h2>
                                <div class="step-content-divider"></div>
                            </div>

                            <div class="step-content-body mb-5" id="stepDescription">
                                {!! $activeStep->step->description !!}
                            </div>

                            @if($activeStep->step->resource_link)
                                <div class="resource-image mb-4">
                                    <a href="{{ $activeStep->step->resource_link }}" target="_blank" class="resource-link">
                                        <div class="resource-preview">
                                            <img src="{{ asset('storage/' . $activeStep->step->resource_link) }}" alt="Resource Material" class="img-fluid">
                                            <div class="resource-overlay">
                                                <span><i class="fas fa-external-link-alt me-2"></i> View Full Resource</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif

                            <div id="progressMessage" class="alert d-none mb-4"></div>

                            <div class="step-actions d-flex flex-wrap justify-content-between align-items-center mt-5">
                                <button type="button" id="prevButton" class="btn btn-outline-secondary btn-with-icon" 
                                        {{ $userSteps->first()->onboarding_step_id == $activeStep->onboarding_step_id ? 'disabled' : '' }}>
                                    <i class="fas fa-arrow-left me-2"></i> Previous
                                </button>

                                <div class="action-center my-3 my-md-0">
                                    <button type="button" id="completeButton" class="btn btn-primary btn-lg btn-with-icon"
                                            data-step-id="{{ $activeStep->step->id }}" 
                                            {{ $activeStep->is_completed ? 'disabled' : '' }}>
                                        @if($activeStep->is_completed)
                                            <i class="fas fa-check-circle me-2"></i> Completed
                                        @else
                                            <i class="fas fa-check-circle me-2"></i> Mark Complete
                                        @endif
                                    </button>
                                </div>

                                <button type="button" id="nextButton" class="btn btn-outline-secondary btn-with-icon"
                                        {{ $userSteps->last()->onboarding_step_id == $activeStep->onboarding_step_id ? 'disabled' : '' }}>
                                    Next <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        @else
                            <div class="empty-state text-center py-5">
                                <div class="empty-state-icon">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <h4 class="mt-4">No onboarding steps found</h4>
                                <p class="text-muted">Please contact your administrator to set up the onboarding process.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Completion Action Button - Only visible when 100% complete -->
    @if($progressPercentage == 100)
        <div class="completion-action text-center mt-5">
            <div class="completion-animation mb-4">
                <i class="fas fa-trophy"></i>
            </div>
            <a href="{{ route('intern.onboarding.finalize') }}" class="btn btn-success btn-lg pulsate">
                <i class="fas fa-check-circle me-2"></i> Complete Onboarding & Access Dashboard
            </a>
        </div>
    @endif
</div>

<!-- Completion Modal -->
<div class="modal fade" id="completionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pb-5 px-md-5">
                <div class="success-animation">
                    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                        <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                    </svg>
                </div>
                <div class="confetti-animation">
                    <i class="fas fa-trophy trophy-icon"></i>
                </div>
                <h3 class="modal-title mt-3 mb-1">Onboarding Complete!</h3>
                <p class="text-muted mb-4">You've successfully completed all onboarding steps. You're now ready to access the full platform!</p>
                <a href="{{ route('intern.onboarding.finalize') }}" class="btn btn-success btn-lg px-5">
                    <i class="fas fa-rocket me-2"></i> Launch Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* ===== VARIABLES ===== */
    :root {
        --primary: #00c851;
        --primary-dark: #00a040;
        --primary-light: #7dffb3;
        --primary-transparent: rgba(0, 200, 81, 0.1);
        --secondary: #293241;
        --secondary-dark: #1c232e;
        --secondary-light: #3d4a61;
        --white: #ffffff;
        --off-white: #f9f9f9;
        --gray-light: #f5f5f5;
        --gray: #e0e0e0;
        --gray-dark: #9e9e9e;
        --text-dark: #333333;
        --text-light: #777777;
        --shadow-sm: 0 2px 5px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 5px 15px rgba(0, 0, 0, 0.07);
        --shadow-lg: 0 15px 30px rgba(0, 0, 0, 0.1);
        --shadow-highlight: 0 5px 25px rgba(0, 200, 81, 0.3);
        --transition-fast: 0.1s ease;
        --transition: 0.1s ease;
        --transition-slow: 0.1s ease;
        --cubic-bezier: cubic-bezier(0.25, 0.1, 0.25, 1);
    }

    /* ===== GLOBAL STYLES ===== */
    body {
        background-color: var(--off-white);
        color: var(--text-dark);
    }

    /* ===== TYPOGRAPHY ===== */
    .text-gradient {
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ===== CARD ===== */
    .shadow-card {
        box-shadow: var(--shadow-md);
        border-radius: 12px;
        overflow: hidden;
        background: var(--white);
        transition: box-shadow 0.3s ease;
    }

    .shadow-card:hover {
        box-shadow: var(--shadow-lg);
    }

    /* ===== PROGRESS BAR ===== */
    .progress-wrapper {
        max-width: 300px;
    }

    .progress-modern {
        height: 10px;
        background-color: var(--gray-light);
        border-radius: 50px;
        overflow: hidden;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .progress-modern .progress-bar {
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        border-radius: 50px;
        position: relative;
        transition: width 0.6s cubic-bezier(0.65, 0, 0.35, 1);
    }

    .badge.progress-badge {
        background: var(--primary);
        color: var(--white);
        font-weight: 600;
        border-radius: 20px;
        padding: 0.35em 0.65em;
    }

    /* ===== ALERTS ===== */
    .alert-success-modern,
    .alert-danger-modern {
        border: none;
        border-radius: 10px;
        padding: 1rem;
    }

    .alert-success-modern {
        background-color: rgba(0, 200, 81, 0.1);
        color: var(--primary-dark);
    }

    .alert-danger-modern {
        background-color: rgba(255, 76, 76, 0.1);
        color: #e53935;
    }

    .alert-icon {
        font-size: 1.5rem;
        margin-right: 1rem;
    }

    .alert-success-modern .alert-icon {
        color: var(--primary);
    }

    .alert-danger-modern .alert-icon {
        color: #e53935;
    }

    /* ===== STEP SIDEBAR ===== */
    .step-sidebar {
        height: 100%;
        background-color: var(--white);
    }

    .step-sidebar-header {
        background-color: var(--off-white);
    }

    .step-list {
        overflow-y: auto;
        max-height: 600px;
    }

    .step-item {
        cursor: pointer;
        transition: all 0.2s ease;
        border-radius: 8px;
        margin: 0.5rem;
    }

    .step-item:hover {
        background-color: var(--gray-light);
    }

    .step-item.active {
        background-color: var(--primary-transparent);
    }

    .step-number {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        background-color: var(--gray);
        color: var(--text-dark);
        transition: all 0.3s ease;
    }

    .step-number.active {
        background-color: var(--primary);
        color: var(--white);
        box-shadow: 0 3px 10px rgba(0, 200, 81, 0.3);
    }

    .step-number.completed {
        background-color: var(--primary);
        color: var(--white);
    }

    .step-title {
        color: var(--text-dark);
        font-weight: 500;
    }

    .step-status {
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }

    .step-arrow {
        opacity: 0;
        color: var(--primary);
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .step-item:hover .step-arrow,
    .step-item.active .step-arrow {
        opacity: 1;
        transform: translateX(5px);
    }

    /* ===== STEP CONTENT ===== */
    .step-content {
        background-color: var(--white);
        min-height: 500px;
    }

    .step-content-title {
        color: var(--secondary);
        font-weight: 600;
    }

    .step-content-divider {
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
        border-radius: 2px;
        margin-bottom: 1.5rem;
    }

    .step-content-body {
        color: var(--text-light);
        line-height: 1.7;
    }
    
    /* Resource Image Styling */
    .resource-image {
        margin: 1.5rem 0;
    }
    
    .resource-preview {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
    }
    
    .resource-preview img {
        display: block;
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        object-position: center;
        transition: transform 0.5s ease;
    }
    
    .resource-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 70%, rgba(0,0,0,0) 100%);
        color: white;
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }
    
    .resource-preview:hover {
        box-shadow: var(--shadow-highlight);
    }
    
    .resource-preview:hover img {
        transform: scale(1.05);
    }
    
    .resource-preview:hover .resource-overlay {
        opacity: 1;
        transform: translateY(0);
    }

    /* ===== BUTTONS ===== */
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-primary:hover, .btn-primary:focus {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        box-shadow: var(--shadow-highlight);
    }

    .btn-outline-primary {
        color: var(--primary);
        border-color: var(--primary);
        background-color: transparent;
        font-weight: 500;
    }

    .btn-outline-primary:hover, .btn-outline-primary:focus {
        background-color: var(--primary);
        color: white;
    }

    .btn-outline-secondary {
        color: var(--secondary);
        border-color: var(--gray);
        background-color: transparent;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-outline-secondary:hover, .btn-outline-secondary:focus {
        background-color: var(--gray-light);
        color: var(--secondary-dark);
    }

    .btn-with-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-success {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
        font-weight: 500;
    }

    .btn-success:hover, .btn-success:focus {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        box-shadow: var(--shadow-highlight);
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        padding: 3rem 1rem;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: var(--gray-light);
        color: var(--gray-dark);
        font-size: 2rem;
    }

    /* ===== COMPLETION ===== */
    .completion-action {
        animation: fadeInUp 0.8s ease forwards;
    }

    .completion-animation {
        font-size: 3rem;
        color: var(--primary);
        animation: bounce 1.5s infinite;
    }

    .pulsate {
        animation: pulsate 1.5s infinite;
    }

    /* ===== MODAL ===== */
    .modal-content {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .success-animation {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto;
    }

    .checkmark {
        width: 100%;
        height: 100%;
    }

    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: var(--primary);
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke-width: 3;
        stroke: var(--primary);
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    .confetti-animation {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .trophy-icon {
        font-size: 3rem;
        color: #ffc107;
        animation: floatUp 2s ease infinite alternate;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-20px);
        }
        60% {
            transform: translateY(-10px);
        }
    }

    @keyframes pulsate {
        0% {
            box-shadow: 0 0 0 0 rgba(0, 200, 81, 0.6);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(0, 200, 81, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(0, 200, 81, 0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes floatUp {
        from {
            transform: translateY(5px) scale(1);
        }
        to {
            transform: translateY(-5px) scale(1.1);
        }
    }

    /* ===== MEDIA QUERIES ===== */
    @media (max-width: 992px) {
        .border-end-lg {
            border-right: none !important;
            border-bottom: 1px solid var(--gray);
        }
        
        .step-list {
            max-height: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stepItems = document.querySelectorAll('.step-item');
        const prevButton = document.getElementById('prevButton');
        const nextButton = document.getElementById('nextButton');
        const completeButton = document.getElementById('completeButton');
        const progressMessage = document.getElementById('progressMessage');
        const stepTitle = document.getElementById('stepTitle');
        const stepDescription = document.getElementById('stepDescription');
        
        // Update step content
        function updateStepContent(stepId) {
            // Find the step button by id
            const stepItem = document.querySelector(`.step-item[data-step-id="${stepId}"]`);
            if (!stepItem) return;
            
            // Update active state for all items
            stepItems.forEach(item => item.classList.remove('active'));
            stepItem.classList.add('active');
            
            // Get the step info from the DOM
            const stepTitle = stepItem.querySelector('.step-title').textContent;
            const isCompleted = stepItem.querySelector('.step-number.completed') !== null;
            
            // Update content
            document.getElementById('stepTitle').textContent = stepTitle;
            
            // Update button states
            completeButton.dataset.stepId = stepId;
            
            if (isCompleted) {
                completeButton.innerHTML = '<i class="fas fa-check-circle me-2"></i> Completed';
                completeButton.disabled = true;
            } else {
                completeButton.innerHTML = '<i class="fas fa-check-circle me-2"></i> Mark Complete';
                completeButton.disabled = false;
            }
            
            // Check if this is the first or last step for prev/next buttons
            const isFirstStep = stepItems[0] === stepItem;
            const isLastStep = stepItems[stepItems.length - 1] === stepItem;
            
            prevButton.disabled = isFirstStep;
            nextButton.disabled = isLastStep;
            
            // Clear any progress messages
            progressMessage.classList.add('d-none');
            
            // Add slide-in animation to content
            const stepContent = document.querySelector('.step-content');
            stepContent.classList.add('content-fade');
            setTimeout(() => {
                stepContent.classList.remove('content-fade');
            }, 300);
        }
        
        // Handle mark as complete
        completeButton.addEventListener('click', function() {
            const stepId = this.dataset.stepId;
            
            // Show loading state
            completeButton.disabled = true;
            completeButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';
            
            // Send AJAX request
            fetch('{{ route("intern.onboarding.complete-step") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ step_id: stepId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    const stepItem = document.querySelector(`.step-item[data-step-id="${stepId}"]`);
                    const indicator = stepItem.querySelector('.step-number');
                    
                    // Update indicator to show completed
                    indicator.classList.add('completed');
                    indicator.innerHTML = '<i class="fas fa-check"></i>';
                    
                    // Add completed text
                    if (!stepItem.querySelector('.step-status')) {
                        const statusDiv = document.createElement('div');
                        statusDiv.className = 'step-status text-success';
                        statusDiv.innerHTML = '<i class="fas fa-check-circle me-1"></i> Completed';
                        stepItem.querySelector('.step-info').appendChild(statusDiv);
                    }
                    
                    // Update buttons
                    completeButton.innerHTML = '<i class="fas fa-check-circle me-2"></i> Completed';
                    completeButton.disabled = true;
                    
                    // Show success message
                    progressMessage.innerHTML = '<div class="d-flex align-items-center"><div class="alert-icon"><i class="fas fa-check-circle"></i></div><div>Step successfully completed!</div></div>';
                    progressMessage.classList.remove('d-none', 'alert-danger-modern');
                    progressMessage.classList.add('alert-success-modern');
                    
                    // Update progress bar with animation
                    const progressBar = document.querySelector('.progress-bar');
                    const progressBadge = document.querySelector('.badge.progress-badge');
                    
                    // Animate progress change
                    const currentProgress = parseInt(progressBar.getAttribute('aria-valuenow'));
                    const newProgress = data.progress_percentage;
                    const progressDiff = newProgress - currentProgress;
                    const progressStep = progressDiff / 10;
                    
                    let currentStep = 0;
                    const progressInterval = setInterval(() => {
                        currentStep++;
                        const stepValue = Math.round(currentProgress + (progressStep * currentStep));
                        progressBar.style.width = `${stepValue}%`;
                        progressBar.setAttribute('aria-valuenow', stepValue);
                        progressBadge.textContent = `${stepValue}%`;
                        
                        if (currentStep >= 10) {
                            clearInterval(progressInterval);
                            progressBar.style.width = `${newProgress}%`;
                            progressBar.setAttribute('aria-valuenow', newProgress);
                            progressBadge.textContent = `${newProgress}%`;
                        }
                    }, 50);
                    
                    // If all completed, show completion modal
                    if (data.all_completed) {
                        // Add celebration animation before showing modal
                        setTimeout(() => {
                            const completionModal = new bootstrap.Modal(document.getElementById('completionModal'));
                            completionModal.show();
                            
                            // Show the "Complete Onboarding" button if not already visible
                            if (!document.querySelector('.completion-action')) {
                                const completionDiv = document.createElement('div');
                                completionDiv.className = 'completion-action text-center mt-5';
                                completionDiv.innerHTML = `
                                    <div class="completion-animation mb-4">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <a href="{{ route('intern.onboarding.finalize') }}" class="btn btn-success btn-lg pulsate">
                                        <i class="fas fa-check-circle me-2"></i> Complete Onboarding & Access Dashboard
                                    </a>
                                `;
                                document.querySelector('.container').appendChild(completionDiv);
                            }
                        }, 500);
                    } else if (data.next_step) {
                        // If there's a next step, move to it after a brief delay
                        setTimeout(() => {
                            updateStepContent(data.next_step.id);
                        }, 1000);
                    }
                } else {
                    // Show error message
                    progressMessage.innerHTML = '<div class="d-flex align-items-center"><div class="alert-icon"><i class="fas fa-exclamation-circle"></i></div><div>Failed to complete step. Please try again.</div></div>';
                    progressMessage.classList.remove('d-none', 'alert-success-modern');
                    progressMessage.classList.add('alert-danger-modern');
                    
                    // Reset button
                    completeButton.innerHTML = '<i class="fas fa-check-circle me-2"></i> Mark Complete';
                    completeButton.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Show error message
                progressMessage.innerHTML = '<div class="d-flex align-items-center"><div class="alert-icon"><i class="fas fa-exclamation-circle"></i></div><div>An error occurred. Please try again.</div></div>';
                progressMessage.classList.remove('d-none', 'alert-success-modern');
                progressMessage.classList.add('alert-danger-modern');
                
                // Reset button
                completeButton.innerHTML = '<i class="fas fa-check-circle me-2"></i> Mark Complete';
                completeButton.disabled = false;
            });
        });
        
        // Handle step navigation
        stepItems.forEach(item => {
            item.addEventListener('click', function() {
                const stepId = this.dataset.stepId;
                updateStepContent(stepId);
            });
        });
        
        // Handle previous button
        prevButton.addEventListener('click', function() {
            const activeStep = document.querySelector('.step-item.active');
            if (activeStep && activeStep.previousElementSibling) {
                const prevStep = activeStep.previousElementSibling;
                const stepId = prevStep.dataset.stepId;
                updateStepContent(stepId);
            }
        });
        
        // Handle next button
        nextButton.addEventListener('click', function() {
            const activeStep = document.querySelector('.step-item.active');
            if (activeStep && activeStep.nextElementSibling) {
                const nextStep = activeStep.nextElementSibling;
                const stepId = nextStep.dataset.stepId;
                updateStepContent(stepId);
            }
        });
        
        // Add hover effects to buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                if (!this.disabled) {
                    this.style.transform = 'translateY(-2px)';
                    this.style.transition = 'transform 0.2s ease';
                }
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert.alert-dismissible');
            alerts.forEach(function(alert) {
                try {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                } catch(e) {
                    // Fallback if bootstrap alert instance isn't available
                    alert.classList.remove('show');
                    setTimeout(() => {
                        alert.remove();
                    }, 150);
                }
            });
        }, 5000);
        
        // Add a subtle parallax effect to the page header
        window.addEventListener('scroll', function() {
            const scrollPosition = window.scrollY;
            const header = document.querySelector('.display-4');
            if (header) {
                header.style.transform = `translateY(${scrollPosition * 0.1}px)`;
            }
        });
    });
</script>
@endpush
@endsection