var map;
var panel;
var initialize;
var calculate;
var direction;
var infoWindow;
var pos;
var markers = [];
var myPoints = [];
var tmp_dest;
var origin;
var destination;

if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function(position) {
    pos = {lat:position.coords.latitude, lng:position.coords.longitude};
    $('#origin').val(pos.lat + ',' + pos.lng);
    var marker = new google.maps.Marker({
      position: pos,
      map: map,
      title: 'Vous etes ici!'
    });
  });
  
}
else {
  console.log(0);
}
$(document).keydown(function(e) {
  if (e.keyCode == 27) {
    resizeMapOriginal();
  }
});

function resizeMap() {
  $("#destinationForm").addClass('hidden');
  $("#map").css({height: $(window).height(), width: $(window).width()});
}

function resizeMapOriginal() {
  $("#destinationForm").removeClass('hidden');
  $("#map").css({height: '600px', width: '800px'});
}

$.each(markers, function() {
  this.setMap(null);
});

function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}
function clearMarkers() {
  setMapOnAll(null);
}
function deleteMarkers() {
  clearMarkers();
  markers = [];
}

function placeMarker(location)
{
  deleteMarkers();
  var marker = new google.maps.Marker({
    position : location,
    title : "Titik A",
    map : map
  });
  markers.push(marker);
  var lat = marker.getPosition().lat();
  var lng = marker.getPosition().lng();
  $('#destination').val(lat + ',' + lng);
}

initialize = function(){
  var latLng = new google.maps.LatLng(43.293401, 5.374933);
  var myOptions = {
    zoom      : 5, // Zoom par défaut
    center    : latLng, // Coordonnées de départ de la carte de type latLng 
    mapTypeId : google.maps.MapTypeId.ROADMAP, // Type de carte, différentes valeurs possible HYBRID, ROADMAP, SATELLITE, TERRAIN
    maxZoom   : 20, 
    fullscreenControl: true
  };


  
  map = new google.maps.Map(document.getElementById('map'), myOptions);



  direction = new google.maps.DirectionsRenderer({
    map   : map,
  });
  var element = document.getElementById('destination');
  var autocomplete = new google.maps.places.Autocomplete(element);
  autocomplete.bindTo('bounds', map);
  element = document.getElementById('origin');
  autocomplete = new google.maps.places.Autocomplete(element);
  autocomplete.bindTo('bounds', map);
};

calculate = function(){
  var stepDisplay = new google.maps.InfoWindow();
    origin      = document.getElementById('origin').value; // Le point départ
    destination = document.getElementById('destination').value; // Le point d'arrivé
    if (tmp_dest != destination) {
      console.log("okok");
      myPoints = [];
    }
    tmp_dest = destination;
    sessionStorage.setItem("origin", origin);
    sessionStorage.setItem("destination", destination);
    if(origin && destination){
      var request = {
        origin      : origin,
        destination : destination,
        waypoints: myPoints,
            travelMode  : google.maps.DirectionsTravelMode.DRIVING // Mode de conduite
          };
        var directionsService = new google.maps.DirectionsService(); // Service de calcul d'itinéraire
        directionsService.route(request, function(response, status){ // Envoie de la requête pour calculer le parcours
          if(status == google.maps.DirectionsStatus.OK){
           direction.setDirections(response);
                  // Trace l'itinéraire sur la carte et les différentes étapes du parcours
                  showSteps(response, markers, stepDisplay, map);
                }
              });
      }
    };

    function showSteps(directionResult, markerArray, stepDisplay, map) {
      sessionStorage.setItem('old', [directionResult, markerArray, stepDisplay, map]);
      var myRoute = directionResult.routes[0].legs[0];
      for (var i = 0; i < myRoute.steps.length; i++) {
        var marker = markerArray[i] = markerArray[i] || new google.maps.Marker();
        marker.setMap(map);
        marker.setPosition(myRoute.steps[i].start_location);
        attachInstructionText(
          stepDisplay, marker, myRoute.steps[i].instructions, map);
      }
      for (var j = 0; j < markerArray.length; j++) {
        markerArray[j].setMap(null);
      }
      getPlaces(markerArray);
    }

    function attachInstructionText(stepDisplay, marker, text, map) {
      google.maps.event.addListener(marker, 'click', function() {
    // Open an info window when the marker is clicked on, containing the text
    // of the step.
    stepDisplay.setContent(text);
    stepDisplay.open(map, marker);
  });
    }
    function callback(results, status) {
      var val;
      if (status === google.maps.places.PlacesServiceStatus.OK) {
        if (results.length > 2)
          val = 2;
        else
          val = results.length;
        for (var i = 0; i < val; i++) {
          createMarker(results[i]);
        }
      }
    }

    function createMarker(place) {
      if (myPoints.length < 8) {
        var placeLoc = place.geometry.location;
        var pinColor = "22F52B";
        var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
          new google.maps.Size(21, 34),
          new google.maps.Point(0,0),
          new google.maps.Point(10, 34));
        var marker = new google.maps.Marker({
          map: map,
          icon: pinImage,
          position: place.geometry.location
        });
        myPoints.push({location: marker.position.lat() + ',' + marker.position.lng(), stopover: true});
      }
    }

    function getPlaces(markerArray) {
      for (var i = 8; i < markerArray.length;i++) {
        var toast = {lat: markerArray[i].position.lat(), lng: markerArray[i].position.lng()};
        var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
          location: toast,
          radius: 10000,
          types: ['art_gallery', 'museum', 'amusement_park']
        }, callback);
      }
    }

    function history() {
      myPoints = [];
      var val1 = sessionStorage.getItem("origin");
      var val2 = sessionStorage.getItem("destination");
      $('#origin').val(val1);
      $('#destination').val(val2);
      calculate();
    }
    initialize();
    google.maps.event.addListener(map, 'click', function(event) {
     placeMarker(event.latLng, map);
   });




