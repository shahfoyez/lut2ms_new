@extends('layouts.dashboardMaster')
@section('title')
    Trip history
@endsection
@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    {{-- <div class="foy-errors container-xxl">
        @include('components.success')
        @include('components.error')
    </div> --}}

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::errors-->
            @include('components.flashMessage')
            @include('components.success')
            @include('components.error')
            <!--end::errors-->

            <!--begin::Tables Widget 11-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Trip History
                            <span class="card-label text-muted">
                            @if (isset($start) && isset($end))
                                {{ '('.$start.'-'.$end.')' }}
                            @endif
                            </span>
                        </span>
                        <span class="text-muted mt-1 fw-bold fs-7">Total {{ $trips->count() }} Trips</span>
                    </h3>
                    <div class="card-toolbar">
                       <!--begin::Filter-->
                       <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" id="foy-button">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                                </svg>
                            </span>
                        <!--end::Svg Icon-->Filter
                        </button>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-4 text-dark fw-bolder">Filter Options</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->
                            <!--begin::Content-->
                            <div class="px-7 py-5">
                                <!--begin::Input group-->
                                <div class="mb-0">
                                    <!--begin::Input group-->
                                    <form action="/trip/history/filter" class="form" method="get" id="" >
                                        {{-- @csrf --}}
                                        <div class="mb-10">
                                            <!--begin::Options-->
                                            <div class="d-flex flex-column flex-wrap fw-bold" data-kt-docs-table-filter="payment_type">
                                                <div class="mb-0">
                                                    <label class="form-label">Choose Date</label>
                                                    <input name="date" class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_1" />
                                                </div>
                                            </div>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-docs-table-filter="reset">Cancel</button>

                                            <button type="submit" class="btn btn-primary">Apply</button>
                                            {{-- <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-docs-table-filter="filter">Apply</button> --}}

                                        </div>
                                    </form>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table id="kt_datatable_example_5" class="table table-striped gy-5 gs-7 border rounded">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                    <th class="w-20px">Sl</th>
                                    <th>vehicle</th>
                                    <th>Capacity</th>
                                    <th>Driver</th>
                                    <th>From</th>
                                    <th>Dest</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @if($trips && $trips->count()>0)
                                    @foreach($trips as $trip)
                                    <tr>
                                        <td>
                                            @include('components.tableSerial')
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px me-5">
                                                    <img src="{{ $trip->vehicle->image ? asset($trip->vehicle->image) : asset('assets/uploads/default/defaultVehicle.webp') }}" class="" alt="" />
                                                </div>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <a href="/vehicle/edit/{{ $trip->vehicle->id }}" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{ $trip->vehicle->codeName }}</a>
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">License: {{ $trip->vehicle->license ? $trip->vehicle->license : "No Data" }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{ $trip->vehicle->capacity }}</p>
                                            <span class="text-muted fw-bold text-muted d-block fs-7">Route: {{ $trip->rout->route }}</span>
                                        </td>
                                        {{-- <td>
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{ $trip->rout->route }}</p>
                                        </td> --}}
                                        <td>
                                            <a href="/employee/employeeEdit/{{ $trip->employee->id }}" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{ $trip->employee->name }}</a>
                                        </td>
                                        <td>
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{ $trip->from }}</p>
                                        </td>
                                        <td>
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{ $trip->dest }}</p>
                                        </td>
                                        <td>
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{ $trip->start->format('d M Y') }}</p>
                                            <span class="text-muted fw-bold text-muted d-block fs-7">{{ $trip->start->format('h:i A') }}</span>
                                        </td>
                                        <td>
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{ $trip->end->format('d M Y') }}</p>
                                            <span class="text-muted fw-bold text-muted d-block fs-7">{{ $trip->end->format('h:i A') }}</span>
                                        </td>
                                        <td>
                                            @php
                                                if($trip->status == 1){
                                                    $status = "completed";
                                                    $statusClass = "badge-success";
                                                }elseif($trip->status == 2){
                                                    $status =  "Canceled";
                                                    $statusClass = "badge-danger";
                                                }
                                            @endphp
                                            <span class="badge {{ $statusClass }} fs-7 fw-bold">{{ $status }}</span>
                                        </td>
                                        <td>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#delete_Modal" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm cd_modal" data-item="/requisition/delete/{{ $trip->id }}" >
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif

                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
            <!--end::Tables Widget 11-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<!--end::Content-->
@endsection
@section('modals')
    @include('modals.deleteModal')
@endsection
@section('scripts')
    <!--begin::Page Vendors Javascript(used by this page)-->
    {{-- <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script> --}}
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    {{-- <script src="{{ asset('assets/js/custom/documentation/documentation.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/documentation/search.js') }}"></script> --}}
    <script src="{{ asset('/assets/js/custom/documentation/forms/daterangepicker.js') }}"></script>
    <!--end::Page Custom Javascript-->
@endsection
