@extends('layouts.app')

@section('title', 'ব্যারিস্টার নুরুল হুদা জুনেদ | সিলেট-৩ | জাতীয় নাগরিক পার্টি (NCP) | শাপলা কলি')

@section('show_faq', true)

@section('content')
    <!-- Hero Section with Banner Image -->
    <section class="relative min-h-[90svh] flex items-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://i.ibb.co.com/bMGVrLQX/hero-image.png" alt="Hero Background" class="w-full h-full object-cover">
            <!-- Light Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 via-blue-900/50 to-blue-900/30"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 max-w-6xl mx-auto px-4 py-16 md:py-24 w-full">
            <div class="flex flex-col">
                <!-- Text Content -->
                <div class="text-white max-w-3xl">
                    <!-- Constituency Badge -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <div class="inline-flex items-center gap-2 constituency-badge text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                            <span>🗳️</span>
                            <span>সিলেট-৩ নির্বাচনী এলাকা</span>
                        </div>
                        <div class="inline-flex items-center gap-2 bg-green-500/20 border border-green-400/30 text-green-300 px-4 py-2 rounded-full text-sm font-semibold backdrop-blur-sm">
                            <img src="https://www.ecs.gov.bd/bec/public/photos/1/political%20party%20pic/58-shapla-koli-protik.jpg" alt="শাপলা কলি" class="w-6 h-6 rounded-full bg-white p-0.5">
                            <span>জাতীয় নাগরিক পার্টি (NCP)</span>
                        </div>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">
                        ব্যারিস্টার<br>
                        <span class="text-green-400 drop-shadow-lg">নুরুল হুদা জুনেদ</span>
                    </h1>
                    <p class="text-md text-pink-300 mb-6 font-semibold flex items-center gap-2">
                        <img src="https://www.ecs.gov.bd/bec/public/photos/1/political%20party%20pic/58-shapla-koli-protik.jpg" alt="শাপলা কলি" class="w-5 h-5 rounded-full bg-white p-0.5">
                        প্রতীক: শাপলা কলি | সিলেট-৩
                    </p>
                    <p class="text-lg text-blue-100/90 mb-8 max-w-2xl leading-relaxed">
                        সিলেট-৩ আসনে একটি উন্নত, সমৃদ্ধ ও ন্যায়ভিত্তিক সমাজ গঠনে আপনার পাশে আছি। আসুন, একসাথে গড়ি নতুন বাংলাদেশ।
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('volunteer.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition transform hover:scale-105 shadow-lg flex items-center justify-center gap-2">
                            <span>🤝</span> স্বেচ্ছাসেবক হিসেবে যোগ দিন
                        </a>
                        <a href="#about" class="border-2 border-white/40 hover:bg-white/10 text-white px-8 py-4 rounded-xl font-bold text-lg transition text-center backdrop-blur-sm">
                            আরও জানুন
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
            <a href="#about" class="text-white/70 hover:text-white transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </a>
        </div>
    </section>

    <!-- Election Symbol Section -->
    @include('home.partials.symbol')

    <!-- About Section -->
    @include('home.partials.about')

    <!-- Vision Section -->
    @include('home.partials.manifesto')

    <!-- Volunteer Teams Section -->
    @include('home.partials.teams')

    <!-- CTA Section -->
    @include('home.partials.cta')
@endsection
