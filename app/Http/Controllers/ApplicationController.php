<?php
namespace App\Http\Controllers;

use App\Exports\ApplicationsExport;
use App\Models\Occupation;
use App\Models\Upazila;
use App\Models\Volunteer;
use App\Models\VolunteerTeam;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ApplicationController extends Controller
{
    /**
     * Page load (NO DATA)
     */
    public function index()
    {
        return view('admin.applications.index', [
            'upazilas'    => Upazila::ordered()->get(),
            'occupations' => Occupation::ordered()->get(),
            'teams'       => VolunteerTeam::active()->ordered()->get(),
        ]);
    }

    /**
     * AJAX DataTables
     */
    public function data(Request $request)
    {
        $query = Volunteer::query()
            ->with(['upazila', 'occupation', 'teams'])
            ->latest()
            ->select('volunteers.*');

        /* ---------------- FILTERS ---------------- */
        if ($request->filled('upazila_id')) {
            $query->where('upazila_id', $request->upazila_id);
        }

        if ($request->filled('occupation_id')) {
            $query->where('occupation_id', $request->occupation_id);
        }

        if ($request->filled('sylhet3_resident')) {
            $query->where('sylhet3_resident', $request->sylhet3_resident);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('team_id')) {
            $query->whereHas('teams', fn($q) =>
                $q->where('volunteer_team_id', $request->team_id)
            );
        }

        if ($request->filled('weekly_hours')) {
            $query->where('weekly_hours', $request->weekly_hours);
        }

        if ($request->filled('preferred_time')) {
            $query->where('preferred_time', $request->preferred_time);
        }

        /* ---------------- GLOBAL SEARCH ---------------- */
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('mobile', 'LIKE', "%{$search}%")
                    ->orWhere('nid', 'LIKE', "%{$search}%")
                    ->orWhere('union_name', 'LIKE', "%{$search}%")
                    ->orWhere('current_address', 'LIKE', "%{$search}%")
                    ->orWhere('voting_center', 'LIKE', "%{$search}%")
                    ->orWhere('reference', 'LIKE', "%{$search}%")
                    ->orWhere('comments', 'LIKE', "%{$search}%")
                    ->orWhereHas('upazila', fn($u) =>
                        $u->where('name_bn', 'LIKE', "%{$search}%")
                    )
                    ->orWhereHas('occupation', fn($o) =>
                        $o->where('name_bn', 'LIKE', "%{$search}%")
                    )
                    ->orWhereHas('teams', fn($t) =>
                        $t->where('name_bn', 'LIKE', "%{$search}%")
                    );
            });
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()

            ->editColumn('sylhet3_resident', fn($v) => $v->sylhet3_resident ? 'হ্যাঁ' : 'না')

            ->addColumn('upazila', fn($v) => $v->upazila?->name_bn ?? '-')
            ->addColumn('occupation', fn($v) => $v->occupation?->name_bn ?? '-')

            ->addColumn('teams', function ($v) {
                $names = $v->teams->pluck('name_bn')->toArray();
                if ($v->other_team_description) {
                    $names[] = 'অন্যান্য: ' . $v->other_team_description;
                }
                return $names ? implode('<br>', array_map(fn($t) => '- ' . $t, $names)) : '-';
            })

            ->addColumn('weekly_hours', fn($v) => $v->weekly_hours_label)
            ->addColumn('preferred_time', fn($v) => $v->preferred_time_label)

            ->addColumn('comments', function ($v) {
                if (! $v->comments) {
                    return '-';
                }

                return '
                    <a href="#" data-bs-toggle="modal" data-bs-target="#commentModal' . $v->id . '">
                        <i class="bi bi-eye fs-4"></i>
                    </a>
                    <span class="d-none">' . e($v->comments) . '</span>
                    <div class="modal fade" id="commentModal' . $v->id . '" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content">
                                <div class="modal-header py-2">
                                    <h5 class="modal-title fs-6">মন্তব্য</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body fs-6">' . nl2br(e($v->comments)) . '</div>
                            </div>
                        </div>
                    </div>
                ';
            })

            ->addColumn('status', fn($v) =>
                match ($v->status) {
                    'approved' => '<span class="badge badge-success">গৃহীত</span>',
                    'rejected' => '<span class="badge badge-danger">বাদ</span>',
                    default    => '<span class="badge badge-warning">পেন্ডিং</span>',
                }
            )

            ->addColumn('created_at', function ($v) {
                return $v->created_at
                    ? $v->created_at->format('d-m-Y h:i A')
                    : '-';
            })

            ->addColumn('action', function ($v) {
                if ($v->status !== 'pending') {
                    return '—';
                }

                return '
        <button
            class="btn btn-icon btn-sm btn-light-success btn-color-success js-approve"
            data-id="' . $v->id . '"
            title="এপ্রুভ" data-bs-toggle="tooltip">
            <i class="bi bi-check2-circle fs-3"></i>
        </button>

        <button
            class="btn btn-icon btn-sm btn-light-danger  btn-color-danger js-reject"
            data-id="' . $v->id . '"
            title="রিজেক্ট" data-bs-toggle="tooltip">
            <i class="bi bi-x-circle fs-3"></i>
        </button>
    ';
            })

            ->rawColumns(['teams', 'comments', 'status', 'action'])
            ->toJson();
    }

    /**
     * Excel export (SERVER SIDE)
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new ApplicationsExport($request),
            'volunteer_applications.xlsx'
        );
    }

    public function updateStatus(Request $request, Volunteer $volunteer)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        // Optional: prevent double action
        if ($volunteer->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'এই আবেদনটি ইতোমধ্যে প্রক্রিয়াজাত করা হয়েছে।',
            ], 422);
        }

        $volunteer->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => $request->status === 'approved'
                ? 'আবেদনটি সফলভাবে গৃহীত হয়েছে।'
                : 'আবেদনটি বাতিল করা হয়েছে।',
        ]);
    }

}
