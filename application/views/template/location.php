
<h2 class="mt-2 mb-2 pl-3">My location <i class="bi bi-cursor-fill" style="color:blue;"></i></h2>
<h2 class="mt-2 mb-2 pl-3" id="address" style="font-size:2rem; letter-spacing:normal;"></h2>
<div id="map"></div>

    <!-- 
     The `defer` attribute causes the callback to execute after the full HTML
     document has been parsed. For non-blocking uses, avoiding race conditions,
     and consistent behavior across browsers, consider loading using Promises
     with https://www.npmjs.com/package/@googlemaps/js-api-loader.
    -->
<script
  async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCX8tGke2zi77TG3W2T5a0xMVYaJ_Oi6rM&callback=init"
></script>
<style>
#map {
  height: 100vh;
  width: 100%;
}
h2{
  color:black;
  letter-spacing:0.1rem;
}
</style>

<script>
function init() {
  const initialPosition = { lat: -37.8136, lng: 144.963 };

  const map = new google.maps.Map(document.getElementById('map'), {
    center: initialPosition,
    zoom: 10
  });

  const marker = new google.maps.Marker({map,animation: google.maps.Animation.DROP, position: initialPosition });
  const geocoder = new google.maps.Geocoder();
  const infowindow = new google.maps.InfoWindow();
  infowindow.setContent("Default address");

  // Get user's location
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      position => {
        const latlng = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        console.log(position.coords.latitude);
        console.log(position.coords.longitude);

        // Set user marker's position.
        marker.setPosition({
          lat: position.coords.latitude,
          lng: position.coords.longitude
        });

        // Center map to user's position.
        map.panTo({
          lat: position.coords.latitude,
          lng: position.coords.longitude
        });

        geocoder
          .geocode({ location: latlng })
          .then((response) => {
            if (response.results[0]) {
              map.setZoom(11);
              console.log(response.results[0].formatted_address);

              const element = document.getElementById('address');
              element.innerHTML = '';
              element.innerHTML = response.results[0].formatted_address;
              infowindow.setContent(response.results[0].formatted_address);
            } else {
              window.alert("No results found");
            }
          })
          .catch((e) => window.alert("Geocoder failed due to: " + e));
      },showError
    );
  }

  //change the map display location when user click
  marker.addListener("click", () => {
    map.setZoom(14);
    map.setCenter(marker.getPosition());
    infowindow.open(map, marker);
  });
  // change the center of map to user's position after 3s
  map.addListener("center_changed", () => {
  window.setTimeout(() => {
    map.panTo(marker.getPosition());
  }, 3000);
  });
}

function showError(error) {
  const errortype = document.getElementById('address');
  errortype.style.color="red";
  switch(error.code) {
    case error.PERMISSION_DENIED:
        errortype.innerHTML = "User denied the request for Geolocation."
        break;
    case error.POSITION_UNAVAILABLE:
        errortype.innerHTML = "Location information is unavailable."
        break;
    case error.TIMEOUT:
        errortype.innerHTML = "The request to get user location timed out."
        break;
    case error.UNKNOWN_ERROR:
        errortype.innerHTML = "An unknown error occurred."
        break;
  }
}
</script>


