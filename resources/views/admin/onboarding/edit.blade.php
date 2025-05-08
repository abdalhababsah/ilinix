@extends('dashboard-layout.app')

@section('content')
    <div class="container">
        <div class="page-title-container mb-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-7">
                    <h1 class="mb-0 pb-0 display-4 text-primary fw-bold" id="title">Edit Onboarding Step</h1>
                    <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                    class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.onboarding.index') }}"
                                    class="text-decoration-none">Onboarding Steps</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Step</li>
                        </ul>
                    </nav>
                </div>
                <div class="col-12 col-md-5 d-flex align-items-center justify-content-md-end mt-3 mt-md-0 gap-2">
                    <a href="{{ route('admin.onboarding.index') }}" class="btn btn-outline-primary">
                        <i data-acorn-icon="arrow-left" class="me-2"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0">Edit Step</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.onboarding.update', $step->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="title" class="form-label">Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ old('title', $step->title) }}" required>
                                    <div class="form-text">The title of the onboarding step.</div>
                                </div>
                                <div class="col-md-4">
                                    <label for="step_order" class="form-label">Order</label>
                                    <input type="number" class="form-control" id="step_order" name="step_order"
                                        value="{{ old('step_order', $step->step_order) }}" min="1">
                                    <div class="form-text">Change the position of this step in the sequence.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <div class="description-editor-container">
                                    <div id="description-editor" class="quill-editor"></div>
                                    <textarea class="form-control d-none" id="description-input" name="description" rows="4">{{ old('description', $step->description) }}</textarea>
                                </div>
                                <div class="form-text">Provide a detailed explanation of what this step involves.</div>
                            </div>

                            <div class="mb-3">
                                <label for="resource_file" class="form-label">Resource File</label>

                                @if ($step->resource_link)
                                    <div class="mb-2 border rounded p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Current File:</strong>
                                                <a href="{{ asset('storage/' . $step->resource_link) }}" target="_blank"
                                                    class="ms-2">
                                                    {{ basename($step->resource_link) }}
                                                </a>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remove_resource"
                                                    name="remove_resource" value="1">
                                                <label class="form-check-label" for="remove_resource">
                                                    Remove current file
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <input type="file" class="form-control" id="resource_file" name="resource_file">
                                <div class="form-text">Upload a new resource file to replace the current one. Max size:
                                    10MB.</div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i data-acorn-icon="save" class="me-1"></i> Update Step
                                </button>
                                <a href="{{ route('admin.onboarding.index') }}"
                                    class="btn btn-outline-secondary ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="{{ asset('dashboard-assets/css/vendor/quill.snow.css') }}">
    <style>
        .quill-editor {
            height: 150px;
            border-radius: 0.375rem;
        }
    
        .ql-container {
            border-bottom-left-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }
    
        .ql-toolbar {
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
        }
    
        .description-editor-container {
            border-radius: 0.375rem;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }
    </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('dashboard-assets/js/vendor/quill.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Toggle resource file input based on remove checkbox
                const removeCheckbox = document.getElementById('remove_resource');
                const resourceFileInput = document.getElementById('resource_file');

                if (removeCheckbox && resourceFileInput) {
                    removeCheckbox.addEventListener('change', function() {
                        if (this.checked) {
                            resourceFileInput.disabled = true;
                            resourceFileInput.value = '';
                        } else {
                            resourceFileInput.disabled = false;
                        }
                    });
                }
            });



            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Quill editor for the description
                const descriptionEditor = new Quill('#description-editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });

                // Set initial content if available
                const descriptionInput = document.getElementById('description-input');
                if (descriptionInput.value) {
                    descriptionEditor.root.innerHTML = descriptionInput.value;
                }

                // Update hidden textarea when editor changes
                descriptionEditor.on('text-change', function() {
                    descriptionInput.value = descriptionEditor.root.innerHTML;
                });
            });
        </script>
    @endpush
@endsection
