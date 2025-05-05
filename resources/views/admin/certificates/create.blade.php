@extends('dashboard-layout.app')

@section('content')
<div class="container">
  <div class="page-title-container mb-4">
    <h1 class="display-4 text-primary fw-bold">New Certificate Program</h1>
  </div>

  <!-- Use the shared form component -->
  @include('admin.certificates.form', [
    'program' => null,
    'providers' => $providers,
    'courses' => null
  ])
  
</div>
@endsection