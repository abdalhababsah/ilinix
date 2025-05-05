@php
    // Determine if $course is array (old input) or model
    $get = fn($key) => old("courses.{$index}.{$key}", data_get($course, $key));
@endphp

<div class="accordion-item course-row border-0" data-index="{{ $index }}">
  <input type="hidden" name="courses[{{ $index }}][id]" value="{{ $get('id') }}">
  
  <h2 class="accordion-header" id="heading-{{ $index }}">
    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
            data-bs-target="#collapse-{{ $index }}" aria-expanded="true" 
            aria-controls="collapse-{{ $index }}">
      <div class="d-flex align-items-center course-header-content w-100">
        <i class="bi bi-grip-vertical drag-handle"></i>
        <span class="badge bg-primary me-2 order-badge">{{ $index + 1 }}</span>
        <span class="course-title-display text-truncate">{{ $get('title') ?: 'Untitled Course' }}</span>
        <span class="badge bg-secondary ms-auto me-2 duration-badge">
          {{ $get('estimated_minutes') ? $get('estimated_minutes') . ' min' : '--' }}
        </span>
        <span role="button"
              class="btn btn-sm btn-outline-danger remove-course-btn d-flex align-items-center justify-content-center">
          <i data-acorn-icon="bin" class=" me-1"></i> 
          <span class="text-small">Remove</span>
        </span>
      </div>
    </button>
  </h2>
  
  <div id="collapse-{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
        aria-labelledby="heading-{{ $index }}" data-bs-parent="#coursesContainer">
    <div class="accordion-body p-4">
      <div class="row g-4">
        <!-- Course Title & Step Order -->
        <div class="col-md-8">
          <div class="form-floating">
            <input type="text"
                  id="course-title-{{ $index }}"
                  name="courses[{{ $index }}][title]"
                  class="form-control course-title-input @error("courses.{$index}.title") is-invalid @enderror"
                  value="{{ $get('title') }}"
                  placeholder="Enter course title"
                  required>
            <label for="course-title-{{ $index }}">Course Title</label>
            @error("courses.{$index}.title")
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="form-floating">
            <input type="number"
                  id="step-order-{{ $index }}"
                  name="courses[{{ $index }}][step_order]"
                  class="form-control step-order-input @error("courses.{$index}.step_order") is-invalid @enderror"
                  value="{{ $get('step_order') ?: ($index + 1) }}"
                  placeholder="Order number">
            <label for="step-order-{{ $index }}">Step Order</label>
            @error("courses.{$index}.step_order")
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <!-- Description -->
        <div class="col-12">
          <label class="form-label">Description</label>
          <div class="description-editor-container">
            <div id="course-description-editor-{{ $index }}" class="quill-editor course-description-editor"></div>
            <textarea name="courses[{{ $index }}][description]" 
                    id="course-description-input-{{ $index }}" 
                    class="d-none course-description-input">{{ $get('description') }}</textarea>
            @error("courses.{$index}.description")
              <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <!-- Additional Details -->
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text bg-light">
                <i data-acorn-icon="link"></i>
            </span>
            <div class="form-floating flex-grow-1">
              <input type="url"
                    id="resource-link-{{ $index }}"
                    name="courses[{{ $index }}][resource_link]"
                    class="form-control @error("courses.{$index}.resource_link") is-invalid @enderror"
                    value="{{ $get('resource_link') }}"
                    placeholder="https://example.com">
              <label for="resource-link-{{ $index }}">Resource Link</label>
              @error("courses.{$index}.resource_link")
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text bg-light">
              <i data-acorn-icon="link"></i>
            </span>
            <div class="form-floating flex-grow-1">
              <input type="url"
                    id="digital-link-{{ $index }}"
                    name="courses[{{ $index }}][digital_link]"
                    class="form-control @error("courses.{$index}.digital_link") is-invalid @enderror"
                    value="{{ $get('digital_link') }}"
                    placeholder="https://example.com">
              <label for="digital-link-{{ $index }}">Digital Link</label>
              @error("courses.{$index}.digital_link")
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text bg-light">
                <i data-acorn-icon="clock"></i>
            </span>
            <div class="form-floating flex-grow-1">
              <input type="number"
                    id="estimated-minutes-{{ $index }}"
                    name="courses[{{ $index }}][estimated_minutes]"
                    class="form-control duration-input @error("courses.{$index}.estimated_minutes") is-invalid @enderror"
                    value="{{ $get('estimated_minutes') }}"
                    placeholder="Duration in minutes">
              <label for="estimated-minutes-{{ $index }}">Duration (minutes)</label>
              @error("courses.{$index}.estimated_minutes")
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>