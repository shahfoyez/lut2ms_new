var map;
var markers = [];
// Convert the Laravel object to a JSON string
$stoppages = {!! json_encode($stoppages) !!};

// Parse the JSON string to create a JavaScript object
const user = JSON.parse($userJson);
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 24.8949, lng: 91.8687},
        zoom: 12
    });
}
// update marker position
function addMarker(data) {
    console.log("Add marker has called");
    var newlat = parseFloat(data.vehicle.location['lat']);
    var newlong = parseFloat(data.vehicle.location['long']);
    var driverName = data.trip.name ?? 'No Driver';
    var route = 'Route '+data.rout.route ?? 'No Route';
    var from =  data.trip['from'] ?? 'No Data';
    var dest =  data.trip['dest'] ?? 'No Data';
    var vehName = data.vehicle.codeName ?? 'No Name';
    var iconPath = '/assets/uploads/default/mapVehicle.png';
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
    var infowindow = new google.maps.InfoWindow({
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

// Fetch the location data and update the map every 5 seconds
setInterval(function() {
    $.ajax({
        url: '/api/vehicles/location',
        success: function(allData) {
            let withLocationShow = allData.withLocationShow;
            let wlsLength = Object.keys(withLocationShow).length;
            // refresh the page if new vehicle added to trip
            if(wlsLength !== markers.length){
                return location.reload();
            }
            if(wlsLength > 0){
                console.log("Fetching after 5 sec");
                console.log(withLocationShow);
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

// Add new markers to the map and add a custom infowindow for each marker
function markerInitialize(){
    console.log("Marker Reset");
    $.ajax({
        url: '/api/vehicles/location',
        success: function(allData) {
            let withLocationShow = allData.withLocationShow;
            let wlsLength = Object.keys(withLocationShow).length;
            if(wlsLength > 0){
                for (const key in withLocationShow) {
                    console.log(withLocationShow[key]);
                    addMarker(withLocationShow[key]);
                }
            }else{
                noVehicle();
            }
        }
    });
}
markerInitialize();

function noVehicle(){
    // Create a Marker object at the map center
    var marker = new google.maps.Marker({
        position: map.getCenter(),
        map: map
    });
    // Create an InfoWindow object
    var infowindow = new google.maps.InfoWindow({
        content: '<h1>No vehicle available!</h1>'
    });
    // Open the InfoWindow on the Marker
    infowindow.open(map, marker);
}
// remove all existing markers
function removeAllMarkers(){
    for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    // Clear the markers array
    markers = [];
}
