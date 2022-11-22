@extends('layouts.dashboardMaster')
@section('title')
    Edit Vehicle
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
                <!--begin::Contact-->
                <div class="card">
                    <!--begin::Body-->
                    <div class="card-body p-lg-17">
                        <!--begin::Row-->
                        <div class="row mb-3">
                            <!--begin::Col-->
                            <div class="col-md-12 pe-lg-10">
                                <!--begin::Form-->
                                <form action="/vehicle/vehicleUpdate/{{ $vehicle->id }}" class="form mb-15" method="post" id="" enctype="multipart/form-data">
                                    @csrf
                                    <h1 class="fw-bolder text-dark mb-9">Edit Vehicle</h1>
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">Code Name</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="codeName" class="form-control mb-3 mb-lg-0" placeholder="Code Name" value="{{ old('codeName') ? old('codeName') : $vehicle->codeName}}" />
                                            @error('codeName')
                                                <p class="fv-plugins-message-container invalid-feedback">
                                                    {{  $message }}
                                                </p>
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">License</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text"  name="license" class="form-control mb-3 mb-lg-0" placeholder="License" value="{{ old('license') ? old('license') : $vehicle->license }}" />
                                            @error('license')
                                                <p class="fv-plugins-message-container invalid-feedback">
                                                    {{  $message }}
                                                </p>
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->


                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">Capacity</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="number" name="capacity" class="form-control mb-3 mb-lg-0" placeholder="Capacity" value="{{ old('capacity') ? old('capacity') : $vehicle->capacity }}"/>
                                            @error('capacity')
                                                <p class="fv-plugins-message-container invalid-feedback">
                                                    {{  $message }}
                                                </p>
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">Meter Start</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="number" name="meter_start" class="form-control mb-3 mb-lg-0" placeholder="Meter Start" value="{{ old('meter_start') ? old('meter_start') : $vehicle->meter_start }}"/>
                                            @error('meter_start')
                                                <p class="fv-plugins-message-container invalid-feedback">
                                                    {{  $message }}
                                                </p>
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->

                                     <!--begin::Input group-->
                                     <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label fs-6 mb-2">Type</label>
                                            <!--end::Label-->
                                            <!--begin::Select2-->
                                            <select class="form-select" name="type" data-control="select2" data-placeholder="Type" data-hide-search="true">
                                                <?php
                                                    $typeID = old('type') ? old('type') : $vehicle->type;
                                                ?>
                                                <option></option>
                                                @foreach ($types as $tp)
                                                    <option value="{{ $tp->id }}" {{ $typeID == $tp->id ? 'selected' : '' }}>{{ ucfirst($tp->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                                <p class="fv-plugins-message-container invalid-feedback">
                                                    {{  $message }}
                                                </p>
                                            @enderror
                                            <!--begin::Select2-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label fs-6 mb-2">Status</label>
                                            <!--end::Label-->
                                            <!--begin::Select2-->
                                            <select class="form-select" name="status" data-control="select2" data-placeholder="Can't change Status!" data-hide-search="true">
                                                <?php
                                                 if($vehicle->status == 'trip'){?>
                                                    <option value="{{ $vehicle->status }}" > Can't be changed</option>
                                                <?php
                                                }else{
                                                    $status = old('status') ? old('status') : $vehicle->status;
                                                ?>
                                                <option value="available" {{ $status == 'available' ? 'selected' : '' }} readonly>Available</option>
                                                <option value="maintenance" {{ $status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                            <?php } ?>
                                            </select>
                                            @error('status')
                                                <p class="fv-plugins-message-container invalid-feedback">
                                                    {{  $message }}
                                                </p>
                                            @enderror
                                            <!--begin::Select2-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col fv-row mt-5">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-empty" data-kt-image-input="true" style="background-image: url('{{ $vehicle->image ? asset($vehicle->image) : asset('/assets/media/avatars/blank.png') }}')">
                                                <!--begin::Image preview wrapper-->
                                                <div class="image-input-wrapper w-125px h-125px"></div>
                                                <!--end::Image preview wrapper-->

                                                <!--begin::Edit button-->
                                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                data-kt-image-input-action="change"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Vehicle Image">
                                                    <i class="bi bi-pencil-fill fs-7"></i>
                                                    <!--begin::Inputs-->
                                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="avatar_remove" />
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Edit button-->
                                                <!--begin::Cancel button-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                data-kt-image-input-action="cancel"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Cancel avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <!--end::Cancel button-->
                                                <!--begin::Remove button-->
                                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                                                data-kt-image-input-action="remove"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Remove avatar">
                                                    <i class="bi bi-x fs-2"></i>
                                                </span>
                                                <!--end::Remove button-->
                                            </div>
                                            <!--end::Image input-->
                                            @error('image')
                                                @include('components.validation')
                                            @enderror
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Submit-->
                                    <button type="submit" class="btn btn-primary mt-5">
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
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset(' assets/js/custom/modals/create-account.js') }}"></script>
<!--end::Page Custom Javascript-->

