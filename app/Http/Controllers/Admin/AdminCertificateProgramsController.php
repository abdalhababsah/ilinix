<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateProgram;
use App\Models\CertificateCourse;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminCertificateProgramsController extends Controller
{
    public function index(Request $request)
    {
        $query = CertificateProgram::withCount('courses')->with('provider');

        if ($request->filled('title')) {
            $query->where('title', 'like', "%{$request->title}%");
        }
        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $programs = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->all());
        $providers = Provider::orderBy('name')->get();

        return view('admin.certificates.index', compact('programs', 'providers'));
    }

    public function create()
    {
        $providers = Provider::orderBy('name')->get();
        return view('admin.certificates.create', compact('providers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'provider_id' => 'required|exists:providers,id',
            'level'       => 'nullable|string|max:50',
            'type'        => 'required|in:digital,classroom,hybrid',
            'description' => 'nullable|string',
            'image'       => 'nullable|file|image|mimes:jpeg,png,jpg|max:5120',[
                [
                    'image.max' => 'The uploaded image must be less than 6MB.',
                    'image.mimes' => 'Only JPG, JPEG, and PNG images are allowed.',
                    'image.image' => 'The file must be a valid image format.',
                ]
                ],
            'courses'     => 'required|array|min:1',
            'courses.*.title'             => 'required|string|max:255',
            'courses.*.description'       => 'nullable|string',
            'courses.*.resource_link'     => 'nullable|url',
            'courses.*.digital_link'      => 'nullable|url',
            'courses.*.estimated_minutes' => 'nullable|integer|min:1',
            'courses.*.step_order'        => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->handleImageUpload($request->file('image'));
        }

        DB::transaction(function () use ($data) {
            $program = CertificateProgram::create($data);
            foreach ($data['courses'] as $course) {
                $program->courses()->create($course);
            }
        });

        return redirect()->route('admin.certificate-programs.index')->with('success', 'Certificate program created.');
    }

    public function edit(CertificateProgram $certificateProgram)
    {
        $providers = Provider::orderBy('name')->get();
        $certificateProgram->load('courses');
        return view('admin.certificates.edit', compact('certificateProgram', 'providers'));
    }

    public function update(Request $request, CertificateProgram $certificateProgram)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'provider_id' => 'required|exists:providers,id',
            'level'       => 'nullable|string|max:50',
            'type'        => 'required|in:digital,classroom,hybrid',
            'description' => 'nullable|string',
            'image'       => 'nullable|file|image|mimes:jpeg,png,jpg|max:5120',
            'courses'     => 'required|array|min:1',
            'courses.*.id'                => 'nullable|exists:certificate_courses,id',
            'courses.*.title'             => 'required|string|max:255',
            'courses.*.description'       => 'nullable|string',
            'courses.*.resource_link'     => 'nullable|url',
            'courses.*.digital_link'      => 'nullable|url',
            'courses.*.estimated_minutes' => 'nullable|integer|min:1',
            'courses.*.step_order'        => 'nullable|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $data, $certificateProgram) {
            if ($request->hasFile('image')) {
                $this->handleImageDeletion($certificateProgram->image_path);
                $data['image_path'] = $this->handleImageUpload($request->file('image'));
            }

            $certificateProgram->update($data);

            $keep = [];
            foreach ($data['courses'] as $courseData) {
                if (!empty($courseData['id'])) {
                    $course = CertificateCourse::find($courseData['id']);
                    $course->update($courseData);
                    $keep[] = $course->id;
                } else {
                    $new = $certificateProgram->courses()->create($courseData);
                    $keep[] = $new->id;
                }
            }
            $certificateProgram->courses()->whereNotIn('id', $keep)->delete();
        });

        return redirect()->route('admin.certificate-programs.index')->with('success', 'Certificate program updated.');
    }

    public function destroy(CertificateProgram $certificateProgram)
    {
        $this->handleImageDeletion($certificateProgram->image_path);
        $certificateProgram->delete();
        return back()->with('success', 'Certificate program deleted.');
    }

    /**
     * Handle image upload and return file path.
     */
    private function handleImageUpload($file)
    {
        $filename = 'program_' . Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = 'programs/images';
        return $file->storeAs($path, $filename, 'public');
    }

    /**
     * Handle deleting an image from storage.
     */
    private function handleImageDeletion($path)
    {
        if ($path && Str::startsWith($path, 'programs/images/') && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}