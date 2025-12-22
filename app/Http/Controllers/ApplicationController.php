<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Volunteer::all();

        return view('admin.applications.index', compact('applications'));
    }
}
