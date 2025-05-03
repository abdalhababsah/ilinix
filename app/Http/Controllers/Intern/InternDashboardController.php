<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InternDashboardController extends Controller
{
    public function index(){
        return view("intern.dashboard");
    }
}
