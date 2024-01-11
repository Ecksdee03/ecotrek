// Load the API from the specified URL. The async attribute allows the browser to render the page while the API loads. The key parameter will contain your own API key. The callback parameter executes the initMap() function
// Google API Key.
var myKey = "AIzaSyDPqhshctg7wgTjNnpnjqEv_N0xmQXycuA"; // change here!!!

// replacement for script src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=XXX"
var myGoogleApiScript = document.createElement('script');
myGoogleApiScript.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?callback=initMap&libraries=places&key=' + myKey);
document.head.appendChild(myGoogleApiScript);

// if null do not add points. if logged in add points.
// var profileID = sessionStorage.getItem("profileID");

// Initialize and add the map
function initMap() {
    // default: The location of SCIS, SMU
    var lat = parseFloat(document.getElementById("lat").value);
    var lng = parseFloat(document.getElementById("lng").value);
    var loc = {
        lat: lat,
        lng: lng
    };

    // The map, centered at SCIS, SMU
    var map = new google.maps.Map(
        // play with the zoom value to zoom in or out
        document.getElementById('map'), {
            zoom: 14,
            center: loc
        });
    // The marker, positioned at SCIS, SMU by default
    var marker = new google.maps.Marker({
        position: loc,
        map: map
    });
}

// called when button is clicked
function getMap() {
    var addr = encodeURI(document.getElementById("destination").value);

    // console.log(addr);
    var url = "https://maps.googleapis.com/maps/api/geocode/json?address=" + addr + "&key= " + myKey;

    // axio call
    axios.get(url)
        .then(resp => {
            // console.log(resp.data)

            var fullAddress = getFullAddress(resp.data);
            document.getElementById("display").innerHTML = `Destination: </br> ${fullAddress}`;
            // refresh the hidden input values with new lat lng coordinates
            var coordinate = getLatLng(resp.data);
            document.getElementById("lat").value = coordinate.lat;
            document.getElementById("lng").value = coordinate.lng;

            // now refresh the map
            initMap();

            // get routes to display
            getRoutes();

        })
        .catch(err => {
            console.log(err.message)
            document.getElementById("display").innerText = `Please check that your address are correct`;
        });
}

async function getRoutes() { // get list of possible routes
    var orig = document.getElementById('origin').value;
    var destin = document.getElementById('destination').value;

    var routesURL = `https://maps.googleapis.com/maps/api/directions/json?key=${myKey}&origin=${orig}&destination=${destin}&mode=transit&alternatives=true`;

    axios.get(routesURL)
    .then(response => {
        // console.log(response.data)
        var checkWalking = response.data.routes // IF ITS WALKING, THERE IS ONLY 1 ROUTE OR CALCULATION IS NOT POSSIBLE, DUE TO UNAVAILABLE BASELINE
        // console.log(checkWalking);
        if (checkWalking.length == 1){
            var refBody = document.getElementById('routeContainer');
            refBody.innerHTML = '';
            document.getElementById("display").innerHTML = `Points are not earnable for this route. There is no baseline to compare against`;
        }
        else {
            var carbonResults = calcCarbon(response.data); // calculate carbon of each route. Returns total emissions and route
            var sortedCarbonResults = sortCarbonResults(carbonResults) // SORT FROM LEAST TO MOST CARBON EMISSION. [CAN WORK ON THIS IN FUTURE, TO SORT BY TIME, DISTANCE ETC.]
            if (sortedCarbonResults.length == 0) { // RETURNS MAY NOT BE RETURNED
                var refBody = document.getElementById('routeContainer');
                refBody.innerHTML = '';
                document.getElementById("display").innerHTML = `Bus or MRT Services may not be operating right now.</br>Otherwise, check that your postal code/address is correct`;
            }
            else {
                processResults(sortedCarbonResults); // generate table
            }
        }


    })
    .catch(err => {
        console.log(err.message)
    })

}

