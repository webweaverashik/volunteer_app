<section id="faq" class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                ❓ সাধারণ প্রশ্নাবলী
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">প্রায়শই জিজ্ঞাসিত প্রশ্ন</h2>
            <div class="w-24 h-1 bg-green-500 mx-auto mb-4"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">স্বেচ্ছাসেবক হিসেবে যোগ দেওয়ার আগে আপনার মনে যে প্রশ্নগুলো আসতে পারে</p>
        </div>

        <div class="space-y-4" id="faqContainer">
            @foreach($faqs as $index => $faq)
            <div class="faq-item bg-white rounded-2xl card-shadow overflow-hidden">
                <button class="faq-question w-full px-6 py-5 text-left flex items-center justify-between gap-4 hover:bg-gray-50 transition">
                    <span class="font-bold text-gray-800 text-lg flex items-center gap-3">
                        <span class="w-10 h-10 bg-{{ $faq->color }}-100 rounded-full flex items-center justify-center text-{{ $faq->color }}-600 flex-shrink-0">{{ $index + 1 }}</span>
                        {{ $faq->question_bn }}
                    </span>
                    <svg class="faq-icon w-6 h-6 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="faq-answer px-6">
                    <div class="border-l-4 border-{{ $faq->color }}-200 pl-6 py-4 mb-5">
                        <p class="text-gray-600 leading-relaxed">{!! $faq->answer_bn !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl p-8 text-white text-center">
            <h3 class="text-2xl font-bold mb-3">আরও প্রশ্ন আছে?</h3>
            <p class="text-green-100 mb-6">আমাদের সাথে সরাসরি যোগাযোগ করুন!</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+8801XXXXXXXXX" class="inline-flex items-center justify-center gap-2 bg-white text-green-600 px-6 py-3 rounded-xl font-bold hover:bg-green-50 transition">
                    <span>📞</span> কল করুন
                </a>
                <a href="{{ route('volunteer.create') }}" class="inline-flex items-center justify-center gap-2 bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-xl font-bold transition border border-white/30">
                    <span>🤝</span> এখনই যোগ দিন
                </a>
            </div>
        </div>
    </div>
</section>
