@extends('layouts.dashboardMaster')
@section('title')
    Edit Meter Read
@endsection
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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
                                <form action="/meter/update/{{ $meter->id }}" class="form mb-15" method="post" id="">
                                    @csrf
                                    <h1 class="fw-bolder text-dark mb-9">Edit Meter Read</h1>
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label fs-6 mb-2">Vehicle (Readonly)</label>
                                            <!--end::Label-->

                                            <!--begin::Select2-->
                                            <select class="form-select" name="vid" data-control="select2" data-placeholder="Select Vehicle" disabled>
                                                <option value="{{ $meter->vehicle->id }}" selected>{{ $meter->vehicle->codeName }}</option>
                                            </select>
                                            @error('vid')
                                                @include('components.validation')
                                            @enderror
                                            <!--begin::Select2-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label for="" class="form-label required">Meter Read
                                                ({{
                                                ($min ? 'PE: '.$min->meter_entry : '').($max && $min ? ', ' : '').($max ? 'NE: '.$max->meter_entry : '').(!$max && !$min ? $meter->vehicle->meter_start : '')
                                                }})
                                            </label>

                                            <input type="number" step="0.1" class="form-control" placeholder="Meter Read(KM)" name="meter_entry" value="{{ old('meter_entry') ? old('meter_entry') : $meter->meter_entry  }}"/>
                                            @error('meter_entry')
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
                                            <!--begin::Label-->
                                            <label for="" class="form-label required">Date & Time (Readonly)</label>
                                            <input type="datetime-local" class="form-control" placeholder="Pick date & time" id="kt_datepicker_3" name="date" value="{{  old('date') ? old('date') : $meter->date }}" readonly/>
                                            @error('date')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label fs-6 mb-2">Status (Readonly)</label>
                                            <!--end::Label-->

                                            <!--begin::Select2-->
                                            <select class="form-select" name="status" data-control="select2" data-placeholder="Entry Status" data-hide-search="true" disabled>
                                                <?php
                                                    $status = old('status') ? old('status') : $meter->status;
                                                ?>
                                                <option></option>
                                                <option value="1" {{ $status == 1 ? "selected" : "" }}>New Entry</option>
                                                <option value="2" {{ $status == 2 ? "selected" : "" }}>Old Entry</option>
                                            </select>
                                            @error('status')
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
                                        <div class="col-md-12 fv-row">
                                            <!--begin::Label-->
                                            <label for="" class="form-label">Note</label>
                                            <textarea type="text-area" class="form-control" placeholder="Note(optional)" name="note" value="{{ old('note') }}" rows="3">{{ old('note') ? old('note') : $meter->note }}</textarea>
                                            @error('note')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Input-->
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


