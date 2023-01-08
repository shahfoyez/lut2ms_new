<!--begin::drivers & map-->
<!--begin::Row-->
<div class="row g-5 g-xl-8 mb-5">
    <!--begin::Col-->
    <div class="col-xl-4">
        <!--begin::List Widget 4-->
        <div class="card card-xl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder text-dark">Top Drivers</span>
                    <span class="text-muted mt-1 fw-bold fs-7">With Highest Number of Trips</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-5">
                @foreach ($drivers as $driver)
                <!--begin::Item-->
                <div class="d-flex align-items-sm-center mb-7">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-50px me-5">
                        <img src="{{ $driver->image ? asset($driver->image) : asset('assets/uploads/default/defaultProfile.webp') }}" class="align-self-center" alt="" />
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Section-->
                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                        <div class="flex-grow-1 me-2">
                            <a href="/employee/employeeEdit/{{ $driver->id }}" class="text-gray-800 text-hover-primary fs-6 fw-bolder">{{ $driver->name }}</a>
                            <span class="text-muted fw-bold d-block fs-7">ID: {{ $driver->idNumber }}</span>
                        </div>
                        <span class="badge badge-light fw-bolder my-2">{{ $driver->trips_count }} Trips</span>
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->
                @endforeach
            </div>
            <!--end::Body-->
        </div>
        <!--end::List Widget 4-->
    </div>
    <!--end::Col-->
    <!--start::map-->
    <!--begin::Col-->
    <div class="col-xl-8">
        <div class="fv-row">
            <div id="map" style="height: 490px; width: 100%; border-radius: 10px"></div>
        </div>
    </div>
    <!--end::Col-->
    <!--end::map-->
