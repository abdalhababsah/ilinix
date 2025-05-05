<!-- Add Intern Modal -->
<div class="modal fade" id="addInternModal" tabindex="-1" aria-labelledby="addInternModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addInternModalLabel">
                    <i data-acorn-icon="plus" class="me-2"></i>Add New Intern
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.interns.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" value="default123" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i data-acorn-icon="eye"></i>
                                </button>
                            </div>
                            <div class="form-text">Default password: default123</div>
                        </div>
                        <div class="col-md-6">
                            <label for="assigned_mentor_id" class="form-label">Assigned Mentor</label>
                            <select class="form-select" id="assigned_mentor_id" name="assigned_mentor_id">
                                <option value="">None</option>
                                @foreach($mentors ?? [] as $mentor)
                                    <option value="{{ $mentor->id }}">{{ $mentor->first_name }} {{ $mentor->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr>
                    <div class="alert alert-info">
                        <i data-acorn-icon="info" class="me-2"></i>
                        The intern will receive a welcome email with login instructions.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i data-acorn-icon="plus" class="me-1"></i> Create Intern
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>