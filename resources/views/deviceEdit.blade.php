@extends('layouts.dashboardMaster')
@section('title')
    Edit GPS
@endsection
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <div class="foy-errors container-xxl">
            @include('components.success')
            @include('components.error')
        </div>
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Contact-->
                <div class="card">
                    <!--begin::Body-->
                    <div class="card-body p-lg-17">
                        <!--begin::Row-->
                        <div class="row mb-3">
                            <!--begin::Col-->
                            <div class="col-md-12 pe-lg-10">
                                <!--begin::Form-->
                                <form action="/vehicle/deviceUpdate/{{ $gpsDevice->id }}" class="form mb-15" method="post" id="">
                                    @csrf
                                    <h1 class="fw-bolder text-dark mb-9">Edit GPS</h1>
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">GPS</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="code_name" class="form-control mb-3 mb-lg-0" placeholder="Department" value="{{ old('code_name') ?? $gpsDevice->code_name }}" />
                                            @error('code_name')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-4 fv-row">
                                            <!--begin::Label-->
                                            <label class="form-label fs-6 mb-2">Vehicle</label>
                                            <!--end::Label-->

                                            <!--begin::Select2-->
                                            <select class="form-select" name="vid" data-control="select2" data-placeholder="GPS Device">
                                                <?php
                                                    $vid = old('vid') ?? $gpsDevice->vehicle->id ?? '0';
                                                ?>
                                                <option value = "0" {{ $vid == 0 ? 'selected' : '' }}>None</option>
                                                @foreach ($vehicles as $vehicle )
                                                    <option value="{{ $vehicle->id }}"
                                                        {{ $vid == $vehicle->id ? 'selected' : '' }}
                                                        {{ $vehicle->gpsDevice && ($vehicle->id != $gpsDevice->vid) ? 'disabled' : '' }}
                                                    >
                                                        {{ $vehicle->codeName }}
                                                        {{ $vehicle->gpsDevice ? ' (Not Available)' : '' }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('vid')
                                                <p class="fv-plugins-message-container invalid-feedback">
                                                    {{  $message }}
                                                </p>
                                            @enderror
                                            <!--begin::Select2-->
                                        </div>
                                        <!--end::Col-->

                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Submit-->
                                    <button type="submit" class="btn btn-primary mt-5" onClick="this.form.submit(); this.disabled=true; this.innerText='Wait...';">
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