</div>
<!--end::Row-->
<!--end::drivers & map-->
@section('mapScript')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"></script>
    <script>
        var map;
        var markers = [];
        var stoppageMarkers = [];
        var noVehiclemarkers = [];
        stoppages = {!! json_encode($stoppages) !!};
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 24.8949, lng: 91.8687},
                zoom: 12,
            });
            markerInitialize();
            addStoppages();
        }
        // Add new markers to the map and add a custom infowindow for each marker
        function markerInitialize(){
            $.ajax({
                url: '/api/vehicles/location',
                success: function(allData) {
                    console.log(allData);
                    console.log(allData.withoutLocationHide);
                    let withLocationShow = allData.withLocationShow ?? null;
                    let withoutLocationHide = allData.withoutLocationHide ?? null;

                    // var wlsLength = withLocationShow != null ? Object.keys(withLocationShow).length : 0;
                    var wlsLength =  Object.keys(withLocationShow).length;
                    var wlhLength =  Object.keys(withLocationShow).length;
                    if(wlsLength > 0 || wlhLength > 0){
                        if(wlsLength > 0){
                            for (const key in withLocationShow) {
                                addMarker(withLocationShow[key]);
                            }
                        }else{
                            noVehicle();
                        }
                        if(wlhLength > 0){
                            for (const num in withoutLocationHide) {
                                console.log("Inside");
                                console.log(withoutLocationHide[num]);
                                addButton(withoutLocationHide[num], num);
                            }
                        }
                    }else{
                        noVehicle();
                    }

                    // if(wlsLength > 0){
                    //     for (const key in withLocationShow) {
                    //         addMarker(withLocationShow[key]);
                    //     }
                    //     for (var i = 1; i <= 5; i++) {
                    //         var button = document.createElement('button')
                    //         button.innerHTML = 'Click me';
                    //         button.addEventListener('click', function(){
                    //             alert('Hello');
                    //         })
                    //         map.controls[google.maps.ControlPosition.TOP_LEFT].push(button);
                    //         // var button = document.createElement('button');
                    //         // button.innerHTML = 'Button ' + i;

                    //         // button.addEventListener('click', function() {
                    //         //     alert('Button was clicked!'+i);
                    //         // });

                    //         // map.controls[google.maps.ControlPosition.TOP_LEFT].push(button);
                    //     }
                    // }else{
                    //     noVehicle();
                    // }
                }
            });
        }
        // update marker position
        function addMarker(data) {
            var newlat = parseFloat(data.vehicle.location['lat']);
            var newlong = parseFloat(data.vehicle.location['long']);
            var driverName = data.trip.driver.name ?? 'No Driver';
            var route = 'Route '+data.trip.rout.route ?? 'No Route';
            var from =  data.trip['from'] ?? 'No Data';
            var dest =  data.trip['dest'] ?? 'No Data';
            var vehName = data.vehicle.codeName ?? 'No Name';

            let iconPath = '/assets/uploads/default/mapVehicle.png';
            var marker = new google.maps.Marker({
                position: {lat: newlat, lng: newlong},
                map: map,
                icon: {
                    url: iconPath,
                    scaledSize: new google.maps.Size(30, 30),
                    // rotation: 180
                    // origin: new google.maps.Point(0, 0),
                    // anchor: new google.maps.Point(0, 0)
                },
            });
            // Marker circle
            var circle = new google.maps.Circle({
                map: map,
                radius: 200, // Circle radius in meters
                // center: {lat: location.lat, lng: location.lng},
                fillColor: '#FF0000',
                strokeColor: '#FF0000',
                strokeWeight: 1
            });
            // Add circle around marker
            circle.bindTo('center', marker, 'position');
            // Animate the circle
            var count = 0;
            window.setInterval(function() {
                count = (count + 1) % 200;
                // Update the radius of the circle
                circle.setOptions({
                    radius: (count + 50)
                });
            }, 10);

            // Info window content
            let infowindow = new google.maps.InfoWindow({
                content: `<div class="foy_map_infoWindow"><p class='m-0 foy_infoWindow_heading'>${vehName}</p><p class='m-0'>${route}</p><p class='m-0'>${driverName}</p><p class='m-0'> <i class="fas fa-solid fa-plane-arrival"></i> ${dest}</p></div>`,
            });
            // All marker window open
            // infowindow.open(map, marker);
            // Click to open window
            marker.addListener('click', function() {
                // map.setZoom(15);
                // map.setCenter(marker.getPosition());
                infowindow.open(map, marker);
            });
            markers.push(marker);
        }
        function addButton(buttonData){
            var busName = buttonData.vehicle.codeName;
            var tripRoute = buttonData.trip.rout['route'];
            var tripStart = buttonData.trip['tripStart'];


            console.log(buttonData);
            var button = document.createElement('button');
            button.classList.add('foy_wlh_button');
            button.innerHTML = `<div class="foy_wlh_button_contents"><p>${ busName }</p><p>Route: ${ tripRoute }</p><p>${ tripStart }</p></div>`;
            button.addEventListener('click', function(){
                alert('Hello');
            })
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(button);
        }
        // Fetch the location data and update the map every 5 seconds
        setInterval(function() {
            $.ajax({
                url: '/api/vehicles/location',
                success: function(allData) {
                    let withLocationShow = allData.withLocationShow ?? null;
                    var wlsLength = Object.keys(withLocationShow).length;
                    // var wlsLength = Object.keys(withLocationShow).length;
                    console.log("Double Checked");
                    console.log(withLocationShow);
                    console.log(wlsLength);
                    // refresh the page if new vehicle added to trip
                    if(wlsLength !== markers.length){
                        return location.reload();
                    }
                    if(wlsLength > 0){
                        var i = 0;
                        for (const key in withLocationShow) {
                            var newlat = parseFloat(withLocationShow[key].vehicle.location['lat']);
                            var newlong = parseFloat(withLocationShow[key].vehicle.location['long']);
                            markers[i].setPosition({lat: newlat, lng: newlong});
                            i++;
                        }
                        // New map variable to center map according to the markers
                        var bounds = new google.maps.LatLngBounds();
                        // Add markers to the bounds object
                        markers.forEach(function(marker) {
                            bounds.extend(marker.getPosition());
                        });
                        // Center the map and zoom to fit the markers
                        map.fitBounds(bounds);
                        // set zoom level to 14
                        map.setZoom(14);
                    }else{
                        noVehicle();
                    }

                }
            });
        }, 5000);
        function addStoppages(){
            for (const key in stoppages) {
                let slat = parseFloat(stoppages[key].slat);
                let slon = parseFloat(stoppages[key].slon);
                var stoppageMarker = new google.maps.Marker({
                    position: {lat: slat, lng: slon},
                    map: map,
                    icon: {
                        url: "{{ asset('/assets/uploads/default/defaultMarker.png') }}",
                        scaledSize: new google.maps.Size(25, 25),
                    },
                });
                stoppageMarkers.push(stoppageMarker);
            }
        }
        function noVehicle(){
            // to stop marker blink every 5 seconds
            if(noVehiclemarkers.length >0){
                return;
            }else{
                // return location.reload();
                    // Create a Marker object at the map center
                let iconPath = '/assets/uploads/default/noVehicle.png';
                noVehiclemarker = new google.maps.Marker({
                    position: map.getCenter(),
                    map: map,
                    icon: {
                        url: iconPath,
                        scaledSize: new google.maps.Size(35, 35),
                    },
                });
                // Create an InfoWindow object
                var nvInfowindow = new google.maps.InfoWindow({
                    content: `<div class="p-2"><h1 class="foy_vo_vehicle">No vehicle available!</h1></div>`
                });
                noVehiclemarker.addListener('click', function() {
                    nvInfowindow.open(map, noVehiclemarker);
                });
                // Open the InfoWindow on the Marker
                nvInfowindow.open(map, noVehiclemarker);
                noVehiclemarkers.push(noVehiclemarker);
                map.setZoom(14);
            }
        }
        // remove all existing markers
        function removeAllMarkers(){
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            // Clear the markers array
            markers = [];
        }
    </script>
@endsection
