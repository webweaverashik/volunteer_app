<?php
namespace App\Http\Controllers;

use App\Http\Requests\VolunteerRequest;
use App\Models\FAQ;
use App\Models\Occupation;
use App\Models\Upazila;
use App\Models\Volunteer;
use App\Models\VolunteerTeam;

class VolunteerController extends Controller
{
    public function create()
    {
        $upazilas    = Upazila::ordered()->get();
        $occupations = Occupation::ordered()->get();
        $teams       = VolunteerTeam::active()->ordered()->get();
        $faqs        = FAQ::active()->ordered()->get();

        return view('volunteer.create', compact('upazilas', 'occupations', 'teams', 'faqs'));
    }

    public function store(VolunteerRequest $request)
    {
        $validated = $request->validated();

        // Create volunteer
        $volunteer = Volunteer::create([
            'full_name'              => $validated['full_name'],
            'mobile'                 => $validated['mobile'],
            'nid'                    => $validated['nid'] ?? null,
            'sylhet3_resident'       => $validated['sylhet3_resident'] === 'yes',
            'upazila_id'             => $validated['upazila_id'],
            'union_name'             => $validated['union_name'],
            'current_address'        => $validated['current_address'],
            'voting_center'          => $validated['voting_center'] ?? null,
            'age'                    => $validated['age'],
            'occupation_id'          => $validated['occupation_id'] ?? null,
            'reference'              => $validated['reference'] ?? null,
            'weekly_hours'           => $validated['weekly_hours'] ?? null,
            'preferred_time'         => $validated['preferred_time'] ?? null,
            'comments'               => $validated['comments'] ?? null,
            'other_team_description' => $validated['other_team_description'] ?? null,
            'status'                 => 'pending',
        ]);

        // Attach teams
        if (! empty($validated['teams'])) {
            $volunteer->teams()->attach($validated['teams']);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'message'      => 'আপনার নিবন্ধন সফলভাবে সম্পন্ন হয়েছে।',
                'volunteer_id' => $volunteer->id,
            ]);
        }

        return redirect()->route('volunteer.success')->with('success', 'আপনার নিবন্ধন সফলভাবে সম্পন্ন হয়েছে।');
    }

    public function success()
    {
        return view('volunteer.success');
    }
}
