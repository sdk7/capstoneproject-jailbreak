var current_location = "N/A, N/A";
/* global navigator */
navigator
	.geolocation
	.watchPosition(
		geoSuccess,
		geoError,
		{
			enableHighAccuracy : false,
			maximumAge         : 30 * 1000, // 30 seconds
			timeout            : 10 * 1000   // 5 seconds
		}
	);

function geoSuccess(pos) {
	var coords = pos.coords;
	console.log(coords.latitude + ", " + coords.longitude + ", " + pos.timestamp);
	current_location = coords.latitude + ", " + coords.longitude;
}

function geoError(err) {
	console.warn("ERROR: (" + err.code + ") " + err.message);
}