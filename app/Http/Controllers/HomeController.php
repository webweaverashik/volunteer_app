<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use App\Models\VolunteerTeam;

class HomeController extends Controller
{
    public function index()
    {
        $teams = VolunteerTeam::active()->ordered()->get();
        $faqs = FAQ::active()->ordered()->get();

        return view('home.index', compact('teams', 'faqs'));
    }
}
