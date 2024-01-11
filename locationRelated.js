// GET CURRENT LOCATION
async function getCurrentLocation() {

    var geolocationURL = "https://www.googleapis.com/geolocation/v1/geolocate?key=" + myKey;

    var response = await fetch(geolocationURL, {
    method: "POST",
    });

    if(!response.ok) {
        document.getElementById("display").innerText = "Error retrieving your location";
    }

    var result = await response.json();

    let lat = result.location.lat;
    let lng = result.location.lng;
    document.getElementById('origin').value = lat + ", " + lng; // UPDATE FIELD
    document.getElementById('origin').className = "form-control locPin"; // UPDATE FIELD
    
    // set map location (Hidden field)
    document.getElementById('lat').value = lat
    document.getElementById('lng').value = lng

    // change current location hidden value
    document.getElementById('currentLoc').value = lat + ", " + lng;

    initMap(); // refresh the map


}

// REMOVE PIN IF ADDRESS IS CHANGED AFTER "Get Current Location"
function currentLocCheck(event) {
    event.className = "form-control";
}

// SWITCH LOCATION AND DESTINATION
function switchLocations() {
    var originVal = document.getElementById('origin').value;
    var destinationVal = document.getElementById('destination').value;
    var currentLocVal = document.getElementById('currentLoc').value; // retrieve and store current location
    var temp = originVal; // store this value temporarily

    var originInput = document.getElementById('origin');
    var destinationInput = document.getElementById('destination');

    // BEFORE SWITCH
    if (originVal == currentLocVal) { // if origin input field is current location, put pin on destination input field next
        originInput.className = "form-control";
        destinationInput.className = "form-control locPin";
        getLatLngFromAddress(temp); // update map
    }
    else if (destinationVal == currentLocVal) { // put pin on origin input field next
        destinationInput.className = "form-control";
        originInput.className = "form-control locPin";
        getLatLngFromAddress(temp); // update map
    }

    // AFTER SWITCH
    originInput.value = destinationVal; // change origin value to destination
    destinationInput.value = temp; // change destination value to origin

    if (originVal == '' && destinationVal == '') {
        document.getElementById("display").innerText = `Please enter a start or end point`;        
    }
    else {
        getLatLngFromAddress(originVal); // automatically refresh map in this function. Just pass an address string
        // refresh routes
        getRoutes(); 
        // show destination
        document.getElementById("display").innerText = `Destination shown above. If map is blank, please check your inputs`;
    }

}

// Generate location suggestions for Input fields
function getLocationSuggestions() { 
    let originValue = document.getElementById('origin');
    let destinationValue = document.getElementById('destination');
    
    let originSuggest = new google.maps.places.Autocomplete(originValue);
    let destinationSuggest = new google.maps.places.Autocomplete(destinationValue)

    originSuggest.setComponentRestrictions({ 'country': 'SG' }); // restrict to within Singapore
    destinationSuggest.setComponentRestrictions({ 'country': 'SG' }); // restrict to within Singapore

}

// GET LAT AND LNG OF ADDRESS
function getLatLngFromAddress(addr) {

    var url = "https://maps.googleapis.com/maps/api/geocode/json?address=" + addr + "&key= " + myKey;

    // axio call
    axios.get(url)
        .then(resp => {
            // console.log(resp.data)

            // refresh the hidden input values with new lat lng coordinates
            var coordinate = getLatLng(resp.data);
            document.getElementById("lat").value = coordinate.lat;
            document.getElementById("lng").value = coordinate.lng;

            // now refresh the map
            initMap();

        })
        .catch(err => {
            console.log(err.message)
            document.getElementById("display").innerText = "Please check that your destination is not empty"
        });
}

function startSearch(event) {
    // console.log(event)
    if (event.keyCode === 13){
        getMap();
    }
}