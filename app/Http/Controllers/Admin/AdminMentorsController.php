<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\MentorEmail;
use App\Mail\MentorEmailCopy;
use Illuminate\Http\Request;
use App\Models\User;
use Mail;

class AdminMentorsController extends Controller
{
    /**
     * Display a listing of mentors.
     */
    public function index(Request $request)
    {
        $query = User::query()->where('role_id', 2);

        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', "%{$request->first_name}%");
        }
        if ($request->filled('last_name')) {
            $query->where('last_name', 'like', "%{$request->last_name}%");
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', "%{$request->email}%");
        }

        $mentors = $query->orderBy('first_name')->paginate(10)->appends($request->all());

        return view('admin.mentors.index', compact('mentors'));
    }


    /**
     * Store a newly created mentor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['role_id'] = 2;

        User::create($validated);

        return redirect()->route('admin.mentors.index')->with('success', 'Mentor created successfully.');
    }

    /**
     * Display the specified mentor and their assigned interns.
     */
    public function show($id)
    {
        $mentor = User::with(['mentees'])
            ->findOrFail($id);

        $interns = $mentor->mentees()->paginate(10);

        return view('admin.mentors.show', compact('mentor', 'interns'));
    }

    /**
     * Update the specified mentor.
     */
    public function update(Request $request, $id)
    {
        $mentor = User::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $mentor->update($validated);

        return redirect()->route('admin.mentors.index')->with('success', 'Mentor updated successfully.');
    }

    /**
     * Remove the specified mentor.
     */
    public function destroy($id)
    {
        $mentor = User::findOrFail($id);
        $mentor->delete();

        return redirect()->route('admin.mentors.index')->with('success', 'Mentor deleted successfully.');
    }

    public function deactivate($id)
    {
        $mentor = User::findOrFail($id);
        $mentor->status = 'inactive';
        $mentor->save();
        return back()->with('success', 'Mentor deactivated.');
    }

    public function sendEmail(Request $request, $id)
    {
        $mentor = User::findOrFail($id);
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
            'copy_me' => 'sometimes|boolean'
        ]);
        Mail::to($mentor->email)->send(new MentorEmail($request->subject, $request->message));
        if ($request->boolean('copy_me')) {
            Mail::to(auth()->user()->email)
                ->send(new MentorEmailCopy($mentor->email, $request->subject, $request->message));
        }
        return back()->with('success', 'Email sent to mentor.');
    }
}
