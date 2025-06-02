<div class="container">
        <div class="col-8 offset-2 pt-2 pb-5">
            <div class="change-email pl-5 pr-5">
                <h2 style="color:#885857; letter-spacing:normal;">Add your comment</h2>
                <small class="mt-4" style="text-transform:capitalize; color:#885857;">(Allow to access geographic information will be flagged in your comment)</small>
                <?php echo form_open(base_url().'shop/add_comment'); ?>

                <h3 class="mt-3 pb-2" style="text-transform:capitalize; color:#56717C;">Your location:</h3>
                <div class="input-group mb-3">
                    <input type="text" id="locationtext" class="form-control" placeholder="Leave as blank if you don't want share" name="location">
                    <button class="btn btn-outline-info" id="locationbutton" type="button"><i class="bi bi-cursor-fill"></i> Get my location</button>
                </div>
                <div id="error" style="color:red; text-transform:capitalize;"></div>

                <h3 class="mt-3 pb-2" style="text-transform:capitalize; color:#56717C;">Add comment here:</h3>
                <div class="input-group">
					<input type="text" id="comment" class="form-control form-control-lg" placeholder="Add here..."  required="required" name="comment">
				</div>


                <div class="form-group">
				</div>

                <div class="button mt-5 pb-5">
                    <div class="col mt-4 pb-4">
                        <button type="submit" id="savebutton" class="btn  btn-info btn-block ">Save</button>
                    </div>
                <?php echo form_close(); ?>
                <?php echo form_open(base_url().'shop/backshop'); ?>
                    <div class="col mt-4 pb-4 ml-5 pl-5">
                        <button type="submit" id="closebutton" class="btn btn-warning btn-block float-right">Close</button>
                    </div>
                <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div id="map"></div>
</div>
<script
    async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCX8tGke2zi77TG3W2T5a0xMVYaJ_Oi6rM&callback=init"
></script>

<script>
function init(){
    //Initialisation
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 8,
        center: { lat: 40.731, lng: -73.997 },
    });
    const geocoder = new google.maps.Geocoder();
    // Get user's location
    document.getElementById("locationbutton").addEventListener("click", () => {
        geocode(geocoder, map);
    });
}

function geocode(geocder,map){
    const geocoder = new google.maps.Geocoder();
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
        position => {
        const latlng = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
        };
        console.log(position.coords.latitude);
        console.log(position.coords.longitude);

        geocoder
            .geocode({ location: latlng })
            .then((response) => {
            if (response.results[0]) {
                console.log(response.results[0].formatted_address);
                const element = document.getElementById('locationtext').value = response.results[0].address_components.filter(ac=>~ac.types.indexOf('locality'))[0].long_name;
            } else {
                window.alert("No location results found");
            }
            })
            .catch((e) => window.alert("Geocoder failed due to: " + e));
        },showError
        );
    }
}

function showError(error) {
  const errortype = document.getElementById('error');
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


<style>
#locationbutton{
    border-style: none;
    font-weight:600;
    color:#002EA6;
    font-size:1rem;
}
#locationbutton:hover{
  color: #fff;
  background-color: #13846;
  border-color: #117a8b;
}
</style>