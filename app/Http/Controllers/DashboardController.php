<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->user()->role_id; //  role_id is stored in the user table 1 for admin, 2 for mintor, and 3 for intern

        switch ($role) {
            case 1: // admin
                return redirect()->route("admin.dashboard");
            case 2: // mintor
                return redirect()->route('mintor.dashboard');
            case 3: // intern
                return redirect()->route('intern.dashboard');
            default:
                abort(403, 'Unauthorized action.');
        }
    }
}