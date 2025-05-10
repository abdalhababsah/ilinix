@extends('dashboard-layout.app')

@section('content')
    <div class="container">
        <div class="page-title-container mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1 class="mb-0 display-4 text-primary fw-bold" id="title">Mentors Management</h1>
                    <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                    class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Mentors</li>
                        </ul>
                    </nav>
                </div>
                <div class="col-12 col-md-5 d-flex justify-content-md-end mt-3 mt-md-0">
                    <button type="button" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                        data-bs-target="#createMentorModal">
                        <i data-acorn-icon="plus" class="me-2"></i> Add New Mentor
                    </button>
                </div>
            </div>
        </div>
        @include('components._messages')

        <!-- Filter Bar -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title"><i data-acorn-icon="filter" class="me-2"></i>Filter Mentors</h5>
                <form method="GET" action="{{ route('admin.mentors.index') }}" class="row g-3 align-items-end mt-2">
                    <div class="col-md-3">
                        <label for="first_name" class="form-label fw-medium">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control"
                            value="{{ request('first_name') }}" placeholder="Search first name...">
                    </div>
                    <div class="col-md-3">
                        <label for="last_name" class="form-label fw-medium">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control"
                            value="{{ request('last_name') }}" placeholder="Search last name...">
                    </div>
                    <div class="col-md-3">
                        <label for="email" class="form-label fw-medium">Email</label>
                        <input type="text" name="email" id="email" class="form-control"
                            value="{{ request('email') }}" placeholder="Search email...">
                    </div>
                    <div class="col-md-3 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i data-acorn-icon="search" class="me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.mentors.index') }}" class="btn btn-outline-secondary mt-2">
                            <i data-acorn-icon="close" class="me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mentors Table -->
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mentors as $mentor)
                            <tr>
                                <td>{{ $mentor->id }}</td>
                                <td>{{ $mentor->first_name }}</td>
                                <td>{{ $mentor->last_name }}</td>
                                <td>{{ $mentor->email }}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.mentors.show', $mentor->id) }}"
                                            class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View">
                                            <i data-acorn-icon="eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-warning edit-mentor-btn"
                                            data-bs-toggle="modal" data-bs-target="#editMentorModal"
                                            data-id="{{ $mentor->id }}" data-first-name="{{ $mentor->first_name }}"
                                            data-last-name="{{ $mentor->last_name }}" data-email="{{ $mentor->email }}">
                                            <i data-acorn-icon="pen"></i>
                                        </button>
                                        <form action="{{ route('admin.mentors.destroy', $mentor->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this mentor?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="tooltip" title="Delete">
                                                <i data-acorn-icon="bin"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No mentors found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0 text-muted"><small>Showing {{ $mentors->firstItem() ?? 0 }} to
                                {{ $mentors->lastItem() ?? 0 }} of {{ $mentors->total() }} entries</small></p>
                    </div>
                    <div>
                        {{ $mentors->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.mentors.create-and-edit-madals')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tooltipList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipList.forEach(function(tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
            document.querySelectorAll('.edit-mentor-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    const first = btn.dataset.firstName;
                    const last = btn.dataset.lastName;
                    const email = btn.dataset.email;
                    const form = document.getElementById('editMentorForm');

                    form.action = `/admin/mentors/${id}`;
                    form.querySelector('#edit_first_name').value = first;
                    form.querySelector('#edit_last_name').value = last;
                    form.querySelector('#edit_email').value = email;
                    form.querySelector('#edit_password').value = '';
                });
            });
        </script>
    @endpush
@endsection
