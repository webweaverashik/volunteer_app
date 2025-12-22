<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'mobile',
        'nid',
        'sylhet3_resident',
        'upazila_id',
        'union_name',
        'current_address',
        'voting_center',
        'age',
        'occupation_id',
        'reference',
        'weekly_hours',
        'preferred_time',
        'comments',
        'other_team_description',
        'status',
    ];

    protected $casts = [
        'sylhet3_resident' => 'boolean',
        'age' => 'integer',
    ];

    public function upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class);
    }

    public function occupation(): BelongsTo
    {
        return $this->belongsTo(Occupation::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(VolunteerTeam::class)->withTimestamps();
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeSylhet3Resident($query)
    {
        return $query->where('sylhet3_resident', true);
    }

    public function getWeeklyHoursLabelAttribute(): string
    {
        return match($this->weekly_hours) {
            '1-4' => '১-৪ ঘন্টা',
            '5-8' => '৫-৮ ঘন্টা',
            '9-12' => '৯-১২ ঘন্টা',
            '12+' => '১২ ঘন্টা +',
            default => 'নির্ধারিত নয়',
        };
    }

    public function getPreferredTimeLabelAttribute(): string
    {
        return match($this->preferred_time) {
            'morning' => '🌅 সকাল',
            'noon' => '☀️ দুপুর',
            'afternoon' => '🌤️ বিকাল',
            'evening' => '🌆 সন্ধ্যা',
            'anytime' => '✅ যেকোনো সময়',
            default => 'নির্ধারিত নয়',
        };
    }
}
