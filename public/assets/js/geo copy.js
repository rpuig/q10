$(document).ready(function() {
	let suggestionsData = {}; // To store the suggestions data

	$('#city').on('input', function() {
			let query = $(this).val();
			if (query.length > 2) {
					$.ajax({
							url: "https://api.geoapify.com/v1/geocode/autocomplete",
							method: "GET",
							data: {
									text: query,
									apiKey: "e571f67e7ed14d83ba5c9495e1056fb1"
							},
							success: function(result) {
									console.log(result); // Log the entire response to see all the information
									$('#suggestions').empty();
									suggestionsData = {}; // Clear previous suggestions data

									result.features.forEach(function(feature, index) {
											const city = feature.properties.city || feature.properties.name; // Fallback to name if city is unavailable
											const country = feature.properties.country;
											const timezone = feature.properties.timezone;
											const lon = feature.geometry.coordinates[0]; // Longitude
											const lat = feature.geometry.coordinates[1]; // Latitude
											const displayText = `${city}, ${country}`;

											suggestionsData[displayText] = {
													timezone: timezone,
													country: country,
													city: city,
													lon: lon,
													lat: lat,
													feature: feature
											};

											$('#suggestions').append('<li class="list-group-item list-group-item-action" data-city="' + displayText + '" data-index="' + index + '">' + displayText + '</li>');
									});
							},
							error: function(error) {
									console.log('error', error);
							}
					});
			} else {
					$('#suggestions').empty();
			}
	});

	// Event delegation for dynamically created list items
	$(document).on('click', '#suggestions li', function() {
			const displayText = $(this).data('city');
			const suggestion = suggestionsData[displayText];

			$('#city').val(suggestion.city); // Set only the city name in the city input
			$('#country_display').val(suggestion.country);
			$('#birthCountry').val(suggestion.country);
			$('#suggestions').empty();

			// Highlight the selected suggestion
			$('#suggestions li').removeClass('active');
			$(this).addClass('active');

			// Store the selected suggestion's timezone name and coordinates
			if (suggestion) {
					if (suggestion.timezone) {
							const timezoneName = suggestion.timezone.name;
							$('#timezone').val(timezoneName);
					}

					// Log or use longitude and latitude
					console.log('Selected City:', suggestion.city);
					console.log('Country:', suggestion.country);
					console.log('Timezone:', suggestion.timezone ? suggestion.timezone.name : 'N/A');
					console.log('Longitude:', suggestion.lon);
					console.log('Latitude:', suggestion.lat);

					// Store longitude and latitude in hidden input fields
					$('#longitude').val(suggestion.lon); // Hidden input for longitude
					$('#latitude').val(suggestion.lat);  // Hidden input for latitude


				
					// Log the values of latitude and longitude in the console
					//console.log('Hidden Latitude:', $('#latitude').val());

					console.log('Hidden Longitude:', $('#latitude').prop('value'));
					console.log('Hidden Longitude:', $('#longitude').prop('value'));


			} else {
					console.log('Suggestion data not available for this selection');
			}
	});


});
