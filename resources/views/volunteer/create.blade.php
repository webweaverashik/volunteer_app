@extends('layouts.app')

@section('title', 'স্বেচ্ছাসেবক নিবন্ধন | সিলেট-৩ | ব্যারিস্টার নুরুল হুদা জুনেদ')

@section('show_faq', false)

@section('content')
    <section class="py-8 md:py-12">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    🤝 স্বেচ্ছাসেবক নিবন্ধন | সিলেট-৩
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">
                    স্বেচ্ছাসেবক হিসেবে যোগ দিন
                </h1>
                <p class="text-gray-600">
                    ব্যারিস্টার নুরুল হুদা জুনেদ এর সাথে সিলেট-৩ আসনে পরিবর্তনের যাত্রায় শামিল হোন
                </p>
            </div>

            <div class="bg-white rounded-2xl card-shadow p-6 md:p-8">
                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                        <div class="flex items-center gap-2 text-red-700 font-semibold mb-2">
                            <span>⚠️</span> অনুগ্রহ করে নিম্নলিখিত ত্রুটিগুলো সংশোধন করুন:
                        </div>
                        <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="volunteerForm" action="{{ route('volunteer.store') }}" method="POST">
                    @csrf

                    <!-- Section 1: Personal Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-sm">১</span>
                            ব্যক্তিগত তথ্য
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">পূর্ণ নাম <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 transition @error('full_name') border-red-500 @enderror"
                                    placeholder="আপনার পূর্ণ নাম লিখুন">
                                @error('full_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">মোবাইল নম্বর <span
                                        class="text-red-500">*</span></label>
                                <input type="tel" name="mobile" value="{{ old('mobile') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 transition @error('mobile') border-red-500 @enderror"
                                    placeholder="০১XXXXXXXXX">
                                @error('mobile')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">ভোটার আইডি নম্বর</label>
                                <input type="text" name="nid" value="{{ old('nid') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 transition @error('nid') border-red-500 @enderror"
                                    placeholder="ভোটার আইডি নম্বর লিখুন">
                                @error('nid')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Sylhet-3 Residence -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span
                                class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-sm">২</span>
                            আপনি কি সিলেট-৩ এর অধিবাসী? <span class="text-red-500">*</span>
                        </h3>
                        <p class="text-gray-500 text-sm mb-3">(দক্ষিণ সুরমা উপজেলা, ফেঞ্চুগঞ্জ উপজেলা এবং বালাগঞ্জ উপজেলা)
                        </p>
                        <div class="flex gap-4">
                            <label
                                class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-green-50 hover:border-green-300 transition flex-1 justify-center">
                                <input type="radio" name="sylhet3_resident" value="yes"
                                    {{ old('sylhet3_resident') == 'yes' ? 'checked' : '' }} class="w-5 h-5 text-green-600">
                                <span class="text-gray-800 font-medium">✅ হ্যাঁ</span>
                            </label>
                            <label
                                class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-red-50 hover:border-red-300 transition flex-1 justify-center">
                                <input type="radio" name="sylhet3_resident" value="no"
                                    {{ old('sylhet3_resident') == 'no' ? 'checked' : '' }} class="w-5 h-5 text-green-600">
                                <span class="text-gray-800 font-medium">❌ না</span>
                            </label>
                        </div>
                        @error('sylhet3_resident')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Section 3: Address -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span
                                class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center text-sm">৩</span>
                            বর্তমান ঠিকানা
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">উপজেলা <span
                                        class="text-red-500">*</span></label>
                                <select name="upazila_id" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 transition bg-white @error('upazila_id') border-red-500 @enderror">
                                    <option value="">উপজেলা নির্বাচন করুন</option>
                                    @foreach ($upazilas as $upazila)
                                        <option value="{{ $upazila->id }}"
                                            {{ old('upazila_id') == $upazila->id ? 'selected' : '' }}>
                                            {{ $upazila->name_bn }} @if ($upazila->is_sylhet3)
                                                (সিলেট-৩)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('upazila_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">ইউনিয়ন <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="union_name" value="{{ old('union_name') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 transition @error('union_name') border-red-500 @enderror"
                                    placeholder="আপনার ইউনিয়নের নাম লিখুন">
                                @error('union_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">আপনার ঠিকানা <span
                                        class="text-red-500">*</span></label>
                                <textarea name="current_address" required rows="2"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 transition @error('current_address') border-red-500 @enderror"
                                    placeholder="আপনার বর্তমান ঠিকানা লিখুন (গ্রাম/মহল্লা, ইউনিয়ন/ওয়ার্ড, উপজেলা)">{{ old('current_address') }}</textarea>
                                @error('current_address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">ভোট কেন্দ্র</label>
                                <input type="text" name="voting_center" value="{{ old('voting_center') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 transition @error('voting_center') border-red-500 @enderror"
                                    placeholder="আপনার ভোট কেন্দ্রের নাম লিখুন">
                                @error('voting_center')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Age -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center text-sm">৪</span>
                            আপনার বয়স
                        </h3>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">বয়স লিখুন <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="age" value="{{ old('age') }}" required min="18"
                                max="80"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 transition @error('age') border-red-500 @enderror"
                                placeholder="বয়স লিখুন (১৮-৮০)">
                            <p class="text-gray-500 text-sm mt-1">১৮ বছর বা তার উর্ধ্বে হতে হবে</p>
                            @error('age')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 5: Additional Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span
                                class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-sm">৫</span>
                            অতিরিক্ত তথ্য
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">পেশা</label>
                                <select name="occupation_id"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 transition bg-white @error('occupation_id') border-red-500 @enderror">
                                    <option value="">পেশা নির্বাচন করুন</option>
                                    @foreach ($occupations as $occupation)
                                        <option value="{{ $occupation->id }}"
                                            {{ old('occupation_id') == $occupation->id ? 'selected' : '' }}>
                                            {{ $occupation->name_bn }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('occupation_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-3">আপনি কোন কাজে যুক্ত হতে আগ্রহী? <span
                                        class="text-red-500">*</span> <span
                                        class="text-gray-500 text-sm font-normal">(একাধিক অপশন সিলেক্ট করা
                                        যাবে)</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @php $teamLetters = ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ', 'ছ', 'জ', 'ঝ']; @endphp
                                    @foreach ($teams as $index => $team)
                                        <label
                                            class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-{{ $team->color }}-50 hover:border-{{ $team->color }}-300 transition">
                                            <input type="checkbox" name="teams[]" value="{{ $team->id }}"
                                                {{ is_array(old('teams')) && in_array($team->id, old('teams')) ? 'checked' : '' }}
                                                class="team-checkbox w-5 h-5 mt-0.5 text-green-600 rounded flex-shrink-0"
                                                @if ($team->slug === 'other') id="otherTeamCheckbox" @endif>
                                            <div class="flex-1">
                                                <span class="font-bold text-gray-800 flex items-center gap-2">
                                                    <span
                                                        class="text-{{ $team->color }}-600">{{ $teamLetters[$index] ?? '' }}.</span>
                                                    <span>{{ $team->icon }}</span> {{ $team->name_bn }}
                                                </span>
                                                <p class="text-gray-500 text-sm mt-1">{{ $team->description_bn }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('teams')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <!-- Other Team Description -->
                                <div id="otherTeamInput"
                                    class="mt-4 {{ old('other_team_description') ? '' : 'hidden' }}">
                                    <input type="text" name="other_team_description"
                                        value="{{ old('other_team_description') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 transition"
                                        placeholder="আপনি কিভাবে অবদান রাখতে চান লিখুন...">
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">রেফারেন্স (যদি থাকে)</label>
                                <input type="text" name="reference" value="{{ old('reference') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 transition @error('reference') border-red-500 @enderror"
                                    placeholder="রেফারারের নাম ও মোবাইল">
                                @error('reference')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 6: Availability -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span
                                class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center text-sm">৬</span>
                            সময় ও সুবিধা
                        </h3>
                        <div class="space-y-5">
                            <!-- Weekly Hours -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-3">আপনি সপ্তাহে কত ঘন্টা সময় দিতে
                                    পারবেন?</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    @foreach (['1-4' => '১-৪ ঘন্টা', '5-8' => '৫-৮ ঘন্টা', '9-12' => '৯-১২ ঘন্টা', '12+' => '১২ ঘন্টা +'] as $value => $label)
                                        <label
                                            class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition">
                                            <input type="radio" name="weekly_hours" value="{{ $value }}"
                                                {{ old('weekly_hours') == $value ? 'checked' : '' }}
                                                class="w-4 h-4 text-green-600">
                                            <span class="text-gray-800">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Preferred Time -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-3">কোন সময়টা আপনার জন্য
                                    সুবিধাজনক?</label>
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                                    @foreach (['morning' => '🌅 সকাল', 'noon' => '☀️ দুপুর', 'afternoon' => '🌤️ বিকাল', 'evening' => '🌆 সন্ধ্যা', 'anytime' => '✅ যেকোনো সময়'] as $value => $label)
                                        <label
                                            class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition">
                                            <input type="radio" name="preferred_time" value="{{ $value }}"
                                                {{ old('preferred_time') == $value ? 'checked' : '' }}
                                                class="w-4 h-4 text-green-600">
                                            <span class="text-gray-800">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 7: Comments -->
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span
                                class="w-8 h-8 bg-cyan-100 rounded-full flex items-center justify-center text-sm">৭</span>
                            মন্তব্য ও পরামর্শ
                        </h3>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">আপনার কোনো মন্তব্য, পরামর্শ বা এলাকার
                                সমস্যা থাকলে লিখুন <span class="text-gray-400 text-sm font-normal">(ঐচ্ছিক)</span></label>
                            <textarea name="comments" rows="4"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 transition resize-none @error('comments') border-red-500 @enderror"
                                placeholder="আপনার কোনো মন্তব্য, পরামর্শ বা এলাকার সমস্যা থাকলে লিখুন...">{{ old('comments') }}</textarea>
                            @error('comments')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="mb-6">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="terms" required class="w-5 h-5 mt-0.5 text-green-600"
                                {{ old('terms') ? 'checked' : '' }}>
                            <span class="text-gray-600 text-sm">
                                আমি নিশ্চিত করছি যে উপরের সকল তথ্য সঠিক এবং আমি স্বেচ্ছায় সিলেট-৩ আসনে ব্যারিস্টার নুরুল
                                হুদা জুনেদ এর স্বেচ্ছাসেবক হিসেবে নিবন্ধন করছি।
                                <span class="text-red-500">*</span>
                            </span>
                        </label>
                        @error('terms')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn"
                        class="w-full bg-green-500 hover:bg-green-600 text-white py-4 rounded-xl font-bold text-lg transition transform hover:scale-[1.02] shadow-lg">
                        স্বেচ্ছাসেবক হিসেবে নিবন্ধন করুন
                    </button>
                </form>
            </div>

            <!-- Candidate Info Card -->
            <div class="mt-8 bg-gradient-to-r from-blue-50 to-green-50 rounded-2xl p-6 border border-blue-100">
                <div class="flex items-center gap-4">
                    <img src="https://i.ibb.co.com/d0QMqCzV/Barrister-Nurul-Huda-Junaid.jpg"
                        alt="ব্যারিস্টার নুরুল হুদা জুনেদ" class="w-16 h-20 object-cover border-2 border-white shadow-lg">
                    <div>
                        <h4 class="font-bold text-gray-800">ব্যারিস্টার নুরুল হুদা জুনেদ</h4>
                        <p class="text-sm text-gray-600">সিলেট-৩ | জাতীয় নাগরিক পার্টি (NCP)</p>
                        <div class="flex items-center gap-2 mt-1">
                            <img src="https://www.ecs.gov.bd/bec/public/photos/1/political%20party%20pic/58-shapla-koli-protik.jpg"
                                alt="শাপলা কলি" class="w-5 h-5 rounded-full bg-white">
                            <span class="text-sm text-pink-600 font-medium">প্রতীক: শাপলা কলি</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="mt-6 text-center text-gray-600">
                <p class="mb-2">যে কোনো প্রয়োজনে যোগাযোগ করুন:</p>
                <div class="flex justify-center gap-6 flex-wrap">
                    <a href="tel:+8801XXXXXXXXX" class="flex items-center gap-2 hover:text-green-600">
                        <span>📞</span> ০১XXXXXXXXX
                    </a>
                    <a href="mailto:info@nurulhudajunaid.com" class="flex items-center gap-2 hover:text-green-600">
                        <span>✉️</span> info@nurulhudajunaid.com
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otherTeamCheckbox = document.getElementById('otherTeamCheckbox');
            const otherTeamInput = document.getElementById('otherTeamInput');

            if (otherTeamCheckbox && otherTeamInput) {
                otherTeamCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        otherTeamInput.classList.remove('hidden');
                    } else {
                        otherTeamInput.classList.add('hidden');
                    }
                });
            }

            // Form submission loading state
            const form = document.getElementById('volunteerForm');
            const submitBtn = document.getElementById('submitBtn');

            if (form && submitBtn) {
                form.addEventListener('submit', function() {
                    submitBtn.innerHTML =
                        '<span class="inline-block animate-spin mr-2">⏳</span> অপেক্ষা করুন...';
                    submitBtn.disabled = true;
                });
            }
        });
    </script>
@endpush
