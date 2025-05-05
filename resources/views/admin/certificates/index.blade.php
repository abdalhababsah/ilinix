@extends('dashboard-layout.app')

@section('content')
<div class="container">
  <div class="page-title-container mb-4">
    <div class="row align-items-center">
      <div class="col-md-7">
        <h1 class="display-4 text-primary fw-bold">Certificate Programs</h1>
      </div>
      <div class="col-md-5 text-md-end">
        <a href="{{ route('admin.certificate-programs.create') }}" class="btn btn-primary">
          <i data-acorn-icon="plus" class="me-2"></i> New Program
        </a>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <!-- Filters -->
  <div class="card mb-4">
    <div class="card-body">
      <form class="row g-3" method="GET" action="{{ route('admin.certificate-programs.index') }}">
        <div class="col-md-4">
          <input type="text" name="title" class="form-control" placeholder="Title" value="{{ request('title') }}">
        </div>
        <div class="col-md-3">
          <select name="provider_id" class="form-select">
            <option value="">All Providers</option>
            @foreach($providers as $p)
              <option value="{{ $p->id }}" @selected(request('provider_id')==$p->id)>{{ $p->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <select name="type" class="form-select">
            <option value="">All Types</option>
            <option value="digital"   @selected(request('type')=='digital')>Digital</option>
            <option value="classroom" @selected(request('type')=='classroom')>Classroom</option>
            <option value="hybrid"    @selected(request('type')=='hybrid')>Hybrid</option>
          </select>
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-primary">
            <i data-acorn-icon="search" class="me-1"></i> Filter
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Programs Table -->
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover mb-0 align-middle">
        <thead class="bg-light">
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Provider</th>
            <th>Type</th>
            <th>Courses</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($programs as $prog)
            <tr>
              <td>{{ $prog->id }}</td>
              <td>{{ $prog->title }}</td>
              <td>{{ $prog->provider->name }}</td>
              <td>{{ ucfirst($prog->type) }}</td>
              <td>{{ $prog->courses_count }}</td>
              <td class="text-end">
                <a href="{{ route('admin.certificate-programs.edit',$prog) }}" class="btn btn-sm btn-outline-warning">
                  <i data-acorn-icon="pen"></i>
                </a>
                <form action="{{ route('admin.certificate-programs.destroy',$prog) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Delete this program?');">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">
                    <i data-acorn-icon="bin"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">No programs found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">{{ $programs->links('vendor.pagination.bootstrap-4') }}</div>
  </div>
</div>
@endsection