@extends('dashboard-layout.app')

@section('title', 'Flagged Interns')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Flagged Interns</h1>
        </div>

        @include('components._messages')

        <!-- Status Filter Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('admin.flagged-interns.index', ['status' => 'pending']) }}" class="text-decoration-none">
                    <div
                        class="card border-left-warning shadow h-100 py-2 {{ request('status') == 'pending' || !request('status') ? 'bg-warning text-white' : '' }}">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div
                                        class="text-xs font-weight-bold text-uppercase mb-1 {{ request('status') == 'pending' || !request('status') ? 'text-white' : 'text-warning' }}">
                                        Pending
                                    </div>
                                    <div
                                        class="h5 mb-0 font-weight-bold {{ request('status') == 'pending' || !request('status') ? 'text-white' : 'text-gray-800' }}">
                                        {{ $counts['pending'] }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i
                                        class="fas fa-clock fa-2x {{ request('status') == 'pending' || !request('status') ? 'text-white' : 'text-warning' }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('admin.flagged-interns.index', ['status' => 'reviewed']) }}" class="text-decoration-none">
                    <div
                        class="card border-left-info shadow h-100 py-2 {{ request('status') == 'reviewed' ? 'bg-info text-white' : '' }}">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div
                                        class="text-xs font-weight-bold text-uppercase mb-1 {{ request('status') == 'reviewed' ? 'text-white' : 'text-info' }}">
                                        Reviewed
                                    </div>
                                    <div
                                        class="h5 mb-0 font-weight-bold {{ request('status') == 'reviewed' ? 'text-white' : 'text-gray-800' }}">
                                        {{ $counts['reviewed'] }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i
                                        class="fas fa-eye fa-2x {{ request('status') == 'reviewed' ? 'text-white' : 'text-info' }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('admin.flagged-interns.index', ['status' => 'cleared']) }}" class="text-decoration-none">
                    <div
                        class="card border-left-success shadow h-100 py-2 {{ request('status') == 'cleared' ? 'bg-success text-white' : '' }}">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div
                                        class="text-xs font-weight-bold text-uppercase mb-1 {{ request('status') == 'cleared' ? 'text-white' : 'text-success' }}">
                                        Cleared
                                    </div>
                                    <div
                                        class="h5 mb-0 font-weight-bold {{ request('status') == 'cleared' ? 'text-white' : 'text-gray-800' }}">
                                        {{ $counts['cleared'] }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i
                                        class="fas fa-check-circle fa-2x {{ request('status') == 'cleared' ? 'text-white' : 'text-success' }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('admin.flagged-interns.index', ['status' => 'escalated']) }}"
                    class="text-decoration-none">
                    <div
                        class="card border-left-danger shadow h-100 py-2 {{ request('status') == 'escalated' ? 'bg-danger text-white' : '' }}">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div
                                        class="text-xs font-weight-bold text-uppercase mb-1 {{ request('status') == 'escalated' ? 'text-white' : 'text-danger' }}">
                                        Escalated
                                    </div>
                                    <div
                                        class="h5 mb-0 font-weight-bold {{ request('status') == 'escalated' ? 'text-white' : 'text-gray-800' }}">
                                        {{ $counts['escalated'] }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i
                                        class="fas fa-exclamation-triangle fa-2x {{ request('status') == 'escalated' ? 'text-white' : 'text-danger' }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Search and Filter Controls -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Search & Filter</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="viewDropdown" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-th fa-sm fa-fw text-gray-400"></i> View
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="viewDropdown">
                        <div class="dropdown-header">View Options:</div>
                        <a class="dropdown-item active" href="#" data-view="card">
                            <i class="fas fa-th-large fa-sm fa-fw mr-2 text-gray-400"></i>
                            Card View
                        </a>
                        <a class="dropdown-item" href="#" data-view="list">
                            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                            List View
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.flagged-interns.index') }}" method="GET" class="mb-0">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="intern_name" class="form-label">Intern Name</label>
                            <input type="text" class="form-control" id="intern_name" name="intern_name"
                                value="{{ request('intern_name') }}" placeholder="Search by intern name">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="mentor_name" class="form-label">Mentor Name</label>
                            <input type="text" class="form-control" id="mentor_name" name="mentor_name"
                                value="{{ request('mentor_name') }}" placeholder="Search by mentor name">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed
                                </option>
                                <option value="cleared" {{ request('status') == 'cleared' ? 'selected' : '' }}>Cleared
                                </option>
                                <option value="escalated" {{ request('status') == 'escalated' ? 'selected' : '' }}>
                                    Escalated</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="direction" class="form-label">Sort Direction</label>
                            <select class="form-control" id="direction" name="direction">
                                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Newest First
                                </option>
                                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Oldest First
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{ route('admin.flagged-interns.index') }}" class="btn btn-secondary">Reset
                                Filters</a>
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Flags Card Grid View -->
        <div class="row" id="card-view">
            @if ($flags->count() > 0)
                @foreach ($flags as $flag)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div
                            class="card shadow h-100 border-{{ $flag->status == 'pending' ? 'warning' : ($flag->status == 'reviewed' ? 'info' : ($flag->status == 'cleared' ? 'success' : 'danger')) }}">
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between 
                            @if ($flag->status == 'pending') bg-warning-light
                            @elseif($flag->status == 'reviewed') bg-info-light
                            @elseif($flag->status == 'cleared') bg-success-light
                            @elseif($flag->status == 'escalated') bg-danger-light @endif">
                                <h6
                                    class="m-0 font-weight-bold 
                                @if ($flag->status == 'pending') text-warning
                                @elseif($flag->status == 'reviewed') text-info
                                @elseif($flag->status == 'cleared') text-success
                                @elseif($flag->status == 'escalated') text-danger @endif">
                                    {{ ucfirst($flag->status) }} Flag
                                </h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button"
                                        id="dropdownMenuLink{{ $flag->id }}" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink{{ $flag->id }}">
                                        <div class="dropdown-header">Actions:</div>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.interns.show', $flag->intern_id) }}">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                            View Intern Profile
                                        </a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.mentors.show', $flag->mentor_id) }}">
                                            <i class="fas fa-user-tie fa-sm fa-fw mr-2 text-gray-400"></i>
                                            View Mentor Profile
                                        </a>
                                        @if ($flag->status == 'pending')
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item review-flag-btn" href="#" data-toggle="modal"
                                                data-target="#reviewFlagModal" data-flag-id="{{ $flag->id }}"
                                                data-intern-name="{{ $flag->intern->first_name }} {{ $flag->intern->last_name }}"
                                                data-intern-id="{{ $flag->intern_id }}"
                                                data-mentor-name="{{ $flag->mentor->first_name }} {{ $flag->mentor->last_name }}"
                                                data-flag-date="{{ $flag->flagged_at->format('M d, Y h:i A') }}"
                                                data-flag-reason="{{ $flag->reason }}">
                                                <i class="fas fa-tasks fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Review Flag
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Intern Info Section -->
                                <div class="d-flex align-items-center mb-3">
                                    <div
                                        class="avatar-circle mr-3 
                                    @if ($flag->status == 'pending') bg-warning
                                    @elseif($flag->status == 'reviewed') bg-info
                                    @elseif($flag->status == 'cleared') bg-success
                                    @elseif($flag->status == 'escalated') bg-danger @endif">
                                        <span class="initials text-white">
                                            {{ strtoupper(substr($flag->intern->first_name, 0, 1)) }}{{ strtoupper(substr($flag->intern->last_name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 font-weight-bold">{{ $flag->intern->first_name }}
                                            {{ $flag->intern->last_name }}</h5>
                                        <p class="mb-0 text-muted small">{{ $flag->intern->email }}</p>
                                    </div>
                                </div>

                                <!-- Flag Reason Section -->
                                <div class="mb-3">
                                    <h6 class="font-weight-bold text-gray-700">Flag Reason:</h6>
                                    <div class="card-reason p-2 bg-light rounded border" data-toggle="tooltip"
                                        title="Click to expand">
                                        {{ $flag->reason }}
                                    </div>
                                </div>

                                <!-- Details Section -->
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <h6 class="font-weight-bold text-gray-700 small mb-1">Flagged By:</h6>
                                        <p class="mb-0">{{ $flag->mentor->first_name }} {{ $flag->mentor->last_name }}
                                        </p>
                                    </div>
                                    <div>
                                        <h6 class="font-weight-bold text-gray-700 small mb-1">Flagged On:</h6>
                                        <p class="mb-0">{{ $flag->flagged_at->format('M d, Y') }}</p>
                                    </div>
                                </div>

                                <!-- Additional Attributes -->
                                <div class="flag-attributes mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="attribute-item">
                                                <span class="attribute-label">Email Sent</span>
                                                <span
                                                    class="attribute-value {{ $flag->email_sent ? 'text-success' : 'text-danger' }}">
                                                    <i class="fas {{ $flag->email_sent ? 'fa-check' : 'fa-times' }}"></i>
                                                    {{ $flag->email_sent ? 'Yes' : 'No' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="attribute-item">
                                                <span class="attribute-label">Time Since</span>
                                                <span
                                                    class="attribute-value">{{ $flag->flagged_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Review Details (if reviewed) -->
                                @if ($flag->reviewed_at)
                                    <div class="review-details mt-3 pt-3 border-top">
                                        <h6 class="font-weight-bold text-gray-700 small mb-2">Review Details:</h6>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1 small text-muted">Reviewed By:</p>
                                                <p class="mb-2">{{ $flag->reviewer->first_name ?? 'Unknown' }}
                                                    {{ $flag->reviewer->last_name ?? '' }}</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1 small text-muted">Reviewed On:</p>
                                                <p class="mb-2">{{ $flag->reviewed_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        @if ($flag->review_notes)
                                            <div class="review-notes">
                                                <p class="mb-1 small text-muted">Review Notes:</p>
                                                <p class="small review-text p-2 bg-light rounded border"
                                                    data-toggle="tooltip" title="Click to expand">
                                                    {{ $flag->review_notes }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div
                                class="card-footer d-flex justify-content-between {{ $flag->status == 'pending' ? 'bg-warning-light' : '' }}">
                                <a href="{{ route('admin.interns.show', $flag->intern_id) }}"
                                    class="btn btn-sm btn-sm-admin btn-primary">
                                    <i class="fas fa-user"></i> View Intern
                                </a>
                                @if ($flag->status == 'pending')
                                    <button class="btn btn-sm btn-warning review-flag-btn" type="button"
                                        data-toggle="modal" data-target="#reviewFlagModal"
                                        data-flag-id="{{ $flag->id }}"
                                        data-intern-name="{{ $flag->intern->first_name }} {{ $flag->intern->last_name }}"
                                        data-intern-id="{{ $flag->intern_id }}"
                                        data-mentor-name="{{ $flag->mentor->first_name }} {{ $flag->mentor->last_name }}"
                                        data-flag-date="{{ $flag->flagged_at->format('M d, Y h:i A') }}"
                                        data-flag-reason="{{ $flag->reason }}">
                                        <i class="fas fa-tasks"></i> Review Flag
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-flag fa-3x text-gray-300 mb-3"></i>
                            <p class="lead text-gray-500">No flags found matching your criteria.</p>
                            @if (request()->anyFilled(['status', 'intern_name', 'mentor_name']))
                                <a href="{{ route('admin.flagged-interns.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-sync-alt"></i> Clear Filters
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- List View (Hidden by default) -->
        <div class="card shadow mb-4" id="list-view" style="display: none;">
            <div class="card-body">
                @if ($flags->count() > 0)
                    <div class="list-group">
                        @foreach ($flags as $flag)
                            <div
                                class="list-group-item list-group-item-action flex-column align-items-start p-3 border-{{ $flag->status == 'pending' ? 'warning' : ($flag->status == 'reviewed' ? 'info' : ($flag->status == 'cleared' ? 'success' : 'danger')) }}">
                                <div class="d-flex w-100 justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="flag-status-indicator 
                                            @if ($flag->status == 'pending') bg-warning
                                            @elseif($flag->status == 'reviewed') bg-info
                                            @elseif($flag->status == 'cleared') bg-success
                                            @elseif($flag->status == 'escalated') bg-danger @endif mr-2">
                                            </div>
                                            <h5 class="mb-1 font-weight-bold">{{ $flag->intern->first_name }}
                                                {{ $flag->intern->last_name }}</h5>
                                            <span
                                                class="badge badge-pill 
                                            @if ($flag->status == 'pending') badge-warning
                                            @elseif($flag->status == 'reviewed') badge-info
                                            @elseif($flag->status == 'cleared') badge-success
                                            @elseif($flag->status == 'escalated') badge-danger @endif ml-2">
                                                {{ ucfirst($flag->status) }}
                                            </span>
                                        </div>
                                        <p class="mb-1 text-muted small">{{ $flag->intern->email }} | Flagged by:
                                            {{ $flag->mentor->first_name }} {{ $flag->mentor->last_name }}</p>
                                    </div>
                                    <small class="text-muted">{{ $flag->flagged_at->format('M d, Y') }}
                                        ({{ $flag->flagged_at->diffForHumans() }})</small>
                                </div>
                                <p class="mb-1 mt-2">{{ $flag->reason }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        @if ($flag->email_sent)
                                            <span class="badge badge-light text-dark mr-2">
                                                <i class="fas fa-envelope"></i> Email Sent
                                            </span>
                                        @endif
                                        @if ($flag->reviewed_at)
                                            <span class="badge badge-light text-dark">
                                                <i class="fas fa-check"></i> Reviewed
                                                {{ $flag->reviewed_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.interns.show', $flag->intern_id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-user"></i> View Intern
                                        </a>
                                        @if ($flag->status == 'pending')
                                            <button class="btn btn-sm btn-warning review-flag-btn" type="button"
                                                data-toggle="modal" data-target="#reviewFlagModal"
                                                data-flag-id="{{ $flag->id }}"
                                                data-intern-name="{{ $flag->intern->first_name }} {{ $flag->intern->last_name }}"
                                                data-intern-id="{{ $flag->intern_id }}"
                                                data-mentor-name="{{ $flag->mentor->first_name }} {{ $flag->mentor->last_name }}"
                                                data-flag-date="{{ $flag->flagged_at->format('M d, Y h:i A') }}"
                                                data-flag-reason="{{ $flag->reason }}">
                                                <i class="fas fa-tasks"></i> Review
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                @if ($flag->reviewed_at && $flag->review_notes)
                                    <div class="mt-3 pt-2 border-top">
                                        <small class="text-muted d-block mb-1">
                                            <strong>Review Notes ({{ $flag->reviewed_at->format('M d, Y') }}):</strong>
                                        </small>
                                        <p class="font-italic small mb-0">{{ Str::limit($flag->review_notes, 200) }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-flag fa-3x text-gray-300 mb-3"></i>
                        <p class="lead text-gray-500">No flags found matching your criteria.</p>
                        @if (request()->anyFilled(['status', 'intern_name', 'mentor_name']))
                            <a href="{{ route('admin.flagged-interns.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-sync-alt"></i> Clear Filters
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-end mb-4">
            {{ $flags->links() }}
        </div>

        <!-- Single Dynamic Review Flag Modal -->
        <div class="modal fade" id="reviewFlagModal" tabindex="-1" role="dialog"
            aria-labelledby="reviewFlagModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="reviewFlagModalLabel">
                            Review Flag
                        </h5>
                        <button type="button" class="close  btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="reviewFlagForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <h6 class="font-weight-bold mb-2">Flag Details</h6>
                                <p class="mb-1"><strong>Intern:</strong> <span id="flag-intern-name"></span></p>
                                <p class="mb-1"><strong>Flagged By:</strong> <span id="flag-mentor-name"></span></p>
                                <p class="mb-1"><strong>Date:</strong> <span id="flag-date"></span></p>
                                <p class="mb-0"><strong>Reason:</strong> <span id="flag-reason"></span></p>
                            </div>

                            <div class="form-group">
                                <label for="reviewStatus" class="font-weight-bold">Update Status</label>
                                <select class="form-control" id="reviewStatus" name="status" required>
                                    <option value="reviewed">Reviewed</option>
                                    <option value="cleared">Cleared</option>
                                    <option value="escalated">Escalated</option>
                                </select>
                                <small class="form-text text-muted">
                                    <strong>Reviewed</strong>: Acknowledge the flag without clearing or escalating<br>
                                    <strong>Cleared</strong>: No issues found, flag is resolved<br>
                                    <strong>Escalated</strong>: Serious issue requiring higher attention
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="reviewNotes" class="font-weight-bold">Review Notes</label>
                                <textarea class="form-control" id="reviewNotes" name="review_notes" rows="4" required
                                    placeholder="Describe your findings and any actions taken..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Status indicator colors */
        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .bg-info-light {
            background-color: rgba(23, 162, 184, 0.1);
        }

        .bg-success-light {
            background-color: rgba(40, 167, 69, 0.1);
        }

        .bg-danger-light {
            background-color: rgba(220, 53, 69, 0.1);
        }

        /* Avatar circle */
        .avatar-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .initials {
            font-size: 1.2rem;
            font-weight: bold;
        }

        /* Card reason and review text */
        .card-reason,
        .review-text {
            max-height: 80px;
            overflow-y: auto;
            transition: max-height 0.3s ease;
            cursor: pointer;
        }

        .card-reason.expanded,
        .review-text.expanded {
            max-height: 300px;
        }

        /* Flag attributes */
        .attribute-item {
            display: flex;
            flex-direction: column;
        }

        .attribute-label {
            font-size: 0.75rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }

        .attribute-value {
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* List view flag status indicator */
        .flag-status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        /* Scrollbar styles */
        .card-reason::-webkit-scrollbar,
        .review-text::-webkit-scrollbar {
            width: 5px;
        }

        .card-reason::-webkit-scrollbar-track,
        .review-text::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }

        .card-reason::-webkit-scrollbar-thumb,
        .review-text::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 5px;
        }

        .card-reason::-webkit-scrollbar-thumb:hover,
        .review-text::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Card hover effect */
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        /* Add hover effects to list items */
        .list-group-item {
            transition: all 0.2s ease;
        }

        .list-group-item:hover {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transform: translateX(5px);
        }

        /* Add focus styles for better accessibility */
        .form-control:focus,
        .btn:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Custom badge styles */
        .badge-pill {
            padding: 0.25em 0.6em;
            font-weight: 600;
        }

        /* Better styling for select elements */
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }

        /* Modal animations */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: translate(0, -50px);
        }

        .modal.show .modal-dialog {
            transform: none;
        }

        /* Button hover effects */
        .btn {
            transition: all 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* Form field focus effects */
        .form-control {
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Initialize Select2 for enhanced selects if available
    if (typeof $.fn.select2 !== 'undefined') {
        $('#status, #direction').select2({
            minimumResultsForSearch: Infinity // Hide search box for short lists
        });
        
        // Initialize select2 for the modal too
        initModalSelect2();
    }
    
    // Function to initialize select2 in modal (separate function for reuse)
    function initModalSelect2() {
        if (typeof $.fn.select2 !== 'undefined') {
            $('#reviewStatus').select2({
                dropdownParent: $('#reviewFlagModal'),
                minimumResultsForSearch: Infinity
            });
        }
    }
    
    // Toggle between card and list views
    $('[data-view]').on('click', function(e) {
        e.preventDefault();
        const viewType = $(this).data('view');
        
        // Update active state in dropdown
        $('[data-view]').removeClass('active');
        $(this).addClass('active');
        
        // Show selected view, hide the other
        if (viewType === 'card') {
            $('#card-view').show();
            $('#list-view').hide();
            localStorage.setItem('flagViewPreference', 'card');
        } else {
            $('#card-view').hide();
            $('#list-view').show();
            localStorage.setItem('flagViewPreference', 'list');
        }
    });
    
    // Load view preference from localStorage
    const viewPreference = localStorage.getItem('flagViewPreference') || 'card';
    $(`[data-view="${viewPreference}"]`).click();
    
    // Make card-reason and review-text expandable
    $('.card-reason, .review-text').on('click', function() {
        $(this).toggleClass('expanded');
        
        // Refresh tooltip text
        if ($(this).hasClass('expanded')) {
            $(this).attr('data-original-title', 'Click to collapse');
        } else {
            $(this).attr('data-original-title', 'Click to expand');
        }
        $(this).tooltip('update');
    });
    
    // Handle flag review button clicks with delegated event handling
    $(document).on('click', '.review-flag-btn', function(e) {
        // Prevent default action if the button is in a form or has href
        e.preventDefault();
        
        // Get data attributes from the button
        const flagId = $(this).data('flag-id');
        const internName = $(this).data('intern-name');
        const internId = $(this).data('intern-id');
        const mentorName = $(this).data('mentor-name');
        const flagDate = $(this).data('flag-date');
        const flagReason = $(this).data('flag-reason');
        
        console.log("Opening modal for flag:", flagId, internName);
        
        // Update modal with flag details
        $('#reviewFlagModalLabel').text('Review Flag for ' + internName);
        $('#flag-intern-name').text(internName);
        $('#flag-mentor-name').text(mentorName);
        $('#flag-date').text(flagDate);
        $('#flag-reason').text(flagReason);
        
        // Set the form action URL with the correct route
        $('#reviewFlagForm').attr('action', '/admin/flagged-interns/' + flagId + '/update-status');
        
        // Clear any previous values in the form
        $('#reviewNotes').val('');
        
        // Reset select to first option
        $('#reviewStatus').val('reviewed');
        
        // If using select2, trigger change event
        if (typeof $.fn.select2 !== 'undefined') {
            $('#reviewStatus').val('reviewed').trigger('change');
        }
        
        // Explicitly show the modal
        $('#reviewFlagModal').modal('show');
    });
    
    // Handle modal shown event - useful for focusing elements
    $('#reviewFlagModal').on('shown.bs.modal', function() {
        // Focus on the status dropdown when modal is fully shown
        $('#reviewStatus').focus();
        
        // Re-initialize select2 in case it was broken
        initModalSelect2();
        
        console.log("Modal is now visible");
    });
    
    // Handle modal hidden event - useful for cleanup
    $('#reviewFlagModal').on('hidden.bs.modal', function() {
        // Clear form data when modal is closed
        $('#reviewFlagForm').trigger('reset');
        
        // Reset any modified UI elements
        $('#reviewFlagForm').find('button[type="submit"]')
            .prop('disabled', false)
            .html('Update Status');
            
        console.log("Modal is now hidden");
    });
    
    // Add form validation and submission handling
    $('#reviewFlagForm').on('submit', function(e) {
        // Validate the form
        if (!$('#reviewStatus').val()) {
            e.preventDefault();
            alert('Please select a status');
            $('#reviewStatus').focus();
            return false;
        }
        
        if (!$('#reviewNotes').val().trim()) {
            e.preventDefault();
            alert('Please enter review notes');
            $('#reviewNotes').focus();
            return false;
        }
        
        // Show loading indicator
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        
        // We can optionally use AJAX to submit the form instead of traditional submission
        if (false) { // Set to "true" to enable AJAX submission
            e.preventDefault();
            const formData = $(this).serialize();
            const actionUrl = $(this).attr('action');
            
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Show success message
                    toastr.success('Flag status updated successfully');
                    
                    // Close the modal
                    $('#reviewFlagModal').modal('hide');
                    
                    // Reload the page after a short delay
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    // Show error message
                    let errorMsg = 'An error occurred while updating the flag status';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    toastr.error(errorMsg);
                    
                    // Reset the submit button
                    submitBtn.prop('disabled', false).html('Update Status');
                }
            });
        }
        
        // For traditional form submission, return true to allow the form to submit
        return true;
    });
    
    // Close button and cancel button handling
    $(document).on('click', '[data-dismiss="modal"], .modal .btn-secondary', function() {
        console.log("Closing modal via button click");
        $('#reviewFlagModal').modal('hide');
    });
    
    // Handle escape key to close modal
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#reviewFlagModal').hasClass('show')) {
            $('#reviewFlagModal').modal('hide');
        }
    });
    
    // Enable responsive tables
    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css("overflow", "inherit");
    });
    
    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css("overflow", "auto");
    });
    
    // Debug helper to check if modal exists
    console.log("Modal element exists:", $('#reviewFlagModal').length > 0);
    console.log("Review buttons exist:", $('.review-flag-btn').length);
    
    // In case the modal has issues, this function can repair it
    function repairModal() {
        const modalHTML = `
        <div class="modal fade" id="reviewFlagModal" tabindex="-1" role="dialog" aria-labelledby="reviewFlagModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="reviewFlagModalLabel">Review Flag</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="reviewFlagForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <h6 class="font-weight-bold mb-2">Flag Details</h6>
                                <p class="mb-1"><strong>Intern:</strong> <span id="flag-intern-name"></span></p>
                                <p class="mb-1"><strong>Flagged By:</strong> <span id="flag-mentor-name"></span></p>
                                <p class="mb-1"><strong>Date:</strong> <span id="flag-date"></span></p>
                                <p class="mb-0"><strong>Reason:</strong> <span id="flag-reason"></span></p>
                            </div>

                            <div class="form-group">
                                <label for="reviewStatus" class="font-weight-bold">Update Status</label>
                                <select class="form-control" id="reviewStatus" name="status" required>
                                    <option value="reviewed">Reviewed</option>
                                    <option value="cleared">Cleared</option>
                                    <option value="escalated">Escalated</option>
                                </select>
                                <small class="form-text text-muted">
                                    <strong>Reviewed</strong>: Acknowledge the flag without clearing or escalating<br>
                                    <strong>Cleared</strong>: No issues found, flag is resolved<br>
                                    <strong>Escalated</strong>: Serious issue requiring higher attention
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="reviewNotes" class="font-weight-bold">Review Notes</label>
                                <textarea class="form-control" id="reviewNotes" name="review_notes" rows="4" required placeholder="Describe your findings and any actions taken..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>`;
        
        // Check if modal exists
        if ($('#reviewFlagModal').length === 0) {
            // Append modal to body
            $('body').append(modalHTML);
            console.log("Modal repaired and added to the DOM");
            
            // Re-initialize select2 for the modal
            initModalSelect2();
        }
    }
    
    // Call this if you suspect modal issues
    // Uncomment if needed: repairModal();
});
</script>
@endpush
