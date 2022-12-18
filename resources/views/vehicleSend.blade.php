@extends('layouts.dashboardMaster')
@section('title')
    Send Vehicle
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
                                <form action="/requisition/vehicleSend" class="form mb-15" method="post" id="" enctype="multipart/form-data">
                                    @csrf
                                    <h1 class="fw-bolder text-dark mb-9">Send Requisition</h1>
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">Vehicle</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="vid" class="form-control mb-3 mb-lg-0" name="vid" value="{{ $vehicle->id }}" readonly />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label fs-6 mb-2">Route</label>
                                            <!--end::Label-->

                                            <!--begin::Select2-->
                                            <select class="form-select" name="route" data-control="select2" data-placeholder="Select a Route" data-hide-search="true" value="{{ old('route') }}">
                                                <option></option>
                                                <?php
                                                if($routes->count()>0){
                                                    foreach($routes as $route){
                                                    ?>
                                                        <option value="{{ $route->id }}" {{ old('route') == $route->id ? 'selected' : '' }}>{{ $route->route }}</option>
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
                                                $mindate = date("Y-m-d");
                                                $mintime = date("H:i");
                                                $min = $mindate."T".$mintime;

                                                $maxdate = date("Y-m-d", strtotime("+7 Days"));
                                                $maxtime = date("h:i");
                                                $max = $maxdate."T".$maxtime;

                                                $maxInputDate = date("Y-m-d");
                                                $maxInputTime= date("h:i", strtotime("+1 hour"));
                                                $maxInput = $maxInputDate."T".$maxInputTime;
                                            ?>
                                            <!--begin::Label-->
                                            <label for="" class="form-label required">Start date and time</label>
                                            <input type="datetime-local" class="form-control" placeholder="Pick date & time" id="kt_datepicker_3" name="start" min="{{  $min }}" max="{{ $max }}" value="{{ old('start') ??  $min  }}"/>
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
                                            <input type="datetime-local" class="form-control" placeholder="Pick date & time" id="kt_datepicker_3" name="end" min="{{  $min }}" max="{{ $max }}" value="{{ old('end') ?? $maxInput }}"/>
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
                                        <div class="col-md-4 fv-row">
                                            <!--begin::Label-->
                                            <label class="fw-bold fs-6 mb-2 required">From</label>
                                            <!--end::Label-->
                                            <!--begin::Select2-->
                                            <select class="form-select" name="from" data-control="select2" data-placeholder="From" >
                                                <?php
                                                if($stoppages->count()>0){
                                                    foreach($stoppages as $stoppage){
                                                    $stopLabel = ucfirst($stoppage->slabel);
                                                    ?>
                                                        <option value="{{ $stopLabel }}" {{ old('from') == $stopLabel ? 'selected' : ( $stopLabel ==  ucfirst('Tilagor') ? 'selected' : '') }} > {{ $stopLabel }} </option>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                            </select>
                                            {{-- <!--begin::Input-->
                                            <input type="text"  name="from" class="form-control mb-3 mb-lg-0" placeholder="From" value="{{ old('from') }}"/> --}}
                                            @error('from')
                                            @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-4 fv-row">
                                            <!--begin::Label-->
                                            <label class="fw-bold fs-6 mb-2 required">Destination</label>
                                            <!--end::Label-->

                                            <select class="form-select" name="dest" data-control="select2" data-placeholder="Destination" >
                                                <?php
                                                    if($stoppages->count()>0){
                                                        foreach($stoppages as $stoppage){
                                                            $destLabel = ucfirst($stoppage->slabel);
                                                            ?>
                                                                <option value="{{ $destLabel }}" {{ old('dest') == ucfirst($stoppage->slabel) ? 'selected' : ( $destLabel ==  ucfirst('Kamal Bazar') ? 'selected' : '') }} > {{ $destLabel }} </option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                                {{-- <option value="Kamal Bazar" selected>Kamal Bazar</option> --}}

                                            </select>
                                            @error('dest')
                                            @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-4 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label fs-6 mb-2">Driver</label>
                                            <!--end::Label-->

                                            <!--begin::Select2-->
                                            <select class="form-select" name="driver" data-control="select2" data-placeholder="Select a Driver" >
                                                <option></option>
                                                <?php
                                                if($drivers->count()>0){
                                                    foreach($drivers as $driver){
                                                    ?>
                                                        <option value="{{ $driver->id }}" {{ old('driver') == $driver->id ? 'selected' : '' }} {{ $driver->status == 1 ? 'disabled' : '' }}> {{ $driver->name }}{{ $driver->status == 1 ? '(In Trip)' : '' }} </option>
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
                                    </div>
                                    <!--end::Input-->

                                    <!--begin::Submit-->
                                    <button type="submit" class="btn btn-primary mt-5" onClick="this.form.submit(); this.disabled=true; this.innerText='Wait...'; ">
                                        <!--begin::Indicator-->
                                        <span class="indicator-label">Submit</span>
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


