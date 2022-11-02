@extends('layouts.dashboardMaster')
@section('title')
    Vehicles
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
                        <span class="card-label fw-bolder fs-3 mb-1">Vehicles</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Total {{ $lists->count() }} Vehicle Requisition</span>
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
                                    <th >Sl</th>
                                    <th>vehicle</th>
                                    <th>Capacity</th>
                                    <th>Trips</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @if($lists && $lists->count()>0)
                                    @foreach($lists as $list)
                                    <tr>
                                        <td>
                                            @include('components.tableSerial')
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px me-5">
                                                    <img src="{{ $list->image ? asset($list->image) : asset('assets/uploads/default/defaultVehicle.webp') }}" class="" alt="" />
                                                </div>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <p href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{ $list->codeName }}</p>
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">License: {{ $list->license }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-square badge-success">{{ $list->capacity }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-square badge-success">{{ $list->trips_count }}</span>
                                        </td>
                                        <td>
                                            @php
                                                if ($list->type){
                                                    $type = $list->type;
                                                    $typeClass = "";
                                                }else{
                                                    $type = "No Data";
                                                    $typeClass = "text-muted";
                                                }
                                            @endphp
                                            <p href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 {{  $typeClass }}">{{ ucfirst($list->vehicleType->name) }}</p>
                                            {{-- <span class="text-muted fw-bold text-muted d-block fs-7">Rejected</span> --}}
                                        </td>

                                        <td>
                                            @php
                                                if($list->status == "available"){
                                                    $status = ucfirst($list->status);
                                                    $statusClass = "badge-success";
                                                }elseif($list->status == "trip"){
                                                    $status =  "In ".ucfirst($list->status);
                                                    $statusClass = "badge-warning";
                                                }else{
                                                    $status = ucfirst($list->status);
                                                    $statusClass = "badge-danger";
                                                }

                                            @endphp
                                            <span class="badge {{ $statusClass }} fs-7 fw-bold">{{ $status }}</span>
                                        </td>
                                        <td class="text-end">
                                            @if($list->status == 'available')
                                                <a href="/requisition/send/{{ $list->id }}" class=" btn btn-primary p-2">
                                                    Send
                                                </a>
                                            @elseif($list->status == 'trip')
                                                <a href="/requisition/edit/{{ $list->activeTrip->id }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </a>
                                                <a href="/requisition/reach/{{ $list->id }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" zoomAndPan="magnify" viewBox="0 0 30 30.000001" height="40" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="id1"><path d="M 2.328125 4.222656 L 27.734375 4.222656 L 27.734375 24.542969 L 2.328125 24.542969 Z M 2.328125 4.222656 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#id1)"><path fill="rgb(13.729858%, 12.159729%, 12.548828%)" d="M 27.5 7.53125 L 24.464844 4.542969 C 24.15625 4.238281 23.65625 4.238281 23.347656 4.542969 L 11.035156 16.667969 L 6.824219 12.523438 C 6.527344 12.230469 6 12.230469 5.703125 12.523438 L 2.640625 15.539062 C 2.332031 15.84375 2.332031 16.335938 2.640625 16.640625 L 10.445312 24.324219 C 10.59375 24.472656 10.796875 24.554688 11.007812 24.554688 C 11.214844 24.554688 11.417969 24.472656 11.566406 24.324219 L 27.5 8.632812 C 27.648438 8.488281 27.734375 8.289062 27.734375 8.082031 C 27.734375 7.875 27.648438 7.679688 27.5 7.53125 Z M 27.5 7.53125 " fill-opacity="1" fill-rule="nonzero"/></g></svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </a>
                                                <a href="/requisition/cancel/{{ $list->id }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                          </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </a>
                                            @endif
                                            <a href="/vehicleTrip/history/{{ $list->id }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                                                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                                                        <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
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
<script type="text/javascript">
    @if (count($errors) > 0)
        $('#validationError').modal('show');
    @endif
</script>

