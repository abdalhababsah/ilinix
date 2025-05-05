<!-- form.blade.php - Reusable form for both create and edit -->
<form method="POST" 
      action="{{ isset($program) ? route('admin.certificate-programs.update', $program) : route('admin.certificate-programs.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if(isset($program))
        @method('PUT')
    @endif

    <!-- Program Details Card -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-primary bg-opacity-10 py-3">
            <h5 class="mb-0 text-white">
                <i class="bi bi-award me-2"></i>Program Information
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $program->title ?? '') }}" id="program-title" placeholder="Program Title"
                            required>
                        <label for="program-title">Program Title</label>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <select name="provider_id" class="form-select @error('provider_id') is-invalid @enderror"
                            id="provider-select" required>
                            <option value="">Select a provider...</option>
                            @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}" @selected(old('provider_id', $program->provider_id ?? '') == $provider->id)>
                                    {{ $provider->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="provider-select">Provider</label>
                        @error('provider_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                      <select name="level" 
                        id="program-level"
                        class="form-select @error('level') is-invalid @enderror" 
                        required>
                      <option value="">Select a level...</option>
                      <option value="beginner" @selected(old('level', $program->level ?? '') == 'beginner')>Beginner</option>
                      <option value="intermediate" @selected(old('level', $program->level ?? '') == 'intermediate')>Intermediate</option>
                      <option value="advanced" @selected(old('level', $program->level ?? '') == 'advanced')>Advanced</option>
                      </select>
                      <label for="program-level">Level</label>
                      @error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                  </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <select name="type" id="program-type" class="form-select @error('type') is-invalid @enderror"
                            required>
                            <option value="">Select a type...</option>
                            <option value="digital" @selected(old('type', $program->type ?? '') == 'digital')>Digital</option>
                            <option value="classroom" @selected(old('type', $program->type ?? '') == 'classroom')>Classroom</option>
                            <option value="hybrid" @selected(old('type', $program->type ?? '') == 'hybrid')>Hybrid</option>
                        </select>
                        <label for="program-type">Type</label>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="col-md-4">
                    <label class="form-label">Program Image</label>
                    <div class="image-upload-container">
                        <div class="image-preview-wrapper mb-2 text-center">
                            @if(isset($program) && $program->image_path)
                                <img src="{{ Storage::url($program->image_path) }}" 
                                     id="image-preview" 
                                     class="img-fluid rounded image-preview" 
                                     alt="{{ $program->title }} Image">
                            @else
                                <img src="{{ asset('dashboard-assets/img/placeholder-image.jpg') }}" 
                                     id="image-preview" 
                                     class="img-fluid rounded image-preview" 
                                     alt="Program Image Preview">
                            @endif
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-image"></i>
                            </span>
                            <input type="file" 
                                   id="program-image"
                                   name="image"
                                   class="form-control @error('image') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <span id="image-size-feedback" class="form-text text-danger d-none"></span>
                        <div class="form-text text-muted mt-1">
                            Supported formats: JPG, JPEG, PNG. Max size: 5MB
                        </div>
                        @if(isset($program) && $program->image_path)
                            <div class="form-text text-info mt-1">
                                <i class="bi bi-info-circle me-1"></i> Leave empty to keep the current image
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <div class="description-editor-container">
                        <div id="program-description-editor" class="quill-editor"></div>
                        <textarea name="description" id="program-description-input" class="d-none">{{ old('description', $program->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Card -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-primary bg-opacity-10 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">
                <i class="bi bi-collection me-2"></i>Courses
            </h5>
            <div>
                <span
                    class="badge bg-primary me-2 courses-counter">{{ old('courses') ? count(old('courses')) : (isset($courses) ? $courses->count() : 1) }}
                    Course(s)</span>
                <button type="button" class="btn btn-primary" id="addCourseBtn">
                    <i class="bi bi-plus-lg me-1"></i> Add Course
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="p-4 bg-light rounded-3 border-bottom d-flex align-items-center">
                <div class="form-check form-switch me-3">
                    <input class="form-check-input" type="checkbox" id="bulkCollapse">
                    <label class="form-check-label" for="bulkCollapse">Expand/Collapse All</label>
                </div>
                <div class="ms-auto">
                    <select class="form-select form-select-sm" id="sortCoursesBy">
                        <option value="order">Sort by Order</option>
                        <option value="title">Sort by Title</option>
                        <option value="duration">Sort by Duration</option>
                    </select>
                </div>
            </div>

            <div class="accordion" id="coursesContainer">
                @if (old('courses'))
                    @foreach (old('courses') as $i => $course)
                        @include('admin.certificates._course_row', ['index' => $i, 'course' => $course])
                    @endforeach
                @elseif(isset($courses) && $courses->count() > 0)
                    @foreach ($courses as $i => $course)
                        @include('admin.certificates._course_row', ['index' => $i, 'course' => $course])
                    @endforeach
                @else
                    @include('admin.certificates._course_row', ['index' => 0, 'course' => null])
                @endif
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between my-4">
        <a href="{{ route('admin.certificate-programs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
        <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-save me-1"></i> Save Program
        </button>
    </div>
</form>

<template id="course-row-template">
    <div class="accordion-item course-row border-0" data-index="__INDEX__">
        <input type="hidden" name="courses[__INDEX__][id]" value="">

        <h2 class="accordion-header" id="heading-__INDEX__">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse-__INDEX__" aria-expanded="true" aria-controls="collapse-__INDEX__">
                <div class="d-flex align-items-center course-header-content w-100">
                    <i class="bi bi-grip-vertical drag-handle"></i>
                    <span class="badge bg-primary me-2 order-badge">__INDEX__</span>
                    <span class="course-title-display text-truncate">New Course</span>
                    <span class="badge bg-secondary ms-auto duration-badge">--</span>
                </div>
            </button>
        </h2>

        <div id="collapse-__INDEX__" class="accordion-collapse collapse show" aria-labelledby="heading-__INDEX__"
            data-bs-parent="#coursesContainer">
            <div class="accordion-body p-4">
                <!-- Move remove button to the top of accordion body -->
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-course-btn">
                        <i class="bi bi-trash me-1"></i> Remove
                    </button>
                </div>

                <div class="row g-4">
                    <!-- Course Title & Step Order -->
                    <div class="col-md-8">
                        <div class="form-floating">
                            <input type="text" id="course-title-__INDEX__" name="courses[__INDEX__][title]"
                                class="form-control course-title-input" placeholder="Enter course title" required>
                            <label for="course-title-__INDEX__">Course Title</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" id="step-order-__INDEX__" name="courses[__INDEX__][step_order]"
                                class="form-control step-order-input" placeholder="Order number" value="__INDEX__">
                            <label for="step-order-__INDEX__">Step Order</label>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <div class="description-editor-container">
                            <div id="course-description-editor-__INDEX__"
                                class="quill-editor course-description-editor"></div>
                            <textarea name="courses[__INDEX__][description]" id="course-description-input-__INDEX__"
                                class="d-none course-description-input"></textarea>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-link-45deg"></i>
                            </span>
                            <div class="form-floating flex-grow-1">
                                <input type="url" id="resource-link-__INDEX__"
                                    name="courses[__INDEX__][resource_link]" class="form-control"
                                    placeholder="https://example.com">
                                <label for="resource-link-__INDEX__">Resource Link</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-display"></i>
                            </span>
                            <div class="form-floating flex-grow-1">
                                <input type="url" id="digital-link-__INDEX__"
                                    name="courses[__INDEX__][digital_link]" class="form-control"
                                    placeholder="https://example.com">
                                <label for="digital-link-__INDEX__">Digital Link</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-clock"></i>
                            </span>
                            <div class="form-floating flex-grow-1">
                                <input type="number" id="estimated-minutes-__INDEX__"
                                    name="courses[__INDEX__][estimated_minutes]" class="form-control duration-input"
                                    placeholder="Duration in minutes">
                                <label for="estimated-minutes-__INDEX__">Duration (minutes)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

@push('styles')
    <link rel="stylesheet" href="{{ asset('dashboard-assets/css/vendor/quill.snow.css') }}">
    <style>
        .accordion-button:not(.collapsed) {
            background-color: rgba(var(--primary-rgb), 0.05);
            color: var(--primary);
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(var(--primary-rgb), 0.2);
        }

        .order-badge {
            min-width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .duration-badge {
            background-color: var(--bs-gray-600);
        }

        .course-title-display {
            font-weight: 500;
            max-width: 70%;
        }

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

        #program-description-editor {
            height: 200px;
        }

        .remove-course-btn {
            opacity: 0.7;
            transition: all 0.2s ease;
        }

        .remove-course-btn:hover {
            opacity: 1;
            background-color: #dc3545;
            color: white;
        }

        .course-header-content {
            overflow: hidden;
        }

        .description-editor-container {
            border-radius: 0.375rem;
            overflow: hidden;
        }

        .course-row {
            transition: all 0.3s ease;
        }

        /* Drag and drop styling */
        .sortable-ghost {
            opacity: 0.4;
            background-color: #f8f9fa;
        }

        .sortable-chosen {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.15);
        }

        .sortable-drag {
            opacity: 0.9;
        }

        .drag-handle {
            cursor: move;
            margin-right: 10px;
            color: var(--bs-gray-600);
        }
        
        /* Image upload styling */
        .image-preview {
            max-height: 150px;
            object-fit: contain;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
            padding: 8px;
            transition: all 0.2s ease;
        }
        
        .image-upload-container {
            transition: all 0.3s ease;
        }
        
        .image-preview-wrapper {
            min-height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('dashboard-assets/js/vendor/quill.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('program-image');
            const preview = document.getElementById('image-preview');
            const feedback = document.getElementById('image-size-feedback');
            const maxSizeMB = 6;
            const maxSizeBytes = maxSizeMB * 1024 * 1024;
        
            input.addEventListener('change', function () {
                const file = this.files[0];
                feedback.classList.add('d-none');
        
                if (!file) return;
        
                const fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
        
                if (file.size > maxSizeBytes) {
                    feedback.textContent = `Selected image is ${fileSizeMB} MB — max allowed is ${maxSizeMB} MB.`;
                    feedback.classList.remove('d-none');
                    this.value = '';
                    preview.src = "{{ asset('dashboard-assets/img/placeholder-image.jpg') }}";
                } else {
                    feedback.textContent = `Selected image size: ${fileSizeMB} MB`;
                    feedback.classList.remove('d-none');
                    feedback.classList.remove('text-danger');
                    feedback.classList.add('text-success');
                }
            });

            // Initialize course index counter
            let courseIndex = document.querySelectorAll('.course-row').length;

            // Initialize container and template elements
            const container = document.getElementById('coursesContainer');
            const templateContent = document.getElementById('course-row-template').innerHTML;

            // Initialize Quill for program description
            const programEditor = new Quill('#program-description-editor', {
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
            const programDescInput = document.getElementById('program-description-input');
            if (programDescInput.value) {
                programEditor.root.innerHTML = programDescInput.value;
            }

            // Update hidden input when editor changes
            programEditor.on('text-change', function() {
                programDescInput.value = programEditor.root.innerHTML;
            });
            
            // Initialize image preview functionality
            const imageInput = document.getElementById('program-image');
            const imagePreview = document.getElementById('image-preview');
            
            if (imageInput && imagePreview) {
                imageInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.opacity = '1';
                        };
                        
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            // Initialize Quill for existing course descriptions
            initializeExistingQuillEditors();

            // Initialize Sortable for drag and drop functionality
            const sortable = new Sortable(container, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onEnd: function() {
                    updateCourseIndexes();
                }
            });

            // Add course button handler
            document.getElementById('addCourseBtn').addEventListener('click', () => {
                // Replace template placeholders with actual index
                let html = templateContent.replace(/__INDEX__/g, courseIndex);

                // Insert at the end of container
                container.insertAdjacentHTML('beforeend', html);

                // Initialize Quill for new course
                initializeQuillEditor(courseIndex);

                // Update course numbers and counter
                courseIndex++;
                updateCourseCounter();
                updateCourseIndexes();
            });

            // Remove course delegation
            container.addEventListener('click', e => {
                const removeButton = e.target.closest('.remove-course-btn');
                if (!removeButton) return;

                const courseRow = removeButton.closest('.course-row');

                // Confirm deletion
                if (confirm('Are you sure you want to remove this course?')) {
                    // Animate removal
                    courseRow.style.opacity = '0';
                    courseRow.style.transform = 'translateY(-10px)';

                    // Remove after animation
                    setTimeout(() => {
                        courseRow.remove();
                        updateCourseCounter();
                        updateCourseIndexes();
                    }, 300);
                }
            });

            // Course title change listener - delegation
            container.addEventListener('input', e => {
                if (e.target.matches('.course-title-input')) {
                    const courseRow = e.target.closest('.course-row');
                    const titleDisplay = courseRow.querySelector('.course-title-display');

                    if (titleDisplay) {
                        titleDisplay.textContent = e.target.value || 'Untitled Course';
                    }
                }

                if (e.target.matches('.duration-input')) {
                    const courseRow = e.target.closest('.course-row');
                    const durationBadge = courseRow.querySelector('.duration-badge');

                    if (durationBadge) {
                        const minutes = parseInt(e.target.value) || 0;
                        durationBadge.textContent = minutes > 0 ? `${minutes} min` : '--';
                    }
                }
            });

            // Expand/Collapse All toggle
            document.getElementById('bulkCollapse').addEventListener('change', function() {
                const accordionButtons = document.querySelectorAll('.accordion-button');
                const accordionPanels = document.querySelectorAll('.accordion-collapse');

                if (this.checked) {
                    // Expand all
                    accordionPanels.forEach(panel => {
                        panel.classList.add('show');
                    });
                    accordionButtons.forEach(button => {
                        button.classList.remove('collapsed');
                    });
                } else {
                    // Collapse all
                    accordionPanels.forEach(panel => {
                        panel.classList.remove('show');
                    });
                    accordionButtons.forEach(button => {
                        button.classList.add('collapsed');
                    });
                }
            });

            // Sort courses
            document.getElementById('sortCoursesBy').addEventListener('change', function() {
                const sortBy = this.value;
                const courseItems = Array.from(document.querySelectorAll('.course-row'));

                courseItems.sort((a, b) => {
                    if (sortBy === 'order') {
                        const orderA = parseInt(a.querySelector('.step-order-input')?.value) || 0;
                        const orderB = parseInt(b.querySelector('.step-order-input')?.value) || 0;
                        return orderA - orderB;
                    } else if (sortBy === 'title') {
                        const titleA = a.querySelector('.course-title-input')?.value || '';
                        const titleB = b.querySelector('.course-title-input')?.value || '';
                        return titleA.localeCompare(titleB);
                    } else if (sortBy === 'duration') {
                        const durationA = parseInt(a.querySelector('.duration-input')?.value) || 0;
                        const durationB = parseInt(b.querySelector('.duration-input')?.value) || 0;
                        return durationB - durationA; // Descending by duration
                    }
                    return 0;
                });

                // Reorder in the DOM
                courseItems.forEach(item => {
                    container.appendChild(item);
                });

                // Update indexes
                updateCourseIndexes();
            });

            // Initialize existing Quill editors
            function initializeExistingQuillEditors() {
                document.querySelectorAll('.course-description-editor').forEach((editor, idx) => {
                    initializeQuillEditor(idx);
                });
            }

            // Initialize Quill editor for a specific course
            function initializeQuillEditor(index) {
                const editorId = `course-description-editor-${index}`;
                const inputId = `course-description-input-${index}`;

                // Check if editor exists
                const editorElement = document.getElementById(editorId);
                if (!editorElement) return;

                // Create Quill instance
                const quill = new Quill(`#${editorId}`, {
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
                const textareaInput = document.getElementById(inputId);
                if (textareaInput && textareaInput.value) {
                    quill.root.innerHTML = textareaInput.value;
                }

                // Update hidden input when editor changes
                quill.on('text-change', function() {
                    if (textareaInput) {
                        textareaInput.value = quill.root.innerHTML;
                    }
                });

                return quill;
            }

            // Update course indexes when order changes
            function updateCourseIndexes() {
                const courses = document.querySelectorAll('.course-row');

                courses.forEach((course, idx) => {
                    // Update badge number
                    const orderBadge = course.querySelector('.order-badge');
                    if (orderBadge) {
                        orderBadge.textContent = idx + 1;
                    }

                    // Set default step order if empty
                    const stepOrderInput = course.querySelector('.step-order-input');
                    if (stepOrderInput && !stepOrderInput.value) {
                        stepOrderInput.value = idx + 1;
                    }
                });
            }

            // Update course counter badge
            function updateCourseCounter() {
                const counter = document.querySelector('.courses-counter');
                const count = document.querySelectorAll('.course-row').length;

                if (counter) {
                    counter.textContent = `${count} Course${count !== 1 ? 's' : ''}`;
                }
            }

            // Initialize course titles and duration badges on load
            document.querySelectorAll('.course-row').forEach(row => {
                const titleInput = row.querySelector('.course-title-input');
                const titleDisplay = row.querySelector('.course-title-display');
                const durationInput = row.querySelector('.duration-input');
                const durationBadge = row.querySelector('.duration-badge');

                if (titleInput && titleDisplay) {
                    titleDisplay.textContent = titleInput.value || 'Untitled Course';
                }

                if (durationInput && durationBadge) {
                    const minutes = parseInt(durationInput.value) || 0;
                    durationBadge.textContent = minutes > 0 ? `${minutes} min` : '--';
                }
            });

            // Initial update
            updateCourseIndexes();
            updateCourseCounter();
        });
    </script>
@endpush