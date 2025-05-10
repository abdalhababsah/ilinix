<!-- Nudge Inactive Intern Modal -->

<div class="modal fade" id="nudgeInternModal" tabindex="-1" aria-labelledby="nudgeInternModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-warning">

                <h5 class="modal-title" id="nudgeInternModalLabel">

                    <i data-acorn-icon="notification" class="me-2"></i>Remind {{ $intern->first_name }}

                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <form action="{{ route('mentor.interns.nudge', $intern->id) }}" method="POST">

                @csrf

                <div class="modal-body">

                    <p>This will send a friendly reminder to {{ $intern->first_name }} about their inactivity in the program.</p>

                    

                    <div class="mb-3">

                        <label for="nudge_message" class="form-label">Message</label>

                        <textarea class="form-control" id="nudge_message" name="message" rows="5" required>Hi {{ $intern->first_name }},

I noticed it's been a while since you've updated your progress in the internship program. I wanted to check in and see if you're facing any challenges or if there's anything I can help with.

Please log in to update your progress or reach out to me if you need any assistance.

Best regards,

{{ Auth::user()->first_name }}
{{ Auth::user()->email }}
</textarea>

                   </div>

                   

                   <div class="alert alert-info">

                       <i data-acorn-icon="info" class="me-2"></i>

                       <small>A nudge is recorded in the system and sends a friendly reminder email to the intern.</small>

                   </div>

               </div>

               <div class="modal-footer">

                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                   <button type="submit" class="btn btn-warning">Send Reminder</button>

               </div>

           </form>

       </div>

   </div>

</div>

<!-- Flag Inactive Intern Modal -->

<div class="modal fade" id="flagInternModal" tabindex="-1" aria-labelledby="flagInternModalLabel" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered">

       <div class="modal-content">

           <div class="modal-header bg-danger text-white">

               <h5 class="modal-title" id="flagInternModalLabel">

                   <i data-acorn-icon="flag" class="me-2"></i>Flag {{ $intern->first_name }} for Review

               </h5>

               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>

           </div>

           <form action="{{ route('mentor.interns.flag', $intern->id) }}" method="POST">

               @csrf

               <div class="modal-body">

                   <div class="alert alert-warning">

                       <i data-acorn-icon="warning-hexagon" class="me-2"></i>

                       <strong>Important:</strong> Flagging an intern will alert administrators to review their participation in the program. This should be used when multiple nudges have been unsuccessful.

                   </div>

                   

                   <div class="mb-3">

                       <label for="flag_reason" class="form-label">Reason for Flagging</label>

                       <textarea class="form-control" id="flag_reason" name="reason" rows="5" required>I am flagging {{ $intern->first_name }} due to extended inactivity in the program. Multiple attempts to reach out have been unsuccessful, and there has been no progress update for a significant period.

I recommend administrative review of their participation status.</textarea>

                   </div>

                   

                   <div class="form-check mb-3">

                       <input class="form-check-input" type="checkbox" id="send_flag_email" name="send_email" value="1">

                       <label class="form-check-label" for="send_flag_email">

                           Send notification email to intern

                       </label>

                   </div>

                   

                   <div class="alert alert-danger">

                       <i data-acorn-icon="error-hexagon" class="me-2"></i>

                       <small>This action is recorded in the system and may lead to administrative review of the intern's participation in the program.</small>

                   </div>

               </div>

               <div class="modal-footer">

                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                   <button type="submit" class="btn btn-danger">Flag Intern</button>

               </div>

           </form>

       </div>

   </div>

</div>