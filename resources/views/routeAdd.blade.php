@extends('layouts.dashboardMaster')
@section('title')
    Add Route
@endsection
@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        @include('components.flashMessage')
        @include('components.success')
        @include('components.error')
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
                                <form action="/route/routeAdd" class="form mb-15" method="post" id="" >
                                    @csrf
                                    <h1 class="fw-bolder text-dark mb-9">Add Route</h1>
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="required fw-bold fs-6 mb-2">Route</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="route" class="form-control mb-3 mb-lg-0" placeholder="Route Number" value="{{ old('route') }}" />
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
                                            <input type="text" name="slabel" class="form-control mb-3 mb-lg-0" placeholder="Starting Label" value="{{ old('slabel') }}" />
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
                                            <input type="text" name="slat" id="slat" class="form-control mb-3 mb-lg-0" placeholder="Latitude" value="{{ old('slat') }}"/>
                                            @error('slat')
                                                @include('components.validation')
                                            @enderror
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6 fv-row">
                                            <!--begin::Label-->
                                            <label class="fw-bold fs-6 mb-2">Start Longitude</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" name="slon" id="slon" class="form-control mb-3 mb-lg-0" placeholder="Longitude" value="{{ old('slon') }}" />
                                            @error('slon')
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
                                        <div class="fv-row">
                                            <div id="map" style="height: 300px; width: 100%; border-radius: 10px" class="my-3"></div>
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
@section('scripts')
<script>
    let map;
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 24.8949, lng: 91.8687 },
            zoom: 15,
            scrollwheel: true,
        });
        const uluru = { lat: 24.8949, lng: 91.8687 };
        let marker = new google.maps.Marker({
            position: uluru,
            map: map,
            draggable: true
        });
        google.maps.event.addListener(marker,'position_changed',
            function (){
                let lat = marker.position.lat()
                let lng = marker.position.lng()
                // console.log(marker.position())
                // let label = marker.position.label()
                $('#slat').val(lat)
                $('#slon').val(lng)
                // $('#slabel').val(label)

            })
        google.maps.event.addListener(map,'click',
        function (event){
            pos = event.latLng
            marker.setPosition(pos)
        })
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"
        type="text/javascript">
</script>
@endsection
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset(' assets/js/custom/modals/create-account.js') }}"></script>
<!--end::Page Custom Javascript-->

