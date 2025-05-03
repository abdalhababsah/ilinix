<?php

namespace App\Http\Controllers\Admin;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InternsExport;
use App\Imports\InternsImport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


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
        return view('admin.interns.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
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
            'certificates.certificate',
            'certificates.progress',
            'onboardingSteps.step',
        ])->findOrFail($id);

        return view('admin.interns.show', compact('intern'));
    }

    public function edit($id)
    {
        $intern = User::findOrFail($id);
        return view('admin.interns.edit', compact('intern'));
    }

    public function update(Request $request, $id)
    {
        $intern = User::findOrFail($id);

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

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['first_name', 'last_name', 'email']);
            fputcsv($file, ['John', 'Doe', 'john.doe@example.com']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}