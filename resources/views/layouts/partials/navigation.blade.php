<nav class="gradient-bg text-white sticky top-0 z-50 shadow-lg">
    <div class="max-w-6xl mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center overflow-hidden p-1">
                    <img src="{{ asset('img/58-shapla-koli-protik.webp') }}"
                        alt="শাপলা কলি - প্রতীক" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-lg font-bold leading-tight">ব্যারিস্টার নুরুল হুদা জুনেদ</h1>
                    <p class="text-xs text-blue-200">সিলেট-৩ | জাতীয় নাগরিক পার্টি (NCP)</p>
                </div>
            </a>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="nav-btn px-4 py-2 rounded-lg hover:bg-white/20 transition {{ request()->routeIs('home') ? 'bg-white/20' : '' }}">
                    হোম
                </a>
                <a href="{{ route('volunteer.create') }}" class="nav-btn bg-green-500 hover:bg-green-600 px-4 py-2 rounded-lg transition font-semibold">
                    স্বেচ্ছাসেবক হোন
                </a>
            </div>
        </div>
    </div>
</nav>
