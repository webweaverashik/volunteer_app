<?php
namespace App\Exports;

use App\Models\Volunteer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicationsExport implements
FromQuery,
WithHeadings,
WithMapping,
ShouldAutoSize
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * SAME query logic as AJAX DataTables
     */
    public function query()
    {
        $q = Volunteer::query()
            ->with(['upazila', 'occupation', 'teams']);

        // Filters
        if ($this->request->filled('upazila_id')) {
            $q->where('upazila_id', $this->request->upazila_id);
        }

        if ($this->request->filled('sylhet3_resident')) {
            $q->where('sylhet3_resident', $this->request->sylhet3_resident);
        }

        if ($this->request->filled('occupation_id')) {
            $q->where('occupation_id', $this->request->occupation_id);
        }

        if ($this->request->filled('team_id')) {
            $q->whereHas('teams', fn($t) =>
                $t->where('volunteer_team_id', $this->request->team_id)
            );
        }

        if ($this->request->filled('status')) {
            $q->where('status', $this->request->status);
        }

        if ($this->request->filled('weekly_hours')) {
            $q->where('weekly_hours', $this->request->weekly_hours);
        }

        if ($this->request->filled('preferred_time')) {
            $q->where('preferred_time', $this->request->preferred_time);
        }

        // Global search
        if ($this->request->filled('search')) {
            $search = $this->request->search;

            $q->where(function ($x) use ($search) {
                $x->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('mobile', 'LIKE', "%{$search}%")
                    ->orWhere('nid', 'LIKE', "%{$search}%")
                    ->orWhere('union_name', 'LIKE', "%{$search}%")
                    ->orWhere('current_address', 'LIKE', "%{$search}%")
                    ->orWhere('voting_center', 'LIKE', "%{$search}%")
                    ->orWhere('reference', 'LIKE', "%{$search}%")
                    ->orWhere('comments', 'LIKE', "%{$search}%");
            });
        }

        return $q;
    }

    /**
     * Excel column headings
     */
    public function headings(): array
    {
        return [
            'পূর্ণ নাম',
            'মোবাইল নম্বর',
            'এনআইডি',
            'সিলেট-৩ আসনের অধিবাসী',
            'উপজেলা',
            'ইউনিয়ন',
            'বর্তমান ঠিকানা',
            'ভোট কেন্দ্র',
            'বয়স',
            'পেশা',
            'কোন কাজে আগ্রহী',
            'রেফারেন্স',
            'প্রতি সপ্তাহে সময়',
            'কখন সময় দিতে পারবে',
            'মন্তব্য',
            'স্ট্যাটাস',
        ];
    }

    /**
     * Map DB row → Excel row
     */
    public function map($v): array
    {
        // Merge teams + other team description
        $teams = $v->teams->pluck('name_bn')->toArray();

        if ($v->other_team_description) {
            $teams[] = 'অন্যান্য: ' . $v->other_team_description;
        }

        return [
            $v->full_name,
            $v->mobile,
            $v->nid ?? '-',
            $v->sylhet3_resident ? 'হ্যাঁ' : 'না',
            $v->upazila?->name_bn ?? '-',
            $v->union_name,
            $v->current_address,
            $v->voting_center ?? '-',
            $v->age,
            $v->occupation?->name_bn ?? '-',
            implode(', ', $teams),
            $v->reference ?? '-',
            $v->weekly_hours_label,   // accessor
            $v->preferred_time_label, // accessor
            $v->comments ?? '-',
            match ($v->status) {
                'approved' => 'গৃহীত',
                'rejected' => 'বাদ',
                default    => 'পেন্ডিং',
            },
        ];
    }
}
