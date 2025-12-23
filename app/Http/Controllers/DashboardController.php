<?php
namespace App\Http\Controllers;

use App\Models\Occupation;
use App\Models\Upazila;
use App\Models\Volunteer;
use App\Models\VolunteerTeam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Stats counts
        $stats = [
            'total'    => Volunteer::count(),
            'pending'  => Volunteer::pending()->count(),
            'approved' => Volunteer::approved()->count(),
            'rejected' => Volunteer::where('status', 'rejected')->count(),
        ];

        // Sylhet-3 Resident stats
        $sylhet3Stats = [
            'yes' => Volunteer::where('sylhet3_resident', true)->count(),
            'no'  => Volunteer::where('sylhet3_resident', false)->count(),
        ];

        // Upazila wise count
        $upazilaStats = Upazila::withCount('volunteers')->orderByDesc('volunteers_count')->get()->map(
            fn($u) => [
                'name'  => $u->name_bn,
                'count' => $u->volunteers_count,
            ],
        );

        // Top 10 Occupations
        $occupationStats = Occupation::withCount('volunteers')->orderByDesc('volunteers_count')->limit(10)->get()->map(
            fn($o) => [
                'name'  => $o->name_bn,
                'count' => $o->volunteers_count,
            ],
        );

        // Age range stats
        $ageRanges = [
            '১৮-২৫' => Volunteer::whereBetween('age', [18, 25])->count(),
            '২৬-৩০' => Volunteer::whereBetween('age', [26, 30])->count(),
            '৩১-৩৫' => Volunteer::whereBetween('age', [31, 35])->count(),
            '৩৬-৪০' => Volunteer::whereBetween('age', [36, 40])->count(),
            '৪১-৪৫' => Volunteer::whereBetween('age', [41, 45])->count(),
            '৪৬-৫০' => Volunteer::whereBetween('age', [46, 50])->count(),
            '৫০+'   => Volunteer::where('age', '>', 50)->count(),
        ];

        // Weekly hours stats
        $weeklyHoursStats = [
            '১-৪ ঘন্টা'  => Volunteer::where('weekly_hours', '1-4')->count(),
            '৫-৮ ঘন্টা'  => Volunteer::where('weekly_hours', '5-8')->count(),
            '৯-১২ ঘন্টা' => Volunteer::where('weekly_hours', '9-12')->count(),
            '১২+ ঘন্টা'  => Volunteer::where('weekly_hours', '12+')->count(),
        ];

        // Preferred time stats
        $preferredTimeStats = [
            '🌅 সকাল'        => Volunteer::where('preferred_time', 'morning')->count(),
            '☀️ দুপুর'      => Volunteer::where('preferred_time', 'noon')->count(),
            '🌤️ বিকাল'      => Volunteer::where('preferred_time', 'afternoon')->count(),
            '🌆 সন্ধ্যা'     => Volunteer::where('preferred_time', 'evening')->count(),
            '✅ যেকোনো সময়' => Volunteer::where('preferred_time', 'anytime')->count(),
        ];

        // Teams stats
        $teamsStats = VolunteerTeam::active()->ordered()->withCount('volunteers')->get()->map(
            fn($t) => [
                'name'  => $t->name_bn,
                'icon'  => $t->icon ?? 'ki-people',
                'color' => $t->color ?? '#1e88e5',
                'count' => $t->volunteers_count,
            ],
        );

        // Daily trend for current month (default)
        $currentMonth = $request->input('month', now()->month);
        $currentYear  = $request->input('year', now()->year);

        $dailyTrend = Volunteer::selectRaw('DAY(created_at) as day, COUNT(*) as count')->whereYear('created_at', $currentYear)->whereMonth('created_at', $currentMonth)->groupBy('day')->orderBy('day')->pluck('count', 'day')->toArray();

        // Monthly trend for current year
        $monthlyTrend = Volunteer::selectRaw('MONTH(created_at) as month, COUNT(*) as count')->whereYear('created_at', $currentYear)->groupBy('month')->orderBy('month')->pluck('count', 'month')->toArray();

        return view('admin.dashboard.index', compact('stats', 'sylhet3Stats', 'upazilaStats', 'occupationStats', 'ageRanges', 'weeklyHoursStats', 'preferredTimeStats', 'teamsStats', 'dailyTrend', 'monthlyTrend', 'currentMonth', 'currentYear'));
    }

    /**
     * API endpoint for fetching trend data (AJAX)
     */
    public function getTrendData(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year  = $request->input('year', now()->year);
        $view  = $request->input('view', 'daily');

        if ($view === 'daily') {
            $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
            $data        = Volunteer::selectRaw('DAY(created_at) as day, COUNT(*) as count')->whereYear('created_at', $year)->whereMonth('created_at', $month)->groupBy('day')->orderBy('day')->pluck('count', 'day')->toArray();

            // Fill missing days with 0
            $trend = [];
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $trend[$i] = $data[$i] ?? 0;
            }

            return response()->json([
                'labels' => array_keys($trend),
                'data'   => array_values($trend),
                'month'  => $month,
                'year'   => $year,
            ]);
        } else {
            $data = Volunteer::selectRaw('MONTH(created_at) as month, COUNT(*) as count')->whereYear('created_at', $year)->groupBy('month')->orderBy('month')->pluck('count', 'month')->toArray();

            // Fill missing months with 0
            $trend = [];
            for ($i = 1; $i <= 12; $i++) {
                $trend[$i] = $data[$i] ?? 0;
            }

            return response()->json([
                'labels' => array_keys($trend),
                'data'   => array_values($trend),
                'year'   => $year,
            ]);
        }
    }
}
