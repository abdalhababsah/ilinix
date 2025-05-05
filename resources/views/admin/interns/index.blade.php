@extends('dashboard-layout.app')

@section('content')
    <div class="container">
        <div class="page-title-container mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1 class="mb-0 pb-0 display-4 text-primary fw-bold" id="title">Interns Management</h1>
                    <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                    class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Interns</li>
                        </ul>
                    </nav>
                </div>
                <div class="col-12 col-md-5 d-flex align-items-center justify-content-md-end mt-3 mt-md-0 gap-2">
                    <button type="button" class="btn btn-outline-primary btn-icon" data-bs-toggle="modal"
                        data-bs-target="#importModal">
                        <i data-acorn-icon="upload" class="me-2"></i>Import
                    </button>
                    <button type="button" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                        data-bs-target="#addInternModal">
                        <i data-acorn-icon="plus" class="me-2"></i>Add New Intern
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

        <!-- Stats Cards -->
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle  bg-opacity-10 p-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-primary">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Total Interns</h6>
                            <h3 class="card-title mb-0">{{ $totalInterns ?? count($interns) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle  bg-opacity-10 p-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-success">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Active Interns</h6>
                            <h3 class="card-title mb-0">{{ $activeInterns ?? '--' }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-opacity-10 p-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-warning">
                                <polygon
                                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                </polygon>
                            </svg>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Average Rating</h6>
                            <h3 class="card-title mb-0">{{ $averageRating ?? '4.5' }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle  bg-opacity-10 p-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-info">
                                <path d="M12 15l8.385-8.415a2.1 2.1 0 0 0-2.97-2.97L8.5 12.5"></path>
                                <path d="M16 9l-1.5-1.5"></path>
                                <path d="M20 14v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h3"></path>
                                <path d="M14 21l-2 2-2-2"></path>
                            </svg>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Completed Program</h6>
                            <h3 class="card-title mb-0">{{ $completedInterns ?? '--' }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <h5 class="card-title">
                    <i data-acorn-icon="filter" class="me-2"></i>Filter Interns
                </h5>
                <form method="GET" action="{{ route('admin.interns.index') }}" class="mt-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="first_name" class="form-label fw-medium">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i data-acorn-icon="user" class="text-muted"></i>
                                </span>
                                <input type="text" name="first_name" id="first_name"
                                    class="form-control border-start-0" value="{{ request('first_name') }}"
                                    placeholder="Search first name...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="last_name" class="form-label fw-medium">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i data-acorn-icon="user" class="text-muted"></i>
                                </span>
                                <input type="text" name="last_name" id="last_name"
                                    class="form-control border-start-0" value="{{ request('last_name') }}"
                                    placeholder="Search last name...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="email" class="form-label fw-medium">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i data-acorn-icon="email" class="text-muted"></i>
                                </span>
                                <input type="text" name="email" id="email" class="form-control border-start-0"
                                    value="{{ request('email') }}" placeholder="Search email...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i data-acorn-icon="search" class="me-1"></i> Filter
                                </button>
                                <a href="{{ route('admin.interns.index') }}" class="btn btn-outline-secondary">
                                    <i data-acorn-icon="close" class="me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Interns Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3 ps-4">#</th>
                                <th class="py-3">
                                    <a href="{{ route('admin.interns.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'first_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}"
                                        class="text-decoration-none text-dark">
                                        First Name
                                        @if (request('sort') == 'first_name')
                                            <i data-acorn-icon="{{ request('direction') == 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="ms-1"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3">
                                    <a href="{{ route('admin.interns.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'last_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}"
                                        class="text-decoration-none text-dark">
                                        Last Name
                                        @if (request('sort') == 'last_name')
                                            <i data-acorn-icon="{{ request('direction') == 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="ms-1"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3">
                                    <a href="{{ route('admin.interns.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'email', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}"
                                        class="text-decoration-none text-dark">
                                        Email
                                        @if (request('sort') == 'email')
                                            <i data-acorn-icon="{{ request('direction') == 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                class="ms-1"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 pe-4 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($interns as $intern)
                                <tr>
                                    <td class="py-3 ps-4">{{ $intern->id }}</td>
                                    <td class="py-3">{{ $intern->first_name }}</td>
                                    <td class="py-3">{{ $intern->last_name }}</td>
                                    <td class="py-3">{{ $intern->email }}</td>
                                    <td class="py-3 pe-4 text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.interns.show', $intern->id) }}"
                                                class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                title="View Details">
                                                <i data-acorn-icon="eye"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="btn btn-sm btn-outline-warning edit-intern-btn"
                                                data-id="{{ $intern->id }}"
                                                data-first-name="{{ $intern->first_name }}"
                                                data-last-name="{{ $intern->last_name }}"
                                                data-email="{{ $intern->email }}"
                                                data-status="{{ $intern->status ?? 'active' }}"
                                           
                                                data-mentor="{{ $intern->assigned_mentor_id ?? '' }}"
                                                data-bs-toggle="tooltip" title="Edit Intern">
                                                <i data-acorn-icon="pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $intern->id }}"
                                                title="Delete Intern">
                                                <i data-acorn-icon="bin"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteModal{{ $intern->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $intern->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $intern->id }}">
                                                            <i data-acorn-icon="warning-hexagon"
                                                                class="me-2"></i>Confirm Deletion
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <p>Are you sure you want to delete
                                                            <strong>{{ $intern->first_name }}
                                                                {{ $intern->last_name }}</strong>?
                                                        </p>
                                                        <p class="text-danger mb-0"><small><i
                                                                    data-acorn-icon="warning-hexagon" class="me-1"></i>
                                                                This action cannot be undone.</small></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('admin.interns.destroy', $intern->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i data-acorn-icon="search" class="fs-1 text-secondary mb-3"></i>
                                            <p class="text-muted mb-0">No interns found matching your criteria.</p>
                                            <div class="mt-3 d-flex gap-2">
                                                <a href="{{ route('admin.interns.create') }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i data-acorn-icon="plus" class="me-2"></i> Add Intern
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#importModal">
                                                    <i data-acorn-icon="upload"></i> Import Interns
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            {{ $interns->links('vendor.pagination.bootstrap-4') }}
                        </div>
                        <div class="col-md-6">
                            @if (count($interns) > 0)
                                <div class="d-flex justify-content-md-end align-items-center mt-3 mt-md-0">
                                    <p class="mb-0 text-muted me-3">
                                        <small>Showing {{ $interns->firstItem() ?? 0 }} to {{ $interns->lastItem() ?? 0 }}
                                            of {{ $interns->total() }} entries</small>
                                    </p>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.interns.export', request()->all()) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i data-acorn-icon="download" class="me-1"></i> Export
                                        </a>
                                        <a href="{{ route('admin.interns.print', request()->all()) }}"
                                            class="btn btn-sm btn-outline-secondary" target="_blank">
                                            <i data-acorn-icon="print"></i> Print
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="importModalLabel">
                        <i data-acorn-icon="upload" class="me-2"></i>Import Interns
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.interns.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-4">
                            <p>Upload an Excel file containing intern data. The file should have the following columns:</p>
                            <div class="alert alert-info">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i data-acorn-icon="info" class="fs-4"></i>
                                    </div>
                                    <div>
                                        <strong>Required columns:</strong>
                                        <ul class="mb-0 ps-3 mt-1">
                                            <li>first_name</li>
                                            <li>last_name</li>
                                            <li>email</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">Select Excel File</label>
                            <input type="file" name="file" id="file" class="form-control"
                                accept=".xlsx, .xls, .csv" required>
                            <div class="form-text">Accepted formats: .xlsx, .xls, .csv</div>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="hasHeaders" name="has_headers" checked>
                            <label class="form-check-label" for="hasHeaders">
                                File has headers
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.interns.template') }}" class="btn btn-outline-secondary me-auto">
                            <i data-acorn-icon="download" class="me-1"></i> Download Template
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i data-acorn-icon="upload" class="me-1"></i> Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('admin.interns.add-intern-modal')
    @include('admin.interns.edit-intern-modal')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize tooltips
                initTooltips();

                // Setup auto-dismissing alerts
                setupAlertDismissal();

                // Setup password toggles
                setupPasswordToggles();

                // Setup edit intern modal functionality
                setupEditInternModal();

                // Initialize Select2 if available
                initializeSelect2();
            });

            /**
             * Initialize Bootstrap tooltips
             */
            function initTooltips() {
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                if (tooltipTriggerList.length > 0) {
                    tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
                }
            }

            /**
             * Set up auto-dismissing alerts after 5 seconds
             */
            function setupAlertDismissal() {
                setTimeout(function() {
                    const alerts = document.querySelectorAll('.alert.alert-dismissible');
                    alerts.forEach(function(alert) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    });
                }, 5000);
            }

            /**
             * Set up password visibility toggles
             */
            function setupPasswordToggles() {
                // Add intern password toggle
                setupPasswordToggle('togglePassword', 'password', 'data-acorn-icon');

                // Edit intern password toggle
                setupPasswordToggle('toggleEditPassword', 'edit_password', 'class');
            }

            /**
             * Helper function to setup password toggle functionality
             * 
             * @param {string} toggleId ID of the toggle button
             * @param {string} inputId ID of the password input
             * @param {string} iconType Type of icon attribute ('class' or 'data-acorn-icon')
             */
            function setupPasswordToggle(toggleId, inputId, iconType) {
                const toggleBtn = document.getElementById(toggleId);
                const passwordInput = document.getElementById(inputId);

                if (toggleBtn && passwordInput) {
                    toggleBtn.addEventListener('click', function() {
                        // Toggle input type
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);

                        // Toggle icon
                        const icon = this.querySelector('i');
                        if (icon) {
                            if (iconType === 'class') {
                                icon.classList.toggle('bi-eye');
                                icon.classList.toggle('bi-eye-slash');
                            } else if (iconType === 'data-acorn-icon') {
                                const currentIcon = icon.getAttribute('data-acorn-icon');
                                icon.setAttribute('data-acorn-icon', currentIcon === 'eye' ? 'eye-off' : 'eye');
                            }
                        }
                    });
                }
            }

            /**
             * Setup edit intern modal functionality
             */
            function setupEditInternModal() {
                const editButtons = document.querySelectorAll('.edit-intern-btn');
                const editModal = document.getElementById('editInternModal');
                const editForm = document.getElementById('editInternForm');

                if (editButtons.length > 0 && editModal && editForm) {
                    editButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            // Get intern data from data attributes
                            const internId = this.dataset.id;
                            const formFields = [{
                                    field: 'firstName',
                                    id: 'edit_first_name'
                                },
                                {
                                    field: 'lastName',
                                    id: 'edit_last_name'
                                },
                                {
                                    field: 'email',
                                    id: 'edit_email'
                                },
                                {
                                    field: 'status',
                                    id: 'edit_status'
                                },
                              
                                {
                                    field: 'mentor',
                                    id: 'edit_assigned_mentor_id'
                                }
                            ];
                            // Set the form action URL
                            editForm.action = `/admin/interns/${internId}`;

                            // Populate form fields
                            formFields.forEach(({
                                field,
                                id
                            }) => {
                                const value = this.dataset[field];
                                const inputElement = document.getElementById(id);
                                if (inputElement && value !== undefined) {
                                    inputElement.value = value;
                                }
                            });

                            // Clear password field
                            if (document.getElementById('edit_password')) {
                                document.getElementById('edit_password').value = '';
                            }

                            // Update Select2 if available and mentor field exists
                            const mentorDropdown = document.getElementById('edit_assigned_mentor_id');
                            if (mentorDropdown && typeof $.fn.select2 !== 'undefined') {
                                $(mentorDropdown).trigger('change');
                            }

                            // Show the modal
                            const bsModal = new bootstrap.Modal(editModal);
                            bsModal.show();
                        });
                    });
                }
            }

            /**
             * Initialize Select2 for dropdowns if available
             */
            function initializeSelect2() {
                if (typeof $.fn.select2 !== 'undefined') {
                    // Add intern modal
                    $('#assigned_mentor_id').select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $('#addInternModal'),
                        placeholder: 'Select a mentor',
                        allowClear: true
                    });

                    // Edit intern modal
                    $('#edit_assigned_mentor_id').select2({
                        theme: 'bootstrap-5',
                        dropdownParent: $('#editInternModal'),
                        placeholder: 'Select a mentor',
                        allowClear: true
                    });
                }
            }
        </script>
    @endpush
@endsection
