@extends('dashboard-layout.app')

@section('content')
<div class="container">
  <div class="page-title-container mb-4">
    <h1 class="display-4 text-primary fw-bold">Edit Certificate Program</h1>
  </div>

  <!-- Use the shared form component -->
  @include('admin.certificates.form', [
    'program' => $certificateProgram,
    'providers' => $providers,
    'courses' => $certificateProgram->courses
  ])
  
</div>
@endsection