// FORMAT DESTINATION ADDRESS

// extract the full address (address lat: xx, lng: xx) from response.data
function getFullAddress(data) {
    var addr = data.results[0].formatted_address;
    var loc = getLatLng(data);
    return addr; // "<br> lat: " + loc["lat"] + ", lng: " + loc["lng"];
}

// extract the location (lat long) from response.data
function getLatLng(data) {
    var location = data.results[0].geometry.location;
    return location;
}

// extract the postal code from response.data
function getPostCode(data) {
    // var addrcomponents = data["results"][0]["address_components"];
    var addrcomponents = data.results[0].address_components;
    var postcode = addrcomponents.filter(postcodeHelper);
    // country is an array but there should be only one element
    return postcode[0]["long_name"];
}

// call back function for filter
function postcodeHelper(addr) {
    return addr.types[0] == "postal_code";
}

function getKeys(data) {
    // data["results"][0] is an object
    // this gets the keys/properties of results[0] object
    var keys = Object.keys(data.results[0]);
    for (let key of keys) {
        // this prints --
        /*  address_components
            formatted_address
            geometry
            place_id
            plus_code
            types */
        document.getElementById("display").innerHTML += key + "<br>";
    }
}

// extract country from response.data
function getCountry(data) {
    // addrcomponents is an array
    var addrcomponents = data.result[0].address_components;
    // The filter() method creates a new array with array elements that passes a test.
    var country = addrcomponents.filter(countryHelper);
    // country is an array but there should be only one element
    return country[0].long_name;
}

// call back function for filter
function countryHelper(addr, index) {
    return addr.types[0] == "country";
}