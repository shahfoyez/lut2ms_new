@extends('layouts.dashboardMaster')
@section('title')
    Edit Route
@endsection
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                @include('components.flashMessage')
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
                                <form action="/route/routeUpdate/{{ $route->id }}" class="form mb-15" method="post" id="" >
                                    @csrf
                                    <h1 class="fw-bolder text-dark mb-9">Edit Route</h1>
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">Route</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="route" class="form-control mb-3 mb-lg-0" placeholder="Route Number" value="{{ $route->route }}" />
                                            @error('route')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fw-bold fs-6 mb-2">Starting Label</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="slabel" class="form-control mb-3 mb-lg-0" placeholder="Starting Label" value="{{ $route->slabel }}" />
                                            @error('slabel')
                                                @include('components.validation')
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
                                            <label class="fw-bold fs-6 mb-2">Star Latitude</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="slat" class="form-control mb-3 mb-lg-0" placeholder="Latitude" value="{{ $route->slat }}"/>
                                            @error('slat')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fw-bold fs-6 mb-2">StartLongitude</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="slon" class="form-control mb-3 mb-lg-0" placeholder="Longitude" value="{{ $route->slon }}" />
                                            @error('slon')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input group-->
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
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset(' assets/js/custom/modals/create-account.js') }}"></script>
<!--end::Page Custom Javascript-->

