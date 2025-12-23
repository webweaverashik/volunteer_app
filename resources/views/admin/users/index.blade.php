@extends('admin.layouts.app')

@push('page-css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', 'সকল ইউজার')

@section('header-title')
    <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
            সকল ইউজার
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
                    ইউজার ব্যবস্থাপনা </a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-500 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                ইউজার তালিকা </li>
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
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5">
                    </i>
                    <input type="text" data-kt-user-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="ইউজার অনুসন্ধান করুন" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-all-user-table-filter="base">
                    <!--begin::Add user-->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        <i class="ki-outline ki-plus fs-2"></i>নতুন ইউজার</a>
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table table-hover align-middle table-row-dashed fs-6 gy-5 volunteer-table" id="kt_table_users">
                <thead>
                    <tr class="fw-bold fs-5 gs-0">
                        <th class="w-25px">#</th>
                        <th>ইউজারের তথ্য</th>
                        <th>ইমেইল</th>
                        <th>সর্বশেষ লগিন</th>
                        <th>সক্রিয়/নিষ্ক্রিয়</th>
                        <th>কার্যক্রম</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold fs-5">
                    @php
                        use Rakibhstu\Banglanumber\NumberToBangla;

                        $numto = new NumberToBangla();
                    @endphp

                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $numto->bnNum($loop->index + 1) }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $lastLogin = $user->loginActivities?->first()?->created_at;
                                @endphp

                                @if ($lastLogin)
                                    {{ $numto->bnNum($lastLogin->format('d')) }}-
                                    {{ $numto->bnNum($lastLogin->format('m')) }}-
                                    {{ $numto->bnNum($lastLogin->format('Y')) }},
                                    {{ $numto->bnNum($lastLogin->format('h')) }}:
                                    {{ $numto->bnNum($lastLogin->format('i')) }}
                                    {{ $lastLogin->format('A') }}
                                @else
                                    -
                                @endif

                            </td>
                            <td>
                                @if ($user->id != auth()->user()->id)
                                    @if ($user->is_active == 0)
                                        <div
                                            class="form-check form-switch form-check-solid form-check-success d-flex justify-content-center">
                                            <input class="form-check-input toggle-active" type="checkbox"
                                                value="{{ $user->id }}">
                                        </div>
                                    @elseif ($user->is_active == 1)
                                        <div
                                            class="form-check form-switch form-check-solid form-check-success d-flex justify-content-center">
                                            <input class="form-check-input toggle-active" type="checkbox"
                                                value="{{ $user->id }}" checked />
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($user->id == auth()->user()->id)
                                    <a href="{{ route('profile') }}" title="আমার প্রোফাইল" data-bs-toggle="tooltip"
                                        class="btn btn-icon text-hover-success w-30px h-30px me-3">
                                        <i class="ki-outline ki-eye fs-2"></i>
                                    </a>
                                @elseif ($user->id != auth()->user()->id)
                                    <a href="#" title="সংশোধন" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_edit_user" data-user-id="{{ $user->id }}"
                                        class="btn btn-icon text-hover-primary w-30px h-30px">
                                        <i class="ki-outline ki-pencil fs-2"></i>
                                    </a>

                                    <a href="#" title="পাসওয়ার্ড পরিবর্তন" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_edit_password" data-user-id="{{ $user->id }}"
                                        data-user-name="{{ $user->name }}"
                                        class="btn btn-icon text-hover-primary w-30px h-30px change-password-btn">
                                        <i class="ki-outline ki-key fs-2"></i>
                                    </a>
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

    <!--begin::Modal - Edit User Password-->
    <div class="modal fade" id="kt_modal_edit_password" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-450px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_edit_password_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold" id="kt_modal_edit_password_title">পাসওয়ার্ড রিসেট</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-edit-password-modal-action="close">
                        <i class="ki-outline ki-cross fs-1">
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body px-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_edit_password_form" class="form" action="#" novalidate="novalidate"
                        autocomplete="off">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5" id="kt_modal_edit_password_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_edit_password_header"
                            data-kt-scroll-wrappers="#kt_modal_edit_password_scroll" data-kt-scroll-offset="300px">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">নতুন পাসওয়ার্ড</label>
                                        <!--end::Label-->

                                        <div class="input-group">
                                            <input type="password" name="new_password" id="teacherPasswordNew"
                                                class="form-control mb-3 mb-lg-0" placeholder="Enter New Password"
                                                required autocomplete="off" />
                                            <span class="input-group-text toggle-password"
                                                data-target="teacherPasswordNew" style="cursor: pointer;"
                                                title="See Password" data-bs-toggle="tooltip">
                                                <i class="ki-outline ki-eye fs-3"></i>
                                            </span>
                                        </div>

                                        <!-- Password strength meter -->
                                        <div id="password-strength-text" class="mt-1 fw-bold small text-muted"></div>
                                        <div class="progress mt-1" style="height: 5px;">
                                            <div id="password-strength-bar" class="progress-bar" role="progressbar"
                                                style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                        </div>
                        <!--end::Scroll-->

                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-edit-password-modal-action="cancel">বাতিল</button>
                            <button type="submit" class="btn btn-success" data-kt-edit-password-modal-action="submit">
                                <span class="indicator-label">আপডেট</span>
                                <span class="indicator-progress">অপেক্ষা করুন...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Edit User Password-->

    <!--begin::Modal - Add User-->
    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">নতুন ইউজার যুক্ত করুন</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-add-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1">
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body px-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_add_user_form" class="form" action="#" novalidate="novalidate">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_edit_user_header"
                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                            <!--begin::Name Input group-->
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">ইউজারের নাম</label>
                                <input type="text" name="user_name_add"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="ইউজারের নাম লিখুন"
                                    required />
                            </div>
                            <!--end::Name Input group-->

                            <!--begin::Phone Input group-->
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">ইউজারের ইমেইল</label>
                                <input type="email" name="email_add"
                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="অনুগ্রহ করে ইমেইল এড্রেস লিখুন" required />
                            </div>
                            <!--end::Phone Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-add-users-modal-action="cancel">ক্যানসেল</button>
                            <button type="submit" class="btn btn-primary" data-kt-add-users-modal-action="submit">
                                <span class="indicator-label">সাবমিট</span>
                                <span class="indicator-progress">অপেক্ষা করুন...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add User-->


    <!--begin::Modal - Edit User-->
    <div class="modal fade" id="kt_modal_edit_user" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_edit_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">ইউজার আপডেট করুন</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-edit-users-modal-action="close">
                        <i class="ki-outline ki-cross fs-1">
                        </i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body px-5 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_edit_user_form" class="form" action="#" novalidate="novalidate">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_sibling_scroll"
                            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                            data-kt-scroll-dependencies="#kt_modal_edit_sibling_header"
                            data-kt-scroll-wrappers="#kt_modal_edit_sibling_scroll" data-kt-scroll-offset="300px">

                            <!--begin::Name Input group-->
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">ইউজারের নাম</label>
                                <input type="text" name="user_name_edit"
                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="ইউজারের নাম লিখুন"
                                    required />
                            </div>
                            <!--end::Name Input group-->

                            <!--begin::Phone Input group-->
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">ইউজারের ইমেইল</label>
                                <input type="email" name="email_edit"
                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="অনুগ্রহ করে ইমেইল এড্রেস লিখুন" required />
                            </div>
                            <!--end::Phone Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-edit-users-modal-action="cancel">ক্যানসেল</button>
                            <button type="submit" class="btn btn-primary" data-kt-edit-users-modal-action="submit">
                                <span class="indicator-label">আপডেট</span>
                                <span class="indicator-progress">অপেক্ষা করুন...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Edit User-->
@endsection


@push('vendor-js')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush

@push('page-js')
    <script>
        const routeDeleteUser = "{{ route('users.destroy', ':id') }}";
        const routeToggleActive = "{{ route('users.toggleActive', ':id') }}";
    </script>

    <script src="{{ asset('admin/js/users/index.js') }}"></script>

    <script>
        document.getElementById("user_info_menu").classList.add("here", "show");
        document.getElementById("user_list_link").classList.add("active");
    </script>
@endpush
