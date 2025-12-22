<head>
    <title>@yield('title', 'Dashboard') - Volunteer App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="description"
        content="এই প্ল্যাটফর্মটি সিলেট-৩ আসনে ব্যারিস্টার নুরুল হুদা জুনেদ–এর সাথে স্বেচ্ছাসেবকদের সংগঠিত, সমন্বয় ও কার্যক্রম পরিচালনার জন্য তৈরি করা হয়েছে। এটি শুধুমাত্র অনুমোদিত ব্যবহারকারীদের জন্য। একসাথে, আমরা সিলেট-৩ এর জন্য একটি সুন্দর ভবিষ্যৎ গড়ে তুলতে চাই।" />
    <meta name="keywords"
        content="Volunteer Management System, Sylhet-3 Volunteer Platform, Barrister Nurul Huda Juned, volunteer registration system, political volunteer management, election campaign volunteers, volunteer coordination platform, campaign management system, grassroots volunteer network, Bangladesh election volunteers, civic engagement platform" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Volunteer Management Platform | Barrister Nurul Huda Juned | Sylhet-3">
    <meta property="og:url" content="https://ashikur-rahman.com" />
    <meta property="og:site_name" content="PRMS by Ashikur Rahman" />
    <link rel="canonical" href="https://ashikur-rahman.com" />
    <link rel="shortcut icon" href="{{ asset('img/58-shapla-koli-protik.webp') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> --}}
    <!--end::Fonts-->

    <!--begin::Vendor Stylesheets(used for this page only)-->
    @stack('page-css')
    <!--end::Vendor Stylesheets-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
</head>
