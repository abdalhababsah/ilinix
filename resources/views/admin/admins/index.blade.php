@extends('dashboard-layout.app')

@section('content')
<div class="container">
  <!-- Page Title -->
  <div class="page-title-container mb-4">
    <div class="row align-items-center">
      <div class="col-md-7">
        <h1 class="display-4 text-primary fw-bold">Admins Management</h1>
      </div>
      <div class="col-md-5 text-md-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAdminModal">
          <i data-acorn-icon="plus" class="me-2"></i> Add New Admin
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

  <!-- Filter Bar -->
  <div class="card mb-4">
    <div class="card-body">
      <form class="row g-3" method="GET" action="{{ route('admin.admins.index') }}">
        <div class="col-md-5">
          <input type="text" name="name" class="form-control" placeholder="Name" value="{{ request('name') }}">
        </div>
        <div class="col-md-5">
          <input type="email" name="email" class="form-control" placeholder="Email" value="{{ request('email') }}">
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-primary"><i data-acorn-icon="search" class="me-1"></i>Filter</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Admins Table -->
  <div class="card">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th>#</th><th>Name</th><th>Email</th><th>Joined</th><th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($admins as $admin)
          <tr>
            <td>{{ $admin->id }}</td>
            <td>{{ $admin->first_name }} {{ $admin->last_name }}</td>
            <td>{{ $admin->email }}</td>
            <td>{{ $admin->created_at->format('M d, Y') }}</td>
            <td class="text-end">
                <form action="{{ route('admin.admins.destroy', $admin->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this admin?');"
                      class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete">
                    <i data-acorn-icon="bin"></i>
                  </button>
                </form>
              </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center text-muted py-4">No admins found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      {{ $admins->links('vendor.pagination.bootstrap-4') }}
    </div>
  </div>
</div>

<!-- Create Admin Modal -->
<div class="modal fade" id="createAdminModal" tabindex="-1" aria-labelledby="createAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="createAdminModalLabel">
          <i data-acorn-icon="plus" class="me-2"></i> Add New Admin
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('admin.admins.store') }}">
        @csrf

        <div class="modal-body">

          <div class="row g-3">
            <div class="col-md-6">
              <label>First Name</label>
              <input type="text" name="first_name"
                     class="form-control @error('first_name') is-invalid @enderror"
                     value="{{ old('first_name') }}" required>
              @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6">
              <label>Last Name</label>
              <input type="text" name="last_name"
                     class="form-control @error('last_name') is-invalid @enderror"
                     value="{{ old('last_name') }}" required>
              @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6">
              <label>Email</label>
              <input type="email" name="email"
                     class="form-control @error('email') is-invalid @enderror"
                     value="{{ old('email') }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6">
              <label>Password</label>
              <input type="password" name="password"
                     class="form-control @error('password') is-invalid @enderror"
                     required>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Admin</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection