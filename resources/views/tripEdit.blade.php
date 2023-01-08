@extends('layouts.dashboardMaster')
@section('title')
    Edit Requisition
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

                    @include('components.success')
                    @include('components.error')

                <!--begin::Contact-->
                <div class="card">
                    <!--begin::Body-->
                    <div class="card-body p-lg-17">
                        <!--begin::Row-->
                        <div class="row mb-3">
                            <!--begin::Col-->
                            <div class="col-md-12 pe-lg-10">
                                <!--begin::Form-->
                                <form action="/requisition/update/{{ $trip->id }}" class="form mb-15" method="post" id="" enctype="multipart/form-data">
                                    @csrf
                                    <h1 class="fw-bolder text-dark mb-9">Edit Requisition</h1>
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">Vehicle ID</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="vid" class="form-control mb-3 mb-lg-0" name="vid" value="{{ $trip->vehicle->id }}" readonly />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label fs-6 mb-2">Route</label>
                                            <!--end::Label-->

                                            <!--begin::Select2-->
                                            <select class="form-select" name="route" data-control="select2" data-placeholder="Select a Route" data-hide-search="true" value="">
                                                <option></option>
                                                <?php
                                                if($routes->count()>0){
                                                    foreach($routes as $route){
                                                        $routeID =  old('route') ? old('route') : $trip->route;
                                                    ?>
                                                        <option value="{{ $route->id }}" {{ $route->id == $routeID ? 'selected' : '' }}>{{ $route->route }}</option>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                            </select>
                                            @error('route')
                                                @include('components.validation')
                                            @enderror
                                            <!--begin::Select2-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <?php
                                                // date_default_timezone_set('Asia/Kolkata');
                                                // $date = new DateTime();
                                                // $min = $date->format('Y-m-d\TH:i');

                                                // $maxInputModify = $date->modify('+1 hour');
                                                // $maxInput = $maxInputModify->format('Y-m-d\TH:i');

                                                // $maxModify = $date->modify('+7 days');
                                                // $max = $maxModify->format('Y-m-d\TH:i');
                                            ?>
                                            <!--begin::Label-->
                                            <label for="" class="form-label required">Start date and time</label>
                                            <input type="datetime-local" class="form-control" placeholder="Pick date & time" id="kt_datepicker_3" name="start" value="{{ old('start') ?? $trip->start }}"/>
                                            @error('start')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label for="" class="form-label required">End date and time</label>
                                            <input type="datetime-local" class="form-control" placeholder="Pick date & time" id="kt_datepicker_3" name="end" value="{{ old('end') ? old('end') : $trip->end }}"/>
                                            @error('end')
                                            @include('components.validation')
                                            @enderror
                                            <!--begin::Select2-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input-->
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fw-bold fs-6 mb-2 required">From</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text"  name="from" class="form-control mb-3 mb-lg-0" placeholder="From" value="{{ old('from') ? old('from') : $trip->from}}"/>
                                            @error('from')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fw-bold fs-6 mb-2 required">Destination</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text"  name="dest" class="form-control mb-3 mb-lg-0" placeholder="Destination" value="{{ old('dest') ? old('dest') : $trip->dest }}"/>
                                            @error('dest')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->

                                    </div>
                                    <!--end::Input-->

                                     <!--begin::Input group-->
                                     <div class="row mb-6">
                                         <!--begin::Col-->
                                         <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label fs-6 mb-2">Driver</label>
                                            <!--end::Label-->

                                            <!--begin::Select2-->
                                            <select class="form-select" name="driver" data-control="select2" data-placeholder="Select a Driver" >
                                                <option></option>
                                                <?php
                                                if($drivers->count()>0){
                                                    foreach($drivers as $driver){
                                                        $driverID = old('driver') ? old('driver') : $trip->driver;
                                                    ?>
                                                        <option value="{{ $driver->id }}" {{ $driver->id == $driverID? 'selected' : '' }}>{{ $driver->name }}</option>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                            </select>
                                            @error('driver')
                                            @include('components.validation')
                                            @enderror
                                            <!--begin::Select2-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">Show on Map</label>
                                            <!--end::Label-->
                                            <!--begin::Select-->
                                            <?php
                                            $driverID = old('driver') ? old('driver') : $trip->driver;
                                                $oldMapShow = old('show_map') ?? $trip->onTripVehicle->show_map;
                                            ?>
                                            <select class="form-select" name="show_map" data-control="select2" data-placeholder="Select a Driver" data-hide-search="true">
                                                {{-- <option></option> --}}
                                                <option value="1" {{ $oldMapShow == 1 ? 'selected' : '' }} >Show</option>
                                                <option value="0" {{ $oldMapShow == 0 ? 'selected' : '' }} >Hide</option>
                                            </select>
                                            @error('show_map')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Select-->
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->

                                    </div>
                                    <!--end::Input-->

                                    <!--begin::Submit-->
                                    <button type="submit" class="btn btn-primary mt-5">
                                        <!--begin::Indicator-->
                                        <span class="indicator-label">Update</span>
                                        {{-- <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span> --}}
                                        <!--end::Indicator-->
                                    </button>
                                    <!--end::Submit-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Col-->

                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Contact-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
@endsection


