// initialize the map 
// by default Tokyo 
// setView([latitude, longitude], zoom (between 13 and 16 generally))
var map = L.map('map').setView([35.681521, 139.756878], 6);


// image (of map) from https://leaflet-extras.github.io/leaflet-providers/preview/
// on stamen.com : JavaScript Libraries paragraph > Leaflet > view demo 
// Stada OSMBright
var Stadia_OSMBright = L.tileLayer('https://tiles.stadiamaps.com/tiles/osm_bright/{z}/{x}/{y}{r}.png', {
	maxZoom: 20,
	attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
});

// to add images to map
Stadia_OSMBright.addTo(map);

// add markers
var markerTokyo = L.marker([35.681521, 139.756878]).addTo(map);
var markerNikko = L.marker([36.90125396268982, 139.63572877491868]).addTo(map);

// pop up
markerTokyo.bindPopup("<p>Tokyo</p>").openPopup();
markerNikko.bindPopup("<p>Nikko</p>").openPopup();