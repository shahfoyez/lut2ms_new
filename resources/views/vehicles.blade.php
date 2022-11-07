@extends('layouts.dashboardMaster')
@section('title')
    Vehicles
@endsection
@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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
                        <span class="card-label fw-bolder fs-3 mb-1">vehicles</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Total {{ $lists->count() }} Vehicles</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="/vehicle/vehicleAdd" class="btn btn-sm btn-light-primary me-2">
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                            </svg>
                        </span>
                        New Vehicle</a>

                        <!--begin::Filter-->
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->Filter</button>
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
                                <div class="">
                                    <!--begin::Input group-->
                                    <form action="/vehicle/vehicles/filter" class="form" method="get" id="" >
                                        {{-- @csrf --}}
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fs-5 fw-bold mb-3">Vehicle Status:</label>
                                            <!--end::Label-->
                                            <!--begin::Options-->
                                            <div class="d-flex flex-column flex-wrap fw-bold" data-kt-docs-table-filter="payment_type">
                                                <!--begin::Option-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                    <input class="form-check-input" type="radio" name="status" value="all" checked="checked" />
                                                    <span class="form-check-label text-gray-600">All</span>
                                                </label>
                                                <!--end::Option-->
                                                <!--begin::Option-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                    <input class="form-check-input" type="radio" name="status" value="available" />
                                                    <span class="form-check-label text-gray-600">Available</span>
                                                </label>
                                                <!--end::Option-->
                                                <!--begin::Option-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                                    <input class="form-check-input" type="radio" name="status" value="trip" />
                                                    <span class="form-check-label text-gray-600">In Trip</span>
                                                </label>
                                                <!--end::Option-->
                                                <!--begin::Option-->
                                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="status" value="maintenance" />
                                                    <span class="form-check-label text-gray-600">Maintenance</span>
                                                </label>
                                                <!--end::Option-->
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

                        <!--end::Toolbar-->
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
                                    <th>Type</th>
                                    <th>Meter Starts</th>
                                    <th>Status</th>
                                    <th> </th>
                                    {{-- <th class="text-end min-w-100px">Action</th> --}}
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
                                                    <span class="text-muted fw-bold text-muted d-block fs-7">License: {{ $list->license ? $list->license : 'no data' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                if ($list->capacity){
                                                    $capacity = $list->capacity;
                                                    $capacityClass = "";
                                                }else{
                                                    $capacity = "No Data";
                                                    $capacityClass = "text-muted";
                                                }
                                            @endphp
                                            <p class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 {{ $capacityClass }}">{{ $capacity}}</p>
                                            {{-- <span class="text-muted fw-bold text-muted d-block fs-7">Paid</span> --}}
                                        </td>
                                        <td>
                                            @php

                                            @endphp
                                            <p class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6 ">{{ $list->vehicleType->name }}</p>
                                            {{-- <span class="text-muted fw-bold text-muted d-block fs-7">Rejected</span> --}}
                                        </td>
                                        <td>
                                            <p class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{ $list->meter_start }}</p>
                                            {{-- <span class="text-muted fw-bold text-muted d-block fs-7">Paid</span> --}}
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
                                            @if($list->status != 'trip')
                                                <a href="/vehicle/vehicleEdit/{{ $list->id }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#delete_Modal" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm cd_modal" data-item="/vehicle/vehicleDelete/{{ $list->id }}" >
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
                                            @else
                                                <span class="badge badge-warning fs-7 fw-bold">N/A</span>
                                            @endif
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

