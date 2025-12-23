<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ব্যারিস্টার নুরুল হুদা জুনেদ | সিলেট-৩ | জাতীয় নাগরিক পার্টি (NCP) | শাপলা কলি')</title>
    <link rel="shortcut icon" href="{{ asset('img/58-shapla-koli-protik.webp') }}" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Noto+Serif+Bengali:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home/css/app.css') }}">
    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    @include('layouts.partials.navigation')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- FAQ Section -->
    @hasSection('show_faq')
        @include('layouts.partials.faq')
    @endif

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- Scroll to Top Button -->
    <button id="scrollTopBtn" class="scroll-top-btn" aria-label="উপরে যান">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script src="{{ asset('home/js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
