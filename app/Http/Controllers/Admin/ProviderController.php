<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index(Request $request)
    {
        $query = Provider::query();
        
        // Filter by name if provided
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Paginate results and append query string for pagination links
        $providers = $query->paginate(10)->withQueryString();
        
        return view('admin.providers.index', compact('providers'));
    }

    public function create()
    {
    }
    
    public function show(Provider $provider)
    {
    }

    public function edit(Provider $provider)
    {
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image',
        ]);

        if ($request->hasFile('logo')) {
            // store in storage/app/public/providers
            $data['logo'] = $request->file('logo')
                                  ->store('providers', 'public');
        }

        Provider::create($data);

        return redirect()->route('admin.providers.index')
                        ->with('success', 'Provider created.');
    }

    public function update(Request $request, Provider $provider)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // delete old if exists
            if ($provider->logo && \Storage::disk('public')->exists($provider->logo)) {
                \Storage::disk('public')->delete($provider->logo);
            }
            $data['logo'] = $request->file('logo')
                                   ->store('providers', 'public');
        }

        $provider->update($data);

        return redirect()->route('admin.providers.index')
                        ->with('success', 'Provider updated.');
    }
    
    public function destroy(Provider $provider)
    {
        $provider->delete();
        return redirect()->route('admin.providers.index')->with('success', 'Provider deleted.');
    }
}