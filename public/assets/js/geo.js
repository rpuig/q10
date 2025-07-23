$(document).ready(function() {
	let suggestionsData = {}; // Store suggestions data
	let validSelection = false; // Track if user made a valid selection

	$('#city').on('input', function() {
			let query = $(this).val();
			validSelection = false; // Reset selection status when user types

			if (query.length > 2) {
					$.ajax({
							url: "https://api.geoapify.com/v1/geocode/autocomplete",
							method: "GET",
							data: {
									text: query,
									apiKey: "e571f67e7ed14d83ba5c9495e1056fb1"
							},
							success: function(result) {
									console.log(result); // Log API response
									$('#suggestions').empty();
									suggestionsData = {}; // Clear previous suggestions

									result.features.forEach(function(feature, index) {
											const city = feature.properties.city || feature.properties.name; 
											const country = feature.properties.country;
											const timezone = feature.properties.timezone;
											const lon = feature.geometry.coordinates[0]; 
											const lat = feature.geometry.coordinates[1]; 
											const displayText = `${city}, ${country}`;

											suggestionsData[displayText] = {
													timezone: timezone,
													country: country,
													city: city,
													lon: lon,
													lat: lat,
													feature: feature
											};

											$('#suggestions').append('<li class="list-group-item list-group-item-action" data-city="' + displayText + '">' + displayText + '</li>');
									});
							},
							error: function(error) {
									console.log('Error:', error);
							}
					});
			} else {
					$('#suggestions').empty();
			}
	});

	// Handle suggestion click
	$(document).on('click', '#suggestions li', function() {
			const displayText = $(this).data('city');
			const suggestion = suggestionsData[displayText];

			if (suggestion) {
					$('#city').val(suggestion.city);
					$('#country_display').val(suggestion.country);
					$('#birthCountry').val(suggestion.country);
					$('#suggestions').empty();

					$('#longitude').val(suggestion.lon);
					$('#latitude').val(suggestion.lat);

					validSelection = true; // Mark selection as valid

					console.log('Selected:', suggestion);
			}
	});

	// Prevent form submission if no valid selection
	$('#yourForm').on('submit', function(event) {
			if (!validSelection) {
					event.preventDefault();
					alert("Please select a city from the suggestions.");
			}
	});
});
