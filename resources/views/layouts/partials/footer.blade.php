<footer class="bg-gray-900 text-white py-10">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center overflow-hidden p-1">
                        <img src="https://www.ecs.gov.bd/bec/public/photos/1/political%20party%20pic/58-shapla-koli-protik.jpg"
                            alt="শাপলা কলি - প্রতীক" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="font-bold">নুরুল হুদা জুনেদ</h3>
                        <p class="text-gray-400 text-sm">সিলেট-৩ | জাতীয় নাগরিক পার্টি (NCP)</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm">সিলেট-৩ আসনে একটি উন্নত ও সমৃদ্ধ সমাজ গঠনে আপনার পাশে।</p>
            </div>
            <div>
                <h4 class="font-bold mb-4">দ্রুত লিংক</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">হোম</a></li>
                    <li><a href="{{ route('home') }}#about" class="hover:text-white transition">পরিচিতি</a></li>
                    <li><a href="{{ route('volunteer.create') }}" class="hover:text-white transition">স্বেচ্ছাসেবক</a></li>
                    <li><a href="#faq" class="hover:text-white transition">প্রায়শই জিজ্ঞাসিত প্রশ্ন</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">যোগাযোগ</h4>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-center gap-2"><span>📍</span> সিলেট-৩, বাংলাদেশ</li>
                    <li class="flex items-center gap-2"><span>📞</span> ০১XXXXXXXXX</li>
                    <li class="flex items-center gap-2"><span>✉️</span> info@nurulhudajuned.com</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-6 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} ব্যারিস্টার নুরুল হুদা জুনেদ | সিলেট-৩ | জাতীয় নাগরিক পার্টি (NCP)। সর্বস্বত্ব সংরক্ষিত।</p>
        </div>
    </div>
</footer>
