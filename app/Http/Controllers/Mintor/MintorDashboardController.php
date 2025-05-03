<?php

namespace App\Http\Controllers\Mintor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MintorDashboardController extends Controller
{
    public function index(){
        return view("mintor.dashboard");
    }
}
