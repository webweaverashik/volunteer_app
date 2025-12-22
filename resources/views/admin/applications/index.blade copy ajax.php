@extends('admin.layouts.app')

@push('page-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', 'All Applications')

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            All Applications
        </h1>
        <!--end::Title-->
        <!--begin::Separator-->
        <span class="h-20px border-gray-300 border-start mx-4"></span>
        <!--end::Separator-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 ">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="#" class="text-muted text-hover-primary">
                    Volunteer </a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-500 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                Form Submission </li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between gap-3">

            <input type="text" data-all-applications-table-filter="search" class="form-control w-300px"
                placeholder="খুঁজুন">

            <div data-all-applications-table-filter="form" class="d-flex gap-2">
                <select name="sylhet3_resident" class="form-select">
                    <option value="">সিলেট-৩ এর অধিবাসী</option>
                    <option value="1">হ্যাঁ</option>
                    <option value="0">না</option>
                </select>


                <select name="upazila_id" class="form-select">
                    <option value="">উপজেলা</option>
                    @foreach ($upazilas as $u)
                        <option value="{{ $u->id }}">{{ $u->name_bn }}</option>
                    @endforeach
                </select>

                <select name="occupation_id" class="form-select">
                    <option value="">পেশা</option>
                    @foreach ($occupations as $o)
                        <option value="{{ $o->id }}">{{ $o->name_bn }}</option>
                    @endforeach
                </select>


                <select name="team_id" class="form-select">
                    <option value="">টিম</option>
                    @foreach ($teams as $t)
                        <option value="{{ $t->id }}">{{ $t->name_bn }}</option>
                    @endforeach
                </select>

                <select name="weekly_hours" class="form-select">
                    <option value="">সাপ্তাহিক সময়</option>
                    <option value="1-4">১-৪ ঘন্টা</option>
                    <option value="5-8">৫-৮ ঘন্টা</option>
                    <option value="9-12">৯-১২ ঘন্টা</option>
                    <option value="12+">১২ ঘন্টা +</option>
                </select>

                <select name="preferred_time" class="form-select">
                    <option value="">পছন্দের সময়</option>
                    <option value="morning">সকাল</option>
                    <option value="noon">দুপুর</option>
                    <option value="afternoon">বিকাল</option>
                    <option value="evening">সন্ধ্যা</option>
                    <option value="anytime">যেকোনো সময়</option>
                </select>


                <select name="status" class="form-select">
                    <option value="">স্ট্যাটাস</option>
                    <option value="pending">পেন্ডিং</option>
                    <option value="approved">গৃহীত</option>
                    <option value="rejected">বাদ</option>
                </select>

                <button class="btn btn-primary" data-all-applications-table-filter="filter">ফিল্টার</button>
                <button class="btn btn-light" data-all-applications-table-filter="reset">রিসেট</button>
                <button class="btn btn-success" data-row-export="excel">Excel</button>
            </div>
        </div>

        <div class="card-body">
            <table id="kt_all_applications_table"
                class="table table-hover table-row-dashed align-middle fs-6 gy-5 volunteer-table"
                data-ajax-url="{{ route('applications.data') }}">
                <thead>
                    <tr class="fw-bold fs-6 gs-0">
                        <th>#</th>
                        <th>নাম</th>
                        <th>মোবাইল</th>
                        <th>NID</th>
                        <th>সিলেট-৩</th>
                        <th>উপজেলা</th>
                        <th>ইউনিয়ন</th>
                        <th>ঠিকানা</th>
                        <th>ভোট কেন্দ্র</th>
                        <th>বয়স</th>
                        <th>পেশা</th>
                        <th>কাজ</th>
                        <th>রেফারেন্স</th>
                        <th>সাপ্তাহিক সময়</th>
                        <th>পছন্দের সময়</th>
                        <th>মন্তব্য</th>
                        <th>স্ট্যাটাস</th>
                        <th class="w-100px">##</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 fw-semibold">
                </tbody>
            </table>
        </div>
    </div>
@endsection


@push('vendor-js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush

@push('page-js')
    <script>
        window.APPLICATION_STATUS_URL = "{{ route('applications.updateStatus', ':id') }}";
        window.CSRF_TOKEN = "{{ csrf_token() }}";
    </script>

    <script src="{{ asset('admin/js/applications/index.js') }}"></script>

    <script>
        document.getElementById("all_applications_menu").classList.add("active");
    </script>
@endpush
