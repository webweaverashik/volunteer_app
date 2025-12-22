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
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i> <input type="text"
                        data-all-applications-table-filter="search"
                        class="form-control form-control-solid w-250px w-lg-450px ps-12"
                        placeholder="আবেদনগুলোর মধ্যে খুঁজুন">
                </div>
                <!--end::Search-->

                <!--begin::Export hidden buttons-->
                <div id="kt_hidden_export_buttons" class="d-none"></div>
                <!--end::Export buttons-->

            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-all-reports-table-toolbar="base">
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">
                        <i class="ki-outline ki-filter fs-2"></i>ফিল্টার</button>
                    <!--begin::Menu 1-->
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-450px" data-kt-menu="true">
                        <!--begin::Header-->
                        <div class="px-7 py-5">
                            <div class="fs-5 text-gray-900 fw-bold">ফিল্টার অপশন</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Separator-->
                        <div class="separator border-gray-200"></div>
                        <!--end::Separator-->
                        <!--begin::Content-->
                        <div class="px-7 py-5" data-all-applications-table-filter="form">
                            <div class="row">
                                <div class="col-6 mb-5">
                                    <label class="form-label fs-6 fw-semibold">উপজেলা:</label>
                                    <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                        data-placeholder="সিলেক্ট করুন" data-allow-clear="true"
                                        data-all-applications-table-filter="status" data-hide-search="true">
                                        <option></option>
                                        {{-- @foreach ($upazilas as $upazila)
                                            <option value="{{ $upazila->id }}_{{ $upazila->name }}">{{ $upazila->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>

                                <div class="col-6 mb-5">
                                    <label class="form-label fs-6 fw-semibold">প্রোগ্রামের ধরণ:</label>
                                    <select class="form-select form-select-solid fw-bold" data-kt-select2="true"
                                        data-placeholder="সিলেক্ট করুন" data-allow-clear="true"
                                        data-all-applications-table-filter="status" data-hide-search="false">
                                        <option></option>
                                        {{-- @foreach ($programTypes as $type)
                                            <option value="{{ $type->id }}_{{ $type->name }}">{{ $type->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>

                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end mt-5">
                                <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6"
                                    data-kt-menu-dismiss="true" data-all-applications-table-filter="reset">রিসেট</button>
                                <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true"
                                    data-all-applications-table-filter="filter">এপ্লাই</button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Menu 1-->

                    <!--begin::Export dropdown-->
                    <div class="dropdown">
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-exit-up fs-2"></i>এক্সপোর্ট
                        </button>

                        <!--begin::Menu-->
                        <div id="kt_table_application_dropdown_menu"
                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-row-export="copy">ক্লিপবোর্ডে কপি করুন</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-row-export="excel">Excel ফাইল ডাউনলোড</a>
                            </div>
                            {{-- <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-row-export="csv">CSV ফাইল ডাউনলোড</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3" data-row-export="pdf">PDF ফাইল ডাউনলোড</a>
                            </div> --}}
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Export dropdown-->

                    <!--end::Filter-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table table-hover align-middle table-row-dashed fs-6 gy-5 volunteer-table"
                id="kt_all_applications_table">

                <thead>
                    <tr class="fw-bold fs-6 gs-0">
                        <th>#</th>
                        <th>পূর্ণ নাম</th>
                        <th>মোবাইল নং</th>
                        <th>এনআইডি নং</th>
                        <th>সিলেট-৩ আসনের অধিবাসী</th>
                        <th>উপজেলা</th>
                        <th>ইউনিয়ন</th>
                        <th>ঠিকানা</th>
                        <th>ভোটকেন্দ্র</th>
                        <th>বয়স</th>
                        <th>পেশা</th>
                        <th>কোন কাজে আগ্রহী</th>
                        <th>রেফারেন্স</th>
                        <th>প্রতি সপ্তাহে সময়</th>
                        <th>কখন সময় দিতে পারবে</th>
                        <th>মন্তব্য</th>
                        <th>অবস্থা</th>
                        <th class="not-export w-100px">##</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800 fw-semibold">
                    @php
                        use Rakibhstu\Banglanumber\NumberToBangla;
                        $numto = new NumberToBangla();
                    @endphp

                    @foreach ($applications as $application)
                        <tr>
                            <td>{{ $numto->bnNum($loop->iteration) }}</td>

                            <td>{{ $application->full_name }}</td>

                            <td>{{ $numto->bnNum($application->mobile) }}</td>

                            <td>{{ $application->nid ? $numto->bnNum($application->nid) : '-' }}</td>

                            <td>
                                {{ $application->sylhet3_resident ? 'হ্যাঁ' : 'না' }}
                            </td>

                            <td>{{ $application->upazila?->name_bn ?? '-' }}</td>

                            <td>{{ $application->union_name }}</td>

                            <td>{{ $application->current_address }}</td>

                            <td>{{ $application->voting_center ?? '-' }}</td>

                            <td>{{ $numto->bnNum($application->age) }}</td>

                            <td>{{ $application->occupation?->name_bn ?? '-' }}</td>

                            {{-- Interested Teams --}}
                            <td>
                                @if ($application->teams->count())
                                    @foreach ($application->teams as $team)
                                        <div>- {{ $team->name_bn }}</div>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>


                            <td>{{ $application->reference ?? '-' }}</td>

                            <td>{{ $application->weekly_hours_label }}</td>

                            <td>{{ $application->preferred_time_label }}</td>

                            <td>
                                @if ($application->comments)
                                    {{-- Visible (UI) --}}
                                    <a href="#" class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#commentModal{{ $application->id }}" title="মন্তব্য দেখুন">
                                        <i class="bi bi-eye fs-4"></i>
                                    </a>

                                    {{-- Hidden text for DataTables export --}}
                                    <span class="d-none export-comment">
                                        {{ $application->comments }}
                                    </span>

                                    {{-- Modal --}}
                                    <div class="modal fade" id="commentModal{{ $application->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header py-3">
                                                    <h5 class="modal-title fs-6">মন্তব্য</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body fs-6 text-gray-800">
                                                    {{ $application->comments }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    -
                                @endif
                            </td>


                            {{-- Status --}}
                            <td>
                                @php
                                    $statusMap = [
                                        'approved' => ['label' => 'গৃহীত', 'class' => 'badge-success'],
                                        'rejected' => ['label' => 'বাদ', 'class' => 'badge-danger'],
                                        'pending' => ['label' => 'পেন্ডিং', 'class' => 'badge-warning'],
                                    ];
                                @endphp

                                <span class="badge {{ $statusMap[$application->status]['class'] }}">
                                    {{ $statusMap[$application->status]['label'] }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                @if ($application->status === 'pending')
                                    <a href="#"
                                        class="btn btn-icon btn-sm btn-active-light-success btn-color-success"
                                        data-bs-toggle="tooltip" title="এপ্রুভ"><i
                                            class="bi bi-check2-circle fs-3"></i></a>
                                    <a href="#" class="btn btn-icon btn-sm btn-active-light-danger btn-color-danger"
                                        data-bs-toggle="tooltip" title="রিজেক্ট"> <i class="bi bi-x-circle fs-3"></i>
                                    </a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
@endsection


@push('vendor-js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush

@push('page-js')
    <script src="{{ asset('admin/js/applications/index.js') }}"></script>

    <script>
        document.getElementById("all_applications_menu").classList.add("active");
    </script>
@endpush
