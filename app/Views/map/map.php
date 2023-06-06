<style>
	#map {
  height: 400px; /* The height is 400 pixels */
  width: 100%; /* The width is the width of the web page */
}
</style>
<br>

<div id="map"></div>

<script>

var lat;
var lon;
var map;
var infowindow;
	// Initialize and add the map
	function initMap() {
		console.log("hhh");
		
	 infowindow = new google.maps.InfoWindow();

	  // The map, centered at Uluru
	  getLocation();
	  
	}
	

	function mapLocation(lat, lon){
		
		const uluru = { lat: lat, lng: lon };
		//const uluru = { lat: 52.514330, lng: -2.069860 };
		//const uluru = { lat: 52.526700, lng: -2.099440 };
		map = new google.maps.Map(document.getElementById("map"), {
		zoom: 12,
		center: uluru,
	  });
		const marker1 = new google.maps.Marker({
			position: uluru,
			map: map,
		  });
		  
		marker1.addListener("click", () => {
		infowindow.setContent("Current Location");
		infowindow.open(marker1.get("map"), marker1);
		});
		  
		  
		  
		
		var request = {
		location: uluru,
		radius: '50000',
		type: ['movie_theater']
		};

	  service = new google.maps.places.PlacesService(map);
	  service.nearbySearch(request, callback);

		function callback(results, status) {
		  console.log("here");
		  if (status == google.maps.places.PlacesServiceStatus.OK) {
			console.log("in");
			for (var i = 0; i < results.length; i++) {
			  createMarker(results[i]);
			  console.log(results[i]);
			}
		  }
		}
	}

	function createMarker(place) {
	  if (!place.geometry || !place.geometry.location) return;

	  const marker = new google.maps.Marker({
		map,
		position: place.geometry.location,
	  });

	  marker.addListener("click", () => {
		infowindow.setContent(place.name || "");
		console.log(place.place_id);
		infowindow.open(marker.get("map"), marker);
		var request1 = {
		placeId: place.place_id,
		fields:['url']
		};

	  service1 = new google.maps.places.PlacesService(map);
	  service1.getDetails(request1, callback1);
	  });
	  
	  function callback1(results, status) {
		  console.log("here");
		  if (status == google.maps.places.PlacesServiceStatus.OK) {
			console.log("in");
			console.log(results.url);
			infowindow.setContent(place.name+'<br>'+'<br>'+
			'<a class="btn btn-outline-success mb-4" href="'+results.url+'">View Details</a>' || "");
		  }
		}
	  
	}


	function getLocation(){
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition((position) => {
			  console.log(position.coords.latitude);
			  console.log(position.coords.longitude);
			  lat = position.coords.latitude;
			  lon = position.coords.longitude;
			  mapLocation(lat,lon);
			});
		}
	}

window.initMap = initMap;

</script>

<script       
	src="https://maps.googleapis.com/maps/api/js?key= Enter your own key here &libraries=places&callback=initMap&v=weekly"
      defer
	>
</script>