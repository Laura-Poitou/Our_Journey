// to retrieve destinations associative table
document.addEventListener('DOMContentLoaded', function() {
	// select div
    var destinationElement = document.querySelector('#js-destinations');
	// retrieve data in dataset
	var destinations = destinationElement.dataset.destinations;
	// transform data from JSON to array
	var destinationsArray = JSON.parse(destinations)

	// retrieve first destination latitude and longitude to initialize the map
	var firstDestinationLatitude = destinationsArray[0]['latitude']
	var firstDestinationLongitude = destinationsArray[0]['longitude']

	// initialize the map 
	// search element with id = map
	// setView([latitude, longitude], zoom (between 13 and 16 generally))
	var map = L.map('map').setView([firstDestinationLatitude, firstDestinationLongitude], 6);

	// image (of map) from https://leaflet-extras.github.io/leaflet-providers/preview/
	// on stamen.com : JavaScript Libraries paragraph > Leaflet > view demo 
	// Stada OSMBright
	var Stadia_OSMBright = L.tileLayer('https://tiles.stadiamaps.com/tiles/osm_bright/{z}/{x}/{y}{r}.png', {
	maxZoom: 20,
	attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
	});

	// to add images to map
	Stadia_OSMBright.addTo(map);

	//markers
	for (var destination of destinationsArray) {
		var marker = L.marker([destination.latitude, destination.longitude], {alt: `${destination.name}`}).addTo(map).bindPopup(`${destination.name}`);
	}

});

