
<div class="modal fade" id="createMentorModal" tabindex="-1" aria-labelledby="createMentorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="createMentorModalLabel">
          <i data-acorn-icon="plus" class="me-2"></i> Add New Mentor
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.mentors.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="create_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="create_first_name" name="first_name" required>
            </div>
            <div class="col-md-6">
              <label for="create_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="create_last_name" name="last_name" required>
            </div>
            <div class="col-md-6">
              <label for="create_email" class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="create_email" name="email" required>
            </div>
            <div class="col-md-6">
              <label for="create_password" class="form-label">Password <span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="create_password" name="password" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Mentor</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Mentor Modal -->
<div class="modal fade" id="editMentorModal" tabindex="-1" aria-labelledby="editMentorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title" id="editMentorModalLabel">
          <i data-acorn-icon="pen" class="me-2"></i> Edit Mentor
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editMentorForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="edit_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
            </div>
            <div class="col-md-6">
              <label for="edit_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
            </div>
            <div class="col-md-6">
              <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="edit_email" name="email" required>
            </div>
            <div class="col-md-6">
              <label for="edit_password" class="form-label">Password <small>(leave blank to keep current)</small></label>
              <input type="password" class="form-control" id="edit_password" name="password">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning">Update Mentor</button>
        </div>
      </form>
    </div>
  </div>
</div>
