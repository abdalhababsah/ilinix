<?php

namespace App\Http\Controllers\Admin;
use App\Mail\InternEmail;
use App\Mail\InternEmailCopy;
use App\Mail\InternMentorChangedNotification;
use App\Mail\MentorAssignedNotification;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InternsExport;
use App\Imports\InternsImport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Mail;


class AdminInternsController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->where('role_id', 3);

        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', '%' . $request->first_name . '%');
        }

        if ($request->filled('last_name')) {
            $query->where('last_name', 'like', '%' . $request->last_name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Sorting logic
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');
        $query->orderBy($sort, $direction);

        // Get additional stats for dashboard
        $totalInterns = User::where('role_id', 3)->count();
        $activeInterns = User::where('role_id', 3)->where('status', 'active')->count();
        $completedInterns = User::where('role_id', 3)->where('status', 'completed')->count();

        // Get mentors for dropdown
        $mentors = User::where('role_id', 2)->orderBy('first_name')->get();

        $interns = $query->paginate(10)->appends($request->all());

        return view('admin.interns.index', compact('interns', 'totalInterns', 'activeInterns', 'completedInterns', 'mentors'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'status' => 'required|string|in:active,inactive,completed',
            'assigned_mentor_id' => 'nullable|exists:users,id',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role_id'] = 3;

        User::create($validated);

        return redirect()->route('admin.interns.index')->with('success', 'Intern created successfully.');
    }

    public function show($id)
    {
        $intern = User::with([
            'certificates.certificate.provider',
            'certificates.progress', // This will get the certificate progress records
            'progressUpdates.course', // This will get the course progress records
            'progressUpdates.certificate', // Get the certificate for each progress update
            'onboardingSteps.step',
            'mentor',
            'role',
        ])->findOrFail($id);

        // Ensure the user is an intern (role_id = 3)
        if ($intern->role_id !== 3) {
            return redirect()->route('admin.interns.index')
                             ->with('error', 'User is not an intern.');
        }
    
        $mentors = User::where('role_id', 2)->get();
    
        return view('admin.interns.show', compact('intern', 'mentors'));
    }

    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {
        $intern = User::findOrFail($id);

        if ($request->input('update_type') === 'mentor_only') {
            // 1) Validate only the mentor field
            $validated = $request->validate([
                'assigned_mentor_id' => 'nullable|exists:users,id',
                'notify_mentor' => 'sometimes|boolean',
                'notify_intern' => 'sometimes|boolean',
            ]);

            // 2) Update the assignment
            $intern->assigned_mentor_id = $validated['assigned_mentor_id'];
            $intern->save();

            // 3) Optionally notify the new mentor
            if ($request->boolean('notify_mentor') && $intern->mentor) {
                Mail::to($intern->mentor->email)
                    ->send(new MentorAssignedNotification($intern));
            }

            // 4) Optionally notify the intern
            if ($request->boolean('notify_intern')) {
                Mail::to($intern->email)
                    ->send(new InternMentorChangedNotification($intern));
            }

            return redirect()
                ->route('admin.interns.show', $intern->id)
                ->with('success', 'Mentor updated successfully.');
        }

        // otherwise the full profile update...
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'assigned_mentor_id' => 'nullable|exists:users,id',
        ]);
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        }
        $intern->update($validated);

        return redirect()->route('admin.interns.index')->with('success', 'Intern updated successfully.');
    }

    public function destroy($id)
    {
        $intern = User::findOrFail($id);
        $intern->delete();

        return redirect()->route('admin.interns.index')->with('success', 'Intern deleted successfully.');
    }

    public function export(Request $request)
    {
        return Excel::download(new InternsExport($request), 'interns.xlsx');
    }

    public function print(Request $request)
    {
        $query = User::where('role_id', 3);

        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', '%' . $request->first_name . '%');
        }
        if ($request->filled('last_name')) {
            $query->where('last_name', 'like', '%' . $request->last_name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $interns = $query->orderBy('id', 'desc')->get();

        return view('admin.interns.print', compact('interns'));
    }

    /**
     * Import interns from an Excel file
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'has_headers' => 'sometimes|boolean'
        ]);

        try {
            $import = new InternsImport();
            Excel::import($import, $request->file('file'));

            $successCount = count($import->rows());
            $failureCount = count($import->failures());

            if ($failureCount > 0) {
                return redirect()->route('admin.interns.index')
                    ->with('warning', "$successCount interns imported successfully with $failureCount failures. Please check the data and try again.");
            }

            return redirect()->route('admin.interns.index')
                ->with('success', "$successCount interns imported successfully!");
        } catch (\Exception $e) {
            return redirect()->route('admin.interns.index')
                ->with('error', 'Error importing interns: ' . $e->getMessage());
        }
    }

    /**
     * Download an import template file
     */
    public function template()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="interns_import_template.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['first_name', 'last_name', 'email']);
            fputcsv($file, ['John', 'Doe', 'john.doe@example.com']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get intern data for modals via AJAX
     */
    public function getInternData($id)
    {
        $intern = User::with([
            'certificates.certificate.provider',
            'certificates.progress',
        ])->findOrFail($id);

        // Format data for response
        $certificates = $intern->certificates->map(function ($certificate) {
            return [
                'id' => $certificate->id,
                'certificate_id' => $certificate->certificate_id,
                'certificate_name' => $certificate->certificate->name ?? 'Unknown Certificate',
                'provider_name' => $certificate->certificate->provider->name ?? 'Unknown Provider',
                'started_at' => $certificate->started_at ? date('Y-m-d', strtotime($certificate->started_at)) : null,
                'completed_at' => $certificate->completed_at ? date('Y-m-d', strtotime($certificate->completed_at)) : null,
                'exam_status' => $certificate->exam_status ?? 'not_started',
                'voucher_id' => $certificate->voucher_id,
            ];
        });

        // Get progress updates across all certificates
        $progress = collect();
        foreach ($intern->certificates as $certificate) {
            if (isset($certificate->progress)) {
                $certificateProgress = $certificate->progress->map(function ($update) use ($certificate) {
                    return [
                        'id' => $update->id,
                        'certificate_id' => $certificate->certificate_id,
                        'certificate_name' => $certificate->certificate->name ?? 'Unknown Certificate',
                        'course_id' => $update->course_id,
                        'is_completed' => $update->is_completed,
                        'comment' => $update->comment,
                        'proof_url' => $update->proof_url,
                        'updated_by_mentor' => $update->updated_by_mentor,
                        'completed_at' => $update->completed_at,
                        'created_at' => $update->created_at,
                        'updated_at' => $update->updated_at,
                    ];
                });
                $progress = $progress->concat($certificateProgress);
            }
        }

        return response()->json([
            'certificates' => $certificates,
            'progress' => $progress,
        ]);
    }

    /**
     * Send email to intern
     */
    public function sendEmail(Request $request, $id)
    {
        $intern = User::findOrFail($id);

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'copy_me' => 'sometimes|boolean',
        ]);

        try {
            // Send email to intern
            Mail::to($intern->email)->send(new InternEmail(
                $request->subject,
                $request->message
            ));

            // Send copy to admin if requested
            if ($request->has('copy_me')) {
                Mail::to(auth()->user()->email)->send(new InternEmailCopy(
                    $intern->email,
                    $request->subject,
                    $request->message
                ));
            }

            return redirect()->route('admin.interns.show', $intern->id)
                ->with('success', 'Email sent successfully to ' . $intern->email);
        } catch (\Exception $e) {
            return redirect()->route('admin.interns.show', $intern->id)
                ->with('error', 'Error sending email: ' . $e->getMessage());
        }
    }

    /**
     * Batch action for multiple interns
     */
    public function batchAction(Request $request)
    {
        $request->validate([
            'action' => 'required|string|in:delete,assign_mentor,change_status',
            'intern_ids' => 'required|array',
            'intern_ids.*' => 'exists:users,id',
            'mentor_id' => 'required_if:action,assign_mentor|nullable|exists:users,id',
            'status' => 'required_if:action,change_status|nullable|string|in:active,inactive,completed',
        ]);

        $count = 0;

        switch ($request->action) {
            case 'delete':
                // Delete selected interns
                User::whereIn('id', $request->intern_ids)->delete();
                $count = count($request->intern_ids);
                $message = "{$count} interns deleted successfully.";
                break;

            case 'assign_mentor':
                // Assign mentor to selected interns
                User::whereIn('id', $request->intern_ids)
                    ->update(['assigned_mentor_id' => $request->mentor_id]);
                $count = count($request->intern_ids);
                $mentorName = User::find($request->mentor_id)->first_name . ' ' . User::find($request->mentor_id)->last_name;
                $message = "{$count} interns assigned to {$mentorName} successfully.";
                break;

            case 'change_status':
                // Change status of selected interns
                User::whereIn('id', $request->intern_ids)
                    ->update(['status' => $request->status]);
                $count = count($request->intern_ids);
                $message = "{$count} interns updated to status '{$request->status}' successfully.";
                break;
        }

        return redirect()->route('admin.interns.index')
            ->with('success', $message);
    }

    /**
     * Statistics for dashboard
     */
    public function getStatistics()
    {
        $stats = [
            'total' => User::where('role_id', 3)->count(),
            'active' => User::where('role_id', 3)->where('status', 'active')->count(),
            'completed' => User::where('role_id', 3)->where('status', 'completed')->count(),
            'inactive' => User::where('role_id', 3)->where('status', 'inactive')->count(),
            'unassigned' => User::where('role_id', 3)->whereNull('assigned_mentor_id')->count(),
            'recent' => User::where('role_id', 3)->where('created_at', '>=', now()->subDays(30))->count(),
        ];

        // Get certificate statistics
        $certificateStats = \DB::table('intern_certificates')
            ->selectRaw('count(*) as total')
            ->selectRaw('count(case when exam_status = "passed" then 1 end) as passed')
            ->selectRaw('count(case when exam_status = "failed" then 1 end) as failed')
            ->selectRaw('count(case when exam_status = "scheduled" then 1 end) as scheduled')
            ->selectRaw('count(case when completed_at is not null then 1 end) as completed')
            ->first();

        $stats['certificates'] = $certificateStats;

        return response()->json($stats);
    }

    /**
     * Download intern data as PDF
     */
    public function downloadPdf($id)
    {
        $intern = User::with([
            'certificates.certificate.provider',
            'certificates.progress',
            'onboardingSteps.step',
        ])->findOrFail($id);

        $pdf = \PDF::loadView('admin.interns.pdf', compact('intern'));

        return $pdf->download("intern_{$intern->id}_{$intern->first_name}_{$intern->last_name}.pdf");
    }

    /**
     * Reset intern password
     */
    public function resetPassword($id)
    {
        $intern = User::findOrFail($id);

        // Generate a random password
        $password = \Str::random(10);

        // Update the user's password
        $intern->password = bcrypt($password);
        $intern->save();

        // Send email with new password
        \Mail::to($intern->email)->send(new \App\Mail\PasswordReset(
            $intern->first_name,
            $password
        ));

        return redirect()->route('admin.interns.show', $intern->id)
            ->with('success', 'Password reset successfully. A new password has been sent to ' . $intern->email);
    }

}