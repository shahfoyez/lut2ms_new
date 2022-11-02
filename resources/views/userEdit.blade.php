@extends('layouts.dashboardMaster')
@section('title')
    Edit User
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
                                <form action="/user/update" class="form mb-15" method="post" id="" >
                                    @csrf
                                    <h1 class="fw-bolder text-dark mb-9">Edit User</h1>
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">Name</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="name" class="form-control mb-3 mb-lg-0" placeholder="Name" value="{{ old('name') ? old('name') : $user->name  }}" />
                                            @error('name')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">Username</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="username" class="form-control mb-3 mb-lg-0" placeholder="Username" value="{{ old('username') ? old('username') : $user->username }}" />
                                            @error('username')
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
                                            <label class="required form-label fs-6 mb-2">Role</label>
                                            <!--end::Label-->

                                            <!--begin::Select2-->
                                            <select class="form-select" name="role" data-control="select2" data-placeholder="Select Role"  data-hide-search="true">
                                                <option value="">Select Role</option>
                                                <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Super Admin</option>
                                                <option value="2" >Admin</option>
                                            </select>
                                            @error('role')
                                                @include('components.validation')
                                            @enderror
                                            <!--begin::Select2-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label fs-6 mb-2">Status</label>
                                            <!--end::Label-->

                                            <!--begin::Select2-->
                                            <select class="form-select" name="status" data-control="select2" data-placeholder="Select status"  data-hide-search="true">
                                                <option value="">Select Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Deactive</option>
                                            </select>
                                            @error('status')
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
                                            <label class="fw-bold fs-6 mb-2">Phone</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="number" name="phone" class="form-control mb-3 mb-lg-0" placeholder="Phone" value="{{ old('phone') ? old('phone') : $user->phone }}"/>
                                            @error('phone')
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

