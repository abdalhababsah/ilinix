@extends('dashboard-layout.app')

@section('content')
<div class="container">
    <div class="page-title-container mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-7">
                <h1 class="mb-0 display-4 text-primary fw-bold" id="title">Mentor Profile</h1>
                <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                    <ul class="breadcrumb pt-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.mentors.index') }}" class="text-decoration-none">Mentors</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $mentor->first_name }} {{ $mentor->last_name }}</li>
                    </ul>
                </nav>
            </div>
            <div class="col-12 col-md-5 d-flex justify-content-md-end mt-3 mt-md-0 gap-2">
                <!-- Send Email -->
                <button type="button"
                        class="btn btn-outline-primary btn-icon"
                        data-bs-toggle="modal"
                        data-bs-target="#sendEmailModal">
                    <i data-acorn-icon="email" class="me-2"></i>Send Email
                </button>
            
                <!-- Deactivate -->
                <form action="{{ route('admin.mentors.deactivate', $mentor->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to deactivate this mentor?');">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-outline-warning btn-icon">
                        <i data-acorn-icon="power-off" class="me-2"></i>Deactivate
                    </button>
                </form>
            
                <!-- Existing Delete -->
                <form action="{{ route('admin.mentors.destroy', $mentor->id) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this mentor?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-icon">
                        <i data-acorn-icon="bin" class="me-2"></i>Delete
                    </button>
                </form>
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
    <!-- Success/Error Messages -->
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
    <!-- Mentor Overview -->
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center">
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-4" style="width:80px;height:80px;">
                <span class="fs-2 text-primary">{{ strtoupper(substr($mentor->first_name,0,1)) }}{{ strtoupper(substr($mentor->last_name,0,1)) }}</span>
            </div>
            <div>
                <h4 class="mb-1">{{ $mentor->first_name }} {{ $mentor->last_name }}</h4>
                <p class="mb-1 text-muted">{{ $mentor->email }}</p>
                <p class="mb-0"><small>Joined on {{ $mentor->created_at->format('M d, Y') }}</small></p>
            </div>
        </div>
    </div>

    <!-- Interns Assigned -->
    <h5 class="mb-3">Assigned Interns ({{ $interns->total() }})</h5>

    @if($interns->count())
    <div class="row gy-4">
        @foreach($interns as $intern)
        <div class="col-sm-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">{{ $intern->first_name }} {{ $intern->last_name }}</h6>
                    <p class="card-text text-muted mb-1">{{ $intern->email }}</p>
                    <p class="card-text"><small>Status: <span class="badge bg-{{ $intern->status=='active'?'success':($intern->status=='completed'?'primary':'warning') }}">{{ ucfirst($intern->status) }}</span></small></p>
                </div>
                <div class="card-footer bg-white text-end">
                    <a href="{{ route('admin.interns.show', $intern->id) }}" class="btn btn-sm btn-outline-primary">
                        <i data-acorn-icon="eye" class="me-1"></i> View
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $interns->links('vendor.pagination.bootstrap-4') }}
    </div>
    @else
        <div class="text-center py-5 text-muted">
            <i data-acorn-icon="user" class="fs-2 mb-3"></i>
            <p>No interns assigned to this mentor yet.</p>
        </div>
    @endif

    <!-- Send Email Modal -->
<div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="sendEmailModalLabel">Email Mentor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.mentors.send-email', $mentor->id) }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="email_subject" class="form-label">Subject</label>
              <input type="text" class="form-control" id="email_subject" name="subject" required>
            </div>
            <div class="mb-3">
              <label for="email_message" class="form-label">Message</label>
              <textarea class="form-control" id="email_message" name="message" rows="6" required></textarea>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="email_copy_me" name="copy_me" value="1">
              <label class="form-check-label" for="email_copy_me">Send a copy to me</label>
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
</div>
@endsection