function calcCarbon(results) { // CALCULATE EACH ROUTE AND THEIR CARBON EMISSION
    var routesArray = results.routes; // ALL ROUTES POSSIBLE (ARRAY)
    var carbonArray = [];

    for (var routeIndex in routesArray) { // LOOP THROUGH EACH ROUTE
        var routeTotalCarbon = 0.0;
        var route = routesArray[routeIndex].legs
        // console.log(route);
        var routeSteps = route[0].steps; // GET ALL STEPS IN 1 ROUTE

        for (var oneStep in routeSteps) { // LOOP THROUGH EACH STEP
            // console.log(routeSteps[oneStep]);
            var travelMethod = routeSteps[oneStep].travel_mode; // GET MODE OF TRAVEL FOR CALCULATION
            // console.log(travelMethod);
            var stepDistance = parseFloat(routeSteps[oneStep].distance.text) // GET DISTANCE OF STEP IN FLOAT
            if (travelMethod != 'WALKING') { // BUS OR MRT
                var BusOrMrt = parseInt(routeSteps[oneStep].transit_details.line.name); // CHECK BUS OR MRT
                // console.log(BusOrMrt);
                if ( isNaN(BusOrMrt) ) { // TRUE MEANS MRT
                    routeTotalCarbon += (stepDistance * 13);
                }
                else { // BUS
                    routeTotalCarbon += (stepDistance * 73);
                }
            }
        }
        carbonArray.push( {routeCarbonTotal: routeTotalCarbon, routeData: route} );
        // console.log('Next route below');
    }
    // console.log(carbonArray);
    return carbonArray;
}

function sortCarbonResults(result) { // sort from least to most carbon emission
    // console.log(result)
    var sortedArray = result.sort((a, b) => a.routeCarbonTotal - b.routeCarbonTotal);
    console.log(sortedArray);
    return sortedArray;
}

function processResults(sortedCarbResults) { // GENERATE TABLE HERE
    // console.log(sortCarbResults);
    var carbonRef = sortedCarbResults[sortedCarbResults.length-1].routeCarbonTotal // Largest carbon emission is taken as base
    // console.log(carbonRef);
    const multiplier = 1; // EDIT THIS TO ADJUST AND SCALE POINTS EARNED ACCORDINGLY

    // FOR TABLE USE
    var headers = ['Routes'];
    var refHeaders = document.getElementById('tableHeaders');
    var refBody = document.getElementById('routeContainer');
    var output = '';
    // APPEND HEADERS TO TABLE
    output += "<tr>";
    for (var header of headers) {
        output += `<th>${header}</th>`;
    }
    output += "</tr>";
    refHeaders.innerHTML = output;
    // APPEND ROW OF DATA
    output = '';

    for (var carbonRoute in sortedCarbResults) { // SLOT INTO TABLE
        
        // console.log(sortedCarbResults[carbonRoute].routeData);
        var routeNum = parseInt(carbonRoute) + 1; // ROUTE NUMBER
        // console.log(routeInfoStepsCount);
        var pointsEarnable = Math.round( ( (carbonRef - sortedCarbResults[carbonRoute].routeCarbonTotal) / multiplier ) ) // POINTS EARNED FOR THIS ROUTE
        var carbonStepEmission = Math.round(carbonRef - sortedCarbResults[carbonRoute].routeCarbonTotal); // CARBON EMISSION SAVED
        var routeInfo = sortedCarbResults[carbonRoute].routeData[0];

        var routeInfoSteps = sortedCarbResults[carbonRoute].routeData[0].steps; // PROCESS THIS FURTHER
        // console.log(routeInfoSteps);
        // output += "<td>Dummy data";
        var firstInstruction = true;

        // START TRAVEL INSTRUCTIONS COLUMN
        var instructionText = '';

        for (var one_step in routeInfoSteps) { // CONSTRUCT ROW BY ROW IN "Travel Instructions"
            // console.log(routeInfoSteps[one_step].html_instructions);
            var instruction = routeInfoSteps[one_step].html_instructions; // "Walk to ..." "Subway to ..."


            if (!firstInstruction) {
                instructionText += `<hr>`;
            }
            instructionText += `${instruction}`;
            if (instruction.indexOf('Walk') == -1) { // MEANS ITS MRT OR BUS
                var transportImage = routeInfoSteps[one_step].transit_details.line.vehicle.icon // MRT OR BUS IMAGE
                var BusOrMRTInfo = routeInfoSteps[one_step].transit_details.line.name; // LINE NAME OR BUS NUMBER
                var BusOrMRTInfoBGColor = routeInfoSteps[one_step].transit_details.line.color; // LINE BG COLOR
                var BusOrMRTInfoTextColor = routeInfoSteps[one_step].transit_details.line.text_color; // LINE TEXT COLOR
                var numOfStops = routeInfoSteps[one_step].transit_details.num_stops; // HOW MANY STOPS
                var BusOrMrt = parseInt(routeInfoSteps[one_step].transit_details.line.name); // CHECK BUS OR MRT
                if ( isNaN(BusOrMrt) ) { // TRUE MEANS MRT
                    instructionText += `</br><img src='${transportImage}'><div id='mrtLine' style='background-color:${BusOrMRTInfoBGColor};color: ${BusOrMRTInfoTextColor};padding: 2px;border-radius:5px;display:inline;'>${BusOrMRTInfo}</div> <span class='fw-bold'>(${numOfStops} Stops)</span>`;
                }
                else { // BUS
                    instructionText += `</br><img src='${transportImage}'><div id='mrtLine' style='background-color:${BusOrMRTInfoBGColor};color: ${BusOrMRTInfoTextColor};padding: 2px;border-radius:5px;display:inline;'>${BusOrMRTInfo}</div> <span class='fw-bold'>(${numOfStops} Stops)</span>`;
                }

            }
            firstInstruction = false;
        }
        // CLOSE TRAVEL INSTRUCTIONS COLUMN

        // START DEPARTURE, ARRIVAL, TOTAL DISTANCE AND TIME COLUMNS
        let departureTime = routeInfo.departure_time.text; // DEPARTURE TIME
        let arrivalTime = routeInfo.arrival_time.text; // ARRIVAL TIME
        let totalDistance = routeInfo.distance.text; // TOTAL DIST
        let totalTime = routeInfo.duration.text; // TOTAL TIME

        output += `<div class="card" style="width: 100%;display: block;" id="routeNum${routeNum}-show">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title">Route Number ${routeNum}</h5>
                            </div>
                            <div class="col-6">
                                <h6 class="card-subtitle mb-2 text-muted">(${carbonStepEmission}g of CO² reduced)</h6>
                            </div>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">${pointsEarnable} points earnable</h6>
                        <p class="card-text">Journey Time: ${departureTime} - ${arrivalTime}</br>Total Distance: ${totalDistance}</br>Total Time: ${totalTime}</p>
                        <button onclick="displayRoute(this)" id="routeNum${routeNum}-show-button" class="btn btn-outline-success btn-sm">Display Instructions</button>
                    </div>
                </div>
                <div class="card" style="width: 100%;display: none;" id="routeNum${routeNum}-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title">Route Number ${routeNum}</h5>
                                <h6 class="card-subtitle mb-2 text-muted"><span id='points'>${pointsEarnable}</span> points (${carbonStepEmission}g of CO² reduced)</h6>
                                <p class="card-text">Departure Time: ${departureTime}</br>Arrival Time: ${arrivalTime}</br>Total Distance: ${totalDistance}</br>Total Time: ${totalTime}</p>
                                <button onclick="checkLogin(event)" class="btn btn-primary btn-sm">Add Journey</button>
                                </br></br>
                                <button onclick="displayRoute(this)" id="routeNum${routeNum}-hidden-button" class="btn btn-outline-primary btn-sm">Hide Instructions</button>
                            </div>
                            <div class="col-6">
                                ${instructionText}
                            </div>
                        </div>
                    </div>
                </div>`;
        
    }
    refBody.innerHTML = output;
}