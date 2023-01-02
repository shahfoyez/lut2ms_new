@extends('layouts.dashboardMaster')
@section('title')
    Vehicle Trips
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
                        <span class="card-label fw-bolder fs-3 mb-1">{{ $vehicle->codeName }}
                            <span class="card-label text-muted">
                                @if (isset($start) && isset($end))
                                    {{ '('.$start.'-'.$end.')' }}
                                @endif
                            </span>
                        </span>
                        <span class="text-muted mt-1 fw-bold fs-7">Total {{ $trips->count() }} Trips</span>
                    </h3>
                    <div class="card-toolbar">
                        @php
                            $formAction = '/trip/vehicleTrips/'.$vehicle->id.'/filter';
                            $refreshAction = '/trip/vehicleTrips/'.$vehicle->id;
                        @endphp
                        @include('components.filter.dateFilter')
                        @include('components.filter.filterRefresh')
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
    @include('modals.confirmation.deleteModal')
@endsection
@section('scripts')
    <script src="{{ asset('/assets/js/custom/documentation/forms/daterangepicker.js') }}"></script>
@endsection

