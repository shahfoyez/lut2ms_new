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
                        <span class="card-label fw-bolder fs-3 mb-1">Trip History</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Total {{ $trips->count() }} Trips</span>
                    </h3>
                    <div class="card-toolbar">
                        <!--begin::Menu-->
                        <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
                                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2z"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </button>
                        <!--begin::Menu 3-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                            <!--begin::Heading-->
                            <div class="menu-item px-3">
                                <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Filter</div>
                            </div>
                            <!--end::Heading-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3">Available</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link flex-stack px-3">In Trip</a>
                            </div>
                            <!--end::Menu item-->

                        </div>
                        <!--end::Menu 3-->
                        <!--end::Menu-->
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
                                            <a href="/user/profile/{{ $trip->employee->id }}" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{ $trip->employee->name }}</a>
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
<script type="text/javascript">
    @if (count($errors) > 0)
        $('#validationError').modal('show');
    @endif
</script>

