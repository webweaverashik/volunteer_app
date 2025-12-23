<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'              => ['required', 'string', 'max:255'],
            'mobile'                 => ['required', 'string', 'regex:/^01[3-9]\d{8}$/'],
            'nid'                    => ['nullable', 'string', 'regex:/^(?:\d{10}|\d{13}|\d{17})$/'],
            'sylhet3_resident'       => ['required', 'in:yes,no'],
            'upazila_id'             => ['required', 'exists:upazilas,id'],
            'union_name'             => ['required', 'string', 'max:255'],
            'current_address'        => ['required', 'string', 'max:1000'],
            'voting_center'          => ['nullable', 'string', 'max:255'],
            'age'                    => ['required', 'integer', 'min:18', 'max:80'],
            'occupation_id'          => ['nullable', 'exists:occupations,id'],
            'teams'                  => ['required', 'array', 'min:1'],
            'teams.*'                => ['exists:volunteer_teams,id'],
            'other_team_description' => ['nullable', 'string', 'max:500'],
            'reference'              => ['nullable', 'string', 'max:255'],
            'weekly_hours'           => ['nullable', 'in:1-4,5-8,9-12,12+'],
            'preferred_time'         => ['nullable', 'in:morning,noon,afternoon,evening,anytime'],
            'comments'               => ['nullable', 'string', 'max:2000'],
            'terms'                  => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required'        => 'পূর্ণ নাম প্রয়োজন।',
            'full_name.max'             => 'পূর্ণ নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',
            'mobile.required'           => 'মোবাইল নম্বর প্রয়োজন।',
            'mobile.regex'              => 'সঠিক বাংলাদেশি মোবাইল নম্বর দিন (০১XXXXXXXXX)।',
            'nid.regex'                 => '১০ বা ১৩ বা ১৭ ডিজিটের এনআইডি নং দিন।',
            'sylhet3_resident.required' => 'আপনি সিলেট-৩ এর অধিবাসী কিনা তা নির্বাচন করুন।',
            'sylhet3_resident.in'       => 'সঠিক অপশন নির্বাচন করুন।',
            'upazila_id.required'       => 'উপজেলা নির্বাচন করুন।',
            'upazila_id.exists'         => 'সঠিক উপজেলা নির্বাচন করুন।',
            'union_name.required'       => 'ইউনিয়নের নাম প্রয়োজন।',
            'union_name.max'            => 'ইউনিয়নের নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',
            'current_address.required'  => 'বর্তমান ঠিকানা প্রয়োজন।',
            'current_address.max'       => 'ঠিকানা সর্বোচ্চ ১০০০ অক্ষর হতে পারে।',
            'age.required'              => 'বয়স প্রয়োজন।',
            'age.integer'               => 'বয়স একটি সংখ্যা হতে হবে।',
            'age.min'                   => 'বয়স কমপক্ষে ১৮ বছর হতে হবে।',
            'age.max'                   => 'বয়স সর্বোচ্চ ৮০ বছর হতে পারে।',
            'teams.required'            => 'অন্তত একটি টিম নির্বাচন করুন।',
            'teams.min'                 => 'অন্তত একটি টিম নির্বাচন করুন।',
            'teams.*.exists'            => 'সঠিক টিম নির্বাচন করুন।',
            'terms.required'            => 'শর্তাবলী মেনে নিতে হবে।',
            'terms.accepted'            => 'শর্তাবলী মেনে নিতে হবে।',
        ];
    }

    public function attributes(): array
    {
        return [
            'full_name'        => 'পূর্ণ নাম',
            'mobile'           => 'মোবাইল নম্বর',
            'nid'              => 'ভোটার আইডি',
            'sylhet3_resident' => 'সিলেট-৩ অধিবাসী',
            'upazila_id'       => 'উপজেলা',
            'union_name'       => 'ইউনিয়ন',
            'current_address'  => 'বর্তমান ঠিকানা',
            'voting_center'    => 'ভোট কেন্দ্র',
            'age'              => 'বয়স',
            'occupation_id'    => 'পেশা',
            'teams'            => 'টিম',
            'reference'        => 'রেফারেন্স',
            'weekly_hours'     => 'সাপ্তাহিক সময়',
            'preferred_time'   => 'পছন্দের সময়',
            'comments'         => 'মন্তব্য',
        ];
    }
}
