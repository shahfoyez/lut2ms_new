@include('shared/header')
<!--begin::Body-->
<body id="kt_body" class="bg-body">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14.png">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Logo-->
                <a href="/" class="mb-12">
                    <img alt="Logo" src="{{ asset('assets/media/logos/logo1.png') }}" class="h-40px" />
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="post" action="/session">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-3">Sign In to TMS</h1>
                            <!--end::Title-->
                        </div>

                        @error('error')
                            <div class="alert alert-warning" role="alert">
                                <p class="error text-danger" style="font-size: 14px; margin-bottom:0px; color: #ef305e !important"><i class="far fa-frown color-black" style="color: #ef305e !important;"></i> {{ $message }}</p>
                            </div>
                        @enderror

                        <!--begin::Heading-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="form-label fs-6 fw-bolder text-dark">Username</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-lg form-control-solid" type="text" name="username" autocomplete="off" />
                            @error('username')
                                @include('components.validation')
                            @enderror
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack mb-2">
                                <!--begin::Label-->
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Input-->
                            <input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
                            @error('password')
                                @include('components.validation')
                            @enderror
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <!--begin::Link-->
                            {{-- <a href="/register" class="link-primary fs-6 fw-bolder">Don't have an account? Sign Up</a> --}}
                            <!--end::Link-->
                            <!--begin::Submit button-->
                            {{-- onClick="this.form.submit();" --}}
                            <button type="submit" class="btn btn-lg btn-primary w-100 mb-5 mt-2" onClick="this.form.submit(); this.disabled=true; this.innerText='Please Wait…';">
                                <span class="indicator-label">Sign In</span>
                                {{-- <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span> --}}
                            </button>
                            <!--end::Submit button-->
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>

    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('/assets/js/scripts.bundle.js') }}"></script>
    <!--start::Page Custom Javascript-->
    <script src="{{ asset('/assets/js/sign-in/general.js') }}"></script>
    {{-- <script src="{{ asset('/assets/js/sign-in/two-steps.js') }}"></script> --}}
    <!--end::Page Custom Javascript-->

</body>
<!--end::Body-->
</html>
