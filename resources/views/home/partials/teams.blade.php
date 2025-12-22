<section id="teams" class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">স্বেচ্ছাসেবক টিমসমূহ</h2>
            <div class="w-24 h-1 bg-green-500 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">সিলেট-৩ আসনে আমাদের বিভিন্ন টিমে যোগ দিয়ে পরিবর্তনের অংশীদার হোন।</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($teams->take(8) as $team)
            <a href="{{ route('volunteer.create') }}" class="team-card bg-white rounded-2xl card-shadow overflow-hidden hover:transform hover:scale-105 transition group cursor-pointer block">
                <div class="h-32 bg-gradient-to-br from-{{ $team->color }}-500 to-{{ $team->color }}-700 flex items-center justify-center">
                    <span class="text-6xl">{{ $team->icon }}</span>
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $team->name_bn }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ $team->description_bn }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs bg-{{ $team->color }}-100 text-{{ $team->color }}-700 px-3 py-1 rounded-full">{{ $team->member_count }} সদস্য</span>
                        <span class="text-green-600 text-sm font-semibold">যোগ দিন →</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-12 text-center">
            <a href="{{ route('volunteer.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition transform hover:scale-105 shadow-lg inline-flex items-center gap-2">
                <span>🤝</span> যেকোনো টিমে যোগ দিন
            </a>
        </div>
    </div>
</section>
