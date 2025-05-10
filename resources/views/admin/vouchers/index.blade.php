@extends('dashboard-layout.app')

@section('content')
<div class="container">
    <!-- Page Title & Create Button -->
    <div class="page-title-container mb-4">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1 class="display-4 text-primary fw-bold">Vouchers Management</h1>
            </div>
            <div class="col-md-5 text-md-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createVoucherModal">
                    <i data-acorn-icon="plus" class="me-2"></i> Add New Voucher
                </button>
            </div>
        </div>
    </div>
    @include('components._messages')

    <!-- Filter Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3" method="GET" action="{{ route('admin.vouchers.index') }}">
                <div class="col-md-5">
                    <label class="form-label">Intern Name</label>
                    <input type="text" name="user" class="form-control" placeholder="Filter by intern name..." value="{{ request('user') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Usage Status</label>
                    <select name="used" class="form-select">
                        <option value="">All Vouchers</option>
                        <option value="1" {{ request('used') === '1' ? 'selected' : '' }}>Used</option>
                        <option value="0" {{ request('used') === '0' ? 'selected' : '' }}>Unused</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="d-grid w-100">
                        <button type="submit" class="btn btn-primary">
                            <i data-acorn-icon="search" class="me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-primary bg-opacity-10 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class=" bg-white text-primary  rounded-xl d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 3h14a2 2 0 0 1 2 2v4a2 2 0 0 1 0 4v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4a2 2 0 0 1 0-4V5a2 2 0 0 1 2-2z"></path>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                            <line x1="2" y1="14" x2="22" y2="14"></line>
                        </svg>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">Available Vouchers</h5>
                        <h3 class="display-6 fw-bold mb-0">{{ $availableVouchers }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-primary bg-opacity-10 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-white text-primary rounded-xl d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i data-acorn-icon="check" style="height: 24px; width: 24px;"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">Used Vouchers</h5>
                        <h3 class="display-6 fw-bold mb-0">{{ $usedVouchers }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vouchers Table -->
    <div class="card shadow-sm">
        <div class="card-header py-3">
            <h5 class="mb-0">Vouchers List</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0">#</th>
                        <th class="border-0">Code</th>
                        <th class="border-0">Certificate Name</th>
                        <th class="border-0">Issued To</th>
                        <th class="border-0">Issued At</th>
                        <th class="border-0">Status</th>
                        <th class="border-0 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vouchers as $voucher)
                        <tr>
                            <td>{{ $voucher->id }}</td>
                            <td>
                                <span class="fw-medium">{{ $voucher->code }}</span>
                            </td>
                            <td>{{ $voucher->provider }}</td>
                            <td>
                                @if($voucher->issuedTo)
                                    <a href="{{ route('admin.interns.show', $voucher->issuedTo->id) }}" class="text-decoration-none">
                                        {{ $voucher->issuedTo->first_name }} {{ $voucher->issuedTo->last_name }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($voucher->issued_at)
                                    @if(is_string($voucher->issued_at))
                                        {{ \Carbon\Carbon::parse($voucher->issued_at)->format('M d, Y') }}
                                    @else
                                        {{ $voucher->issued_at->format('M d, Y') }}
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($voucher->used)
                                    <span class="badge bg-success">Used</span>
                                    @if($voucher->used_at)
                                        <div class="text-muted small">
                                            @if(is_string($voucher->used_at))
                                                {{ \Carbon\Carbon::parse($voucher->used_at)->format('M d, Y') }}
                                            @else
                                                {{ $voucher->used_at->format('M d, Y') }}
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    <span class="badge bg-warning">Available</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    @if(!$voucher->used)
                                        <button class="btn btn-sm btn-outline-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editVoucherModal" 
                                            data-id="{{ $voucher->id }}"
                                            data-code="{{ $voucher->code }}"
                                            data-provider="{{ $voucher->provider }}"
                                            data-issued-to-id="{{ $voucher->issued_to_id }}"
                                            data-issued-at="{{ $voucher->issued_at ? (is_string($voucher->issued_at) ? \Carbon\Carbon::parse($voucher->issued_at)->format('Y-m-d\TH:i') : $voucher->issued_at->format('Y-m-d\TH:i')) : '' }}"
                                            data-notes="{{ $voucher->notes }}">
                                            <i data-acorn-icon="pen"></i>
                                        </button>
                                    @endif
                                    <form method="POST" action="{{ route('admin.vouchers.destroy', $voucher) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this voucher?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" {{ $voucher->used ? 'disabled' : '' }}>
                                            <i data-acorn-icon="bin"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center py-5">
                                    <i data-acorn-icon="ticket" class="text-muted mb-2" style="font-size: 2.5rem;"></i>
                                    <p class="text-muted mb-0">No vouchers found.</p>
                                    <button class="btn btn-sm btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#createVoucherModal">
                                        <i data-acorn-icon="plus" class="me-1"></i> Add New Voucher
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer border-0 pt-3">
                {{ $vouchers->withQueryString()->links('vendor.pagination.bootstrap-4') }}

        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createVoucherModal" tabindex="-1" aria-labelledby="createVoucherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.vouchers.store') }}">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createVoucherModalLabel">
                        <i data-acorn-icon="plus" class="me-2"></i> Add New Voucher
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">Voucher Code <span class="text-danger">*</span></label>
                        <input type="text" id="code" name="code" class="form-control" placeholder="Enter voucher code" required>
                    </div>
                    <div class="mb-3">
                        <label for="provider" class="form-label">Certificate Name <span class="text-danger">*</span></label>
                        <input type="text" id="provider" name="provider" class="form-control" placeholder="Enter provider name" required>
                    </div>
                    <div class="mb-3">
                        <label for="issued_to_id" class="form-label">Assign to Intern</label>
                        <select id="issued_to_id" name="issued_to_id" class="form-select">
                            <option value="">Select Intern (optional)</option>
                            @foreach($interns as $intern)
                                <option value="{{ $intern->id }}">{{ $intern->first_name }} {{ $intern->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Email notification alert and option -->
                    <div class="email-notification-container mb-3 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="send_email" name="send_email" value="1">
                            <label class="form-check-label" for="send_email">
                                Send email notification to intern
                            </label>
                        </div>
                        <div class="alert alert-info mt-2 email-notification-alert" style="display: none;">
                            <i data-acorn-icon="info" class="me-2"></i>
                            An email notification will be sent to the intern with their voucher details.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="issued_at" class="form-label">Issue Date</label>
                        <input type="datetime-local" id="issued_at" name="issued_at" class="form-control">
                        <div class="form-text">If left blank, current date and time will be used.</div>
                    </div>
                    <div class="mb-0">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Enter any additional notes"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i data-acorn-icon="save" class="me-1"></i> Save Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editVoucherModal" tabindex="-1" aria-labelledby="editVoucherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" id="editVoucherForm">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editVoucherModalLabel">
                        <i data-acorn-icon="pen" class="me-2"></i> Edit Voucher
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_code" class="form-label">Voucher Code <span class="text-danger">*</span></label>
                        <input type="text" id="edit_code" name="code" class="form-control" placeholder="Enter voucher code" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_provider" class="form-label">Certificate Name <span class="text-danger">*</span></label>
                        <input type="text" id="edit_provider" name="provider" class="form-control" placeholder="Enter provider name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_issued_to_id" class="form-label">Assign to Intern</label>
                        <select id="edit_issued_to_id" name="issued_to_id" class="form-select">
                            <option value="">Select Intern (optional)</option>
                            @foreach($interns as $intern)
                                <option value="{{ $intern->id }}">{{ $intern->first_name }} {{ $intern->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Email notification alert and option -->
                    <div class="email-notification-container mb-3 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_send_email" name="send_email" value="1">
                            <label class="form-check-label" for="edit_send_email">
                                Send email notification to intern
                            </label>
                        </div>
                        <div class="alert alert-info mt-2 email-notification-alert" style="display: none;">
                            <i data-acorn-icon="info" class="me-2"></i>
                            An email notification will be sent to the intern with their voucher details.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_issued_at" class="form-label">Issue Date</label>
                        <input type="datetime-local" id="edit_issued_at" name="issued_at" class="form-control">
                    </div>
                    <div class="mb-0">
                        <label for="edit_notes" class="form-label">Notes</label>
                        <textarea id="edit_notes" name="notes" class="form-control" rows="3" placeholder="Enter any additional notes"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i data-acorn-icon="save" class="me-1"></i> Update Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit modal data population
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const code = button.getAttribute('data-code');
            const provider = button.getAttribute('data-provider');
            const issuedToId = button.getAttribute('data-issued-to-id');
            const issuedAt = button.getAttribute('data-issued-at');
            const notes = button.getAttribute('data-notes');
            
            // Set form action URL
            const form = document.getElementById('editVoucherForm');
            form.action = `/admin/vouchers/${id}`;
            
            // Populate form fields
            document.getElementById('edit_code').value = code;
            document.getElementById('edit_provider').value = provider;
            document.getElementById('edit_issued_to_id').value = issuedToId || '';
            document.getElementById('edit_issued_at').value = issuedAt || '';
            document.getElementById('edit_notes').value = notes || '';
        });
    });
    
    // Initialize any Select2 dropdowns if available
    if (typeof $.fn.select2 !== 'undefined') {
        $('#issued_to_id, #edit_issued_to_id').select2({
            dropdownParent: $('.modal-body'),
            placeholder: 'Select an intern',
            allowClear: true
        });
    }
            // For Create Modal
            const issuedToSelect = document.getElementById('issued_to_id');
        const sendEmailCheck = document.getElementById('send_email');
        const emailAlert = document.querySelector('#createVoucherModal .email-notification-alert');
        
        // Toggle alert visibility based on selections
        function toggleCreateAlert() {
            if (issuedToSelect.value && sendEmailCheck.checked) {
                emailAlert.style.display = 'block';
            } else {
                emailAlert.style.display = 'none';
            }
        }
        
        issuedToSelect.addEventListener('change', toggleCreateAlert);
        sendEmailCheck.addEventListener('change', toggleCreateAlert);
        
        // For Edit Modal
        const editIssuedToSelect = document.getElementById('edit_issued_to_id');
        const editSendEmailCheck = document.getElementById('edit_send_email');
        const editEmailAlert = document.querySelector('#editVoucherModal .email-notification-alert');
        
        // Toggle alert visibility based on selections
        function toggleEditAlert() {
            if (editIssuedToSelect.value && editSendEmailCheck.checked) {
                editEmailAlert.style.display = 'block';
            } else {
                editEmailAlert.style.display = 'none';
            }
        }
        
        editIssuedToSelect.addEventListener('change', toggleEditAlert);
        editSendEmailCheck.addEventListener('change', toggleEditAlert);
        
        // Initialize alert visibility when the edit modal is shown
        const editModal = document.getElementById('editVoucherModal');
        editModal.addEventListener('shown.bs.modal', function() {
            toggleEditAlert();
        });
});
</script>
@endpush
@endsection