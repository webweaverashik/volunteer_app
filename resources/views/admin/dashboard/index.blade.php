@extends('admin.layouts.app')

@push('page-css')
    <style>
        .stat-card {
            border-radius: 12px;
            border: none;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-value {
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .stat-label {
            font-size: 1rem;
            color: #64748b;
            font-weight: 500;
        }

        .chart-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .chart-card .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
            border-radius: 12px 12px 0 0;
        }

        .chart-card .card-title {
            font-weight: 600;
            color: #1e293b;
            margin: 0;
            font-size: 1.125rem;
        }

        .nav-month .btn {
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
        }

        .nav-month .current-period {
            font-weight: 600;
            min-width: 180px;
            text-align: center;
            font-size: 1rem;
        }

        .team-stat {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            background: #f8fafc;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .team-stat:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
        }

        .team-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .team-stat-value {
            font-weight: 700;
            font-size: 1.5rem;
            color: #1e293b;
        }

        .team-stat-label {
            font-size: 0.95rem;
            color: #64748b;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }

        .legend-color {
            width: 14px;
            height: 14px;
            border-radius: 4px;
            margin-right: 0.75rem;
        }

        .legend-label {
            font-size: 1rem;
            color: #64748b;
        }

        .legend-value {
            font-weight: 600;
            margin-left: auto;
            color: #1e293b;
            font-size: 1rem;
        }

        .view-toggle .btn {
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
        }

        .view-toggle .btn.active {
            background: var(--bs-primary);
            color: white;
            border-color: var(--bs-primary);
        }

        .table-card .table th {
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            padding: 1rem 0.75rem;
        }

        .table-card .table td {
            vertical-align: middle;
            color: #334155;
            font-size: 1rem;
            padding: 0.875rem 0.75rem;
        }

        .table-card .table tbody tr {
            border-bottom: 1px dashed #e4e6ef;
        }

        .table-card .table tbody tr:last-child {
            border-bottom: 0;
        }

        .table-card .table-responsive::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .table-card .table-responsive::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .table-card .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .nav-tabs-custom .nav-link {
            font-size: 1rem;
            padding: 0.75rem 1.25rem;
            color: #64748b;
            border: none;
            border-bottom: 2px solid transparent;
        }

        .nav-tabs-custom .nav-link.active {
            color: var(--bs-primary);
            border-bottom-color: var(--bs-primary);
            background: transparent;
        }

        .nav-tabs-custom .nav-link:hover:not(.active) {
            color: #1e293b;
            border-bottom-color: #e2e8f0;
        }

        .chart-tab-content {
            min-height: 350px;
        }

        .chart-container {
            position: relative;
            height: 320px;
        }

        .chart-container-sm {
            position: relative;
            height: 280px;
        }

        .data-table-sm .table td,
        .data-table-sm .table th {
            padding: 0.625rem 0.5rem;
            font-size: 0.95rem;
        }
    </style>
@endpush

@section('title', 'ড্যাশবোর্ড')

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            <i class="ki-outline ki-graph-up fs-2 me-2 text-primary"></i>
            ড্যাশবোর্ড
        </h1>
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">হোম</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-500 w-5px h-2px"></span>
            </li>
            <li class="breadcrumb-item text-muted">অভারভিউ</li>
        </ul>
    </div>
@endsection

@section('content')
    <!--begin::Stats Cards Row-->
    <div class="row g-5 g-xl-8 mb-5 mb-xl-8">
        <!--begin::Total Card-->
        <div class="col-xl-3 col-6">
            <div class="card stat-card bg-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary me-4">
                            <i class="ki-outline ki-people fs-2x"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="stat-value text-primary" data-counter="{{ $stats['total'] }}">০</div>
                            <div class="stat-label">মোট আবেদন</div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary bg-opacity-10 text-primary fs-7">
                                <i class="ki-outline ki-arrow-up fs-8 me-1"></i>১০০%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Total Card-->

        <!--begin::Pending Card-->
        <div class="col-xl-3 col-6">
            <div class="card stat-card bg-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning me-4">
                            <i class="ki-outline ki-time fs-2x"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="stat-value text-warning" data-counter="{{ $stats['pending'] }}">০</div>
                            <div class="stat-label">পেন্ডিং</div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-warning bg-opacity-10 text-warning fs-7">
                                {{ $stats['total'] > 0 ? toBengaliNumber(round(($stats['pending'] / $stats['total']) * 100)) : '০' }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Pending Card-->

        <!--begin::Approved Card-->
        <div class="col-xl-3 col-6">
            <div class="card stat-card bg-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success bg-opacity-10 text-success me-4">
                            <i class="ki-outline ki-check-circle fs-2x"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="stat-value text-success" data-counter="{{ $stats['approved'] }}">০</div>
                            <div class="stat-label">গৃহীত</div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success bg-opacity-10 text-success fs-7">
                                {{ $stats['total'] > 0 ? toBengaliNumber(round(($stats['approved'] / $stats['total']) * 100)) : '০' }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Approved Card-->

        <!--begin::Rejected Card-->
        <div class="col-xl-3 col-6">
            <div class="card stat-card bg-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-danger bg-opacity-10 text-danger me-4">
                            <i class="ki-outline ki-cross-circle fs-2x"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="stat-value text-danger" data-counter="{{ $stats['rejected'] }}">০</div>
                            <div class="stat-label">বাদ</div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-danger bg-opacity-10 text-danger fs-7">
                                {{ $stats['total'] > 0 ? toBengaliNumber(round(($stats['rejected'] / $stats['total']) * 100)) : '০' }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Rejected Card-->
    </div>
    <!--end::Stats Cards Row-->

    <!--begin::Teams Section (Moved here after stats)-->
    <div class="row g-5 g-xl-8 mb-5 mb-xl-8">
        <div class="col-12">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="ki-outline ki-people fs-2 me-2 text-primary"></i>
                        কাজ ভিত্তিক আবেদন
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @php
                            $teamsTotal = $teamsStats->sum('count');
                        @endphp
                        @forelse($teamsStats as $team)
                            @php
                                $percent = $teamsTotal > 0 ? round(($team['count'] / $teamsTotal) * 100) : 0;
                            @endphp
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="team-stat">
                                    <div class="team-stat-icon"
                                        style="background: {{ $team['color'] }}20; color: {{ $team['color'] }}">
                                        <i class="ki-outline {{ $team['icon'] }} fs-2"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="team-stat-value">{{ toBengaliNumber($team['count']) }}</div>
                                        <div class="team-stat-label">{{ $team['name'] }}</div>
                                    </div>
                                    <div>
                                        <span class="badge fs-7"
                                            style="background: {{ $team['color'] }}15; color: {{ $team['color'] }}">{{ toBengaliNumber($percent) }}%</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-4 fs-6">কোন তথ্য পাওয়া যায়নি</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Teams Section-->

    <!--begin::Charts Row 1-->
    <div class="row g-5 g-xl-8 mb-5 mb-xl-8">
        <!--begin::Trend Chart-->
        <div class="col-xl-8">
            <div class="card chart-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="card-title">
                        <i class="ki-outline ki-chart-simple fs-2 me-2 text-primary"></i>
                        আবেদন প্রবণতা
                    </h5>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="view-toggle btn-group" role="group">
                            <button type="button" class="btn btn-outline-secondary active" data-view="daily">দৈনিক</button>
                            <button type="button" class="btn btn-outline-secondary" data-view="monthly">মাসিক</button>
                        </div>
                        <div class="nav-month d-flex align-items-center gap-2">
                            <button class="btn btn-outline-secondary" id="prevPeriod">
                                <i class="ki-outline ki-left fs-4"></i>
                            </button>
                            <span class="current-period" id="currentPeriod"></span>
                            <button class="btn btn-outline-secondary" id="nextPeriod">
                                <i class="ki-outline ki-right fs-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="height: 100%;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Trend Chart-->

        <!--begin::Sylhet-3 Resident Chart-->
        <div class="col-xl-4">
            <div class="card chart-card h-100">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="ki-outline ki-geolocation fs-2 me-2 text-info"></i>
                        সিলেট-৩ বাসিন্দা
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="flex-grow-1 d-flex align-items-center justify-content-center" style="height: 250px;">
                        <canvas id="residentChart"></canvas>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <div class="legend-item">
                            <div class="legend-color" style="background: #43a047;"></div>
                            <span class="legend-label">সিলেট-৩ বাসিন্দা</span>
                            <span class="legend-value">{{ toBengaliNumber($sylhet3Stats['yes']) }}</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background: #fb8c00;"></div>
                            <span class="legend-label">অন্য এলাকার</span>
                            <span class="legend-value">{{ toBengaliNumber($sylhet3Stats['no']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Sylhet-3 Resident Chart-->
    </div>
    <!--end::Charts Row 1-->

    <!--begin::Charts Row 2 with Tabs-->
    <div class="row g-5 g-xl-8 mb-5 mb-xl-8">
        <!--begin::Age Range Chart with Tab-->
        <div class="col-xl-4">
            <div class="card chart-card h-100">
                <div class="card-header border-0 pt-4 pb-0">
                    <ul class="nav nav-tabs nav-tabs-custom nav-line-tabs nav-line-tabs-2x border-0 fs-6 fw-semibold"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#age_chart_tab" role="tab">
                                <i class="ki-outline ki-chart-pie-3 fs-4 me-1"></i> চার্ট
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#age_table_tab" role="tab">
                                <i class="ki-outline ki-row-horizontal fs-4 me-1"></i> তালিকা
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <h6 class="text-gray-800 fw-bold mb-4">
                        <i class="ki-outline ki-calendar fs-4 me-2 text-purple"></i>
                        বয়স পরিসীমা
                    </h6>
                    <div class="tab-content chart-tab-content">
                        <div class="tab-pane fade show active" id="age_chart_tab" role="tabpanel">
                            <canvas id="ageChart" height="280"></canvas>
                        </div>
                        <div class="tab-pane fade" id="age_table_tab" role="tabpanel">
                            <div class="table-responsive data-table-sm">
                                <table class="table table-hover table-row-bordered align-middle gs-0 gy-2 mb-0">
                                    <thead>
                                        <tr class="fw-bold text-muted bg-light">
                                            <th class="ps-4 rounded-start">বয়স পরিসীমা</th>
                                            <th class="text-center">আবেদন</th>
                                            <th class="text-end pe-4 rounded-end">শতাংশ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $ageTotal = array_sum($ageRanges);
                                        @endphp
                                        @foreach ($ageRanges as $range => $count)
                                            @php
                                                $percent = $ageTotal > 0 ? round(($count / $ageTotal) * 100) : 0;
                                            @endphp
                                            <tr>
                                                <td class="ps-4 fw-semibold text-gray-800">{{ $range }}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-light-primary fs-7 fw-bold">{{ toBengaliNumber($count) }}</span>
                                                </td>
                                                <td class="text-end pe-4 text-gray-600 fw-semibold">
                                                    {{ toBengaliNumber($percent) }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Age Range Chart-->

        <!--begin::Weekly Hours Chart with Tab-->
        <div class="col-xl-4">
            <div class="card chart-card h-100">
                <div class="card-header border-0 pt-4 pb-0">
                    <ul class="nav nav-tabs nav-tabs-custom nav-line-tabs nav-line-tabs-2x border-0 fs-6 fw-semibold"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#hours_chart_tab" role="tab">
                                <i class="ki-outline ki-chart-pie-3 fs-4 me-1"></i> চার্ট
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#hours_table_tab" role="tab">
                                <i class="ki-outline ki-row-horizontal fs-4 me-1"></i> তালিকা
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <h6 class="text-gray-800 fw-bold mb-4">
                        <i class="ki-outline ki-time fs-4 me-2 text-success"></i>
                        সাপ্তাহিক সময়
                    </h6>
                    <div class="tab-content chart-tab-content">
                        <div class="tab-pane fade show active" id="hours_chart_tab" role="tabpanel">
                            <canvas id="hoursChart" height="280"></canvas>
                        </div>
                        <div class="tab-pane fade" id="hours_table_tab" role="tabpanel">
                            <div class="table-responsive data-table-sm">
                                <table class="table table-hover table-row-bordered align-middle gs-0 gy-2 mb-0">
                                    <thead>
                                        <tr class="fw-bold text-muted bg-light">
                                            <th class="ps-4 rounded-start">সময়কাল</th>
                                            <th class="text-center">আবেদন</th>
                                            <th class="text-end pe-4 rounded-end">শতাংশ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $hoursTotal = array_sum($weeklyHoursStats);
                                        @endphp
                                        @foreach ($weeklyHoursStats as $hours => $count)
                                            @php
                                                $percent = $hoursTotal > 0 ? round(($count / $hoursTotal) * 100) : 0;
                                            @endphp
                                            <tr>
                                                <td class="ps-4 fw-semibold text-gray-800">{{ $hours }}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-light-success fs-7 fw-bold">{{ toBengaliNumber($count) }}</span>
                                                </td>
                                                <td class="text-end pe-4 text-gray-600 fw-semibold">
                                                    {{ toBengaliNumber($percent) }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Weekly Hours Chart-->

        <!--begin::Preferred Time Chart with Tab-->
        <div class="col-xl-4">
            <div class="card chart-card h-100">
                <div class="card-header border-0 pt-4 pb-0">
                    <ul class="nav nav-tabs nav-tabs-custom nav-line-tabs nav-line-tabs-2x border-0 fs-6 fw-semibold"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#time_chart_tab" role="tab">
                                <i class="ki-outline ki-chart-pie-3 fs-4 me-1"></i> চার্ট
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#time_table_tab" role="tab">
                                <i class="ki-outline ki-row-horizontal fs-4 me-1"></i> তালিকা
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <h6 class="text-gray-800 fw-bold mb-4">
                        <i class="ki-outline ki-sun fs-4 me-2 text-warning"></i>
                        পছন্দের সময়
                    </h6>
                    <div class="tab-content chart-tab-content">
                        <div class="tab-pane fade show active" id="time_chart_tab" role="tabpanel">
                            <canvas id="timeChart" height="280"></canvas>
                        </div>
                        <div class="tab-pane fade" id="time_table_tab" role="tabpanel">
                            <div class="table-responsive data-table-sm">
                                <table class="table table-hover table-row-bordered align-middle gs-0 gy-2 mb-0">
                                    <thead>
                                        <tr class="fw-bold text-muted bg-light">
                                            <th class="ps-4 rounded-start">সময়</th>
                                            <th class="text-center">আবেদন</th>
                                            <th class="text-end pe-4 rounded-end">শতাংশ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $timeTotal = array_sum($preferredTimeStats);
                                        @endphp
                                        @foreach ($preferredTimeStats as $time => $count)
                                            @php
                                                $percent = $timeTotal > 0 ? round(($count / $timeTotal) * 100) : 0;
                                            @endphp
                                            <tr>
                                                <td class="ps-4 fw-semibold text-gray-800">{{ $time }}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-light-warning fs-7 fw-bold">{{ toBengaliNumber($count) }}</span>
                                                </td>
                                                <td class="text-end pe-4 text-gray-600 fw-semibold">
                                                    {{ toBengaliNumber($percent) }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Preferred Time Chart-->
    </div>
    <!--end::Charts Row 2-->

    <!--begin::Tables Row-->
    <div class="row g-5 g-xl-8 mb-5 mb-xl-8">
        <!--begin::Upazila Table-->
        <div class="col-xl-6">
            <div class="card table-card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0 fs-5">
                        <i class="ki-outline ki-geolocation-home fs-2 me-2 text-danger"></i>
                        উপজেলা ভিত্তিক আবেদন
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover table-row-bordered align-middle gs-0 gy-3 mb-0">
                            <thead>
                                <tr class="fw-bold text-muted bg-light">
                                    <th class="ps-4 rounded-start">উপজেলা</th>
                                    <th class="text-center">আবেদন</th>
                                    <th class="text-end pe-4 rounded-end">শতাংশ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $upazilaTotal = $upazilaStats->sum('count');
                                @endphp
                                @forelse($upazilaStats as $upazila)
                                    @php
                                        $percent =
                                            $upazilaTotal > 0 ? round(($upazila['count'] / $upazilaTotal) * 100) : 0;
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-semibold text-gray-800">{{ $upazila['name'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-light-primary fs-7 fw-bold">{{ toBengaliNumber($upazila['count']) }}</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <span
                                                class="text-gray-600 fw-semibold">{{ toBengaliNumber($percent) }}%</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4 fs-6">কোন তথ্য পাওয়া যায়নি
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Upazila Table-->

        <!--begin::Occupation Table-->
        <div class="col-xl-6">
            <div class="card table-card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0 fs-5">
                        <i class="ki-outline ki-briefcase fs-2 me-2 text-info"></i>
                        পেশা ভিত্তিক আবেদন (শীর্ষ ১০)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover table-row-bordered align-middle gs-0 gy-3 mb-0">
                            <thead>
                                <tr class="fw-bold text-muted bg-light">
                                    <th class="ps-4 rounded-start" style="width: 50px;">#</th>
                                    <th>পেশা</th>
                                    <th class="text-center" style="width: 90px;">আবেদন</th>
                                    <th class="text-end pe-4 rounded-end" style="width: 90px;">শতাংশ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $occupationTotal = $occupationStats->sum('count');
                                    $colors = [
                                        '#e53935',
                                        '#1e88e5',
                                        '#43a047',
                                        '#fb8c00',
                                        '#8e24aa',
                                        '#00acc1',
                                        '#5c6bc0',
                                        '#26a69a',
                                        '#ec407a',
                                        '#78909c',
                                    ];
                                @endphp
                                @forelse($occupationStats as $index => $occupation)
                                    @php
                                        $percent =
                                            $occupationTotal > 0
                                                ? round(($occupation['count'] / $occupationTotal) * 100)
                                                : 0;
                                        $color = $colors[$index] ?? '#78909c';
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <span class="badge fs-7 fw-bold"
                                                style="background: {{ $color }}20; color: {{ $color }}">{{ toBengaliNumber($index + 1) }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-gray-800">{{ $occupation['name'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge badge-light-info fs-7 fw-bold">{{ toBengaliNumber($occupation['count']) }}</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <span
                                                class="text-gray-600 fw-semibold">{{ toBengaliNumber($percent) }}%</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4 fs-6">কোন তথ্য পাওয়া যায়নি
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Occupation Table-->
    </div>
    <!--end::Tables Row-->
@endsection

@push('vendor-js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('page-js')
    <script>
        // Dashboard data from Laravel
        window.dashboardConfig = {
            sylhet3Stats: @json($sylhet3Stats),
            ageRanges: @json($ageRanges),
            weeklyHoursStats: @json($weeklyHoursStats),
            preferredTimeStats: @json($preferredTimeStats),
            dailyTrend: @json($dailyTrend),
            monthlyTrend: @json($monthlyTrend),
            currentMonth: {{ $currentMonth }},
            currentYear: {{ $currentYear }},
            trendDataUrl: "{{ route('dashboard.trend') }}"
        };
    </script>
    <script src="{{ asset('admin/js/dashboard/index.js') }}"></script>
@endpush
