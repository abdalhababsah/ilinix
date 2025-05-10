@extends('dashboard-layout.app')

@section('content')
<div class="container">
    <!-- Page Title & Create Button -->
    <div class="page-title-container mb-4">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1 class="display-4 text-primary fw-bold">Providers Management</h1>
            </div>
            <div class="col-md-5 text-md-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProviderModal">
                    <i data-acorn-icon="plus" class="me-2"></i> Add New Provider
                </button>
            </div>
        </div>
    </div>

    @include('components._messages')

    <!-- Filter Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3" method="GET" action="{{ route('admin.providers.index') }}">
                <div class="col-md-8">
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Filter by name..."
                           value="{{ request('name') }}">
                </div>
                <div class="col-md-4 d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i data-acorn-icon="search" class="me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Active Filters -->
    @if(request('name'))
    <div class="mb-4">
        <div class="d-flex align-items-center">
            <span class="me-2">Active filters:</span>
            <div class="badge bg-primary me-2 py-2">
                Name: {{ request('name') }}
                <a href="{{ route('admin.providers.index') }}" class="text-white ms-2" style="text-decoration: none;">
                    <i data-acorn-icon="close" class="text-white" style="height: 10px; width: 10px;"></i>
                </a>
            </div>
            <a href="{{ route('admin.providers.index') }}" class="btn btn-sm btn-outline-primary">Clear all</a>
        </div>
    </div>
    @endif

    <!-- Providers Table -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Logo</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($providers as $provider)
                        <tr>
                            <td>{{ $provider->id }}</td>
                            <td>{{ $provider->name }}</td>
                            <td>
                                @if($provider->logo)
                                    <img src="{{ asset('storage/' . $provider->logo) }}"
                                         alt="Logo"
                                         style="height:40px; object-fit:contain;">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <!-- Edit -->
                                    <button type="button"
                                            class="btn btn-sm btn-outline-warning edit-provider-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editProviderModal"
                                            data-id="{{ $provider->id }}"
                                            data-name="{{ $provider->name }}"
                                            data-logo="{{ $provider->logo }}">
                                        <i data-acorn-icon="pen"></i>
                                    </button>
                                    <!-- Delete -->
                                    <form method="POST"
                                          action="{{ route('admin.providers.destroy', $provider) }}"
                                          onsubmit="return confirm('Delete this provider?');"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                            <i data-acorn-icon="bin"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                @if(request('name'))
                                    No providers found matching "{{ request('name') }}".
                                    <br>
                                    <a href="{{ route('admin.providers.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                        Clear filters
                                    </a>
                                @else
                                    No providers found.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $providers->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>

<!-- Create Provider Modal -->
<div class="modal fade" id="createProviderModal" tabindex="-1" aria-labelledby="createProviderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createProviderModalLabel">
                    <i data-acorn-icon="plus" class="me-2"></i> Add New Provider
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST"
                  action="{{ route('admin.providers.store') }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="provider_name" class="form-label">Name</label>
                        <input type="text"
                               id="provider_name"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="provider_logo" class="form-label">Logo (optional)</label>
                        <input type="file"
                               id="provider_logo"
                               name="logo"
                               class="form-control @error('logo') is-invalid @enderror"
                               accept="image/*">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Provider</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Provider Modal -->
<div class="modal fade" id="editProviderModal" tabindex="-1" aria-labelledby="editProviderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editProviderModalLabel">
                    <i data-acorn-icon="pen" class="me-2"></i> Edit Provider
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editProviderForm"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_provider_name" class="form-label">Name</label>
                        <input type="text"
                               id="edit_provider_name"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_provider_logo" class="form-label">Logo (optional)</label>
                        <input type="file"
                               id="edit_provider_logo"
                               name="logo"
                               class="form-control @error('logo') is-invalid @enderror"
                               accept="image/*">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <img id="currentProviderLogo"
                                 src=""
                                 alt="Current Logo"
                                 style="max-height:60px; object-fit:contain;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Provider</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });

    // Populate edit form
    document.querySelectorAll('.edit-provider-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id   = button.dataset.id;
            const name = button.dataset.name;
            const logo = button.dataset.logo;
            const form = document.getElementById('editProviderForm');

            form.action = `/admin/providers/${id}`;
            form.querySelector('#edit_provider_name').value = name;

            const img = document.getElementById('currentProviderLogo');
            img.src   = logo
                        ? `/storage/${logo}`
                        : '/path/to/placeholder.png';
        });
    });
});
</script>
@endpush
@endsection