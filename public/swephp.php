<?php

if (!defined('SEFLG_ECLIPTIC')) {
    define('SEFLG_ECLIPTIC', 0); // Define the constant if it's missing
}
if (!defined('SEFLG_HELCTR')) {
    define('SEFLG_HELCTR', 256); // Define the constant if it's missing
}
if (!defined('SEFLG_EQUATORIAL')) {
    define('SEFLG_EQUATORIAL', 2048); // Define the constant if it's missing
}
if (!defined('SEFLG_SPEED')) {
    define('SEFLG_SPEED', 256); // Define the constant if it's missing
}

// SEFLG_JPLEPH	1	Use JPL ephemeris (high-precision)
// SEFLG_SWIEPH	2	Use Swiss Ephemeris files
// SEFLG_MOSEPH	4	Use Moshier ephemeris (low-precision, no files required)
// SEFLG_SPEED	256	Include the speed of the planet in the output
// SEFLG_HELCTR	256	Calculate positions in the heliocentric coordinate system
// SEFLG_TRUEPOS	512	Calculate true geometric positions (no light-time correction)
// SEFLG_EQUATORIAL	2048	Calculate positions in equatorial coordinates (right ascension, declination)
// SEFLG_ECLIPTIC	0


// Helper function to get zodiac sign from longitude
function get_zodiac_sign($longitude) {
    $signs = [
        "Aries", "Taurus", "Gemini", "Cancer", 
        "Leo", "Virgo", "Libra", "Scorpio", 
        "Sagittarius", "Capricorn", "Aquarius", "Pisces"
    ];
    $index = floor($longitude / 30) % 12;
    return $signs[$index];
}

// Helper function to convert decimal degrees to DMS format
function convert_to_dms($decimal_degrees) {
    $degrees = floor($decimal_degrees);
    $minutes = floor(($decimal_degrees - $degrees) * 60);
    $seconds = round(($decimal_degrees - $degrees - $minutes / 60) * 3600, 2);

    return sprintf("%d° %02d' %05.2f\"", $degrees, $minutes, $seconds);
}

// Set path to ephemeris data files
swe_set_ephe_path("ephe/");

// Example Date and Time
// Example Date and Time
$y = 1978;
$m = 9;
$d = 7;
$h = 14;
$mi = 30;
$s = 0;
 
define("GEO_LNG", 40.24); // Longitude for Madrid
define("GEO_LAT", 3.41);  // Latitude for Madrid


// Define the timezone (Europe/Madrid)
$timezone = new DateTimeZone('Europe/Madrid');
$date = new DateTime("$y-$m-$d $h:$mi:$s", $timezone);

// Convert local time to UT (Universal Time)
$date->setTimezone(new DateTimeZone('UTC'));
$ut_hours = (float) $date->format('H') + ($date->format('i') / 60) + ($date->format('s') / 3600);

// Calculate Julian date in UT


$jul_ut = swe_julday(
    (int) $date->format('Y'),
    (int) $date->format('m'),
    (int) $date->format('d'),
    $ut_hours,
    SE_GREG_CAL
);


echo "Input Date (Local Time): 1978-09-07 13:30:00 (Madrid)\n";
echo "Converted UT Time: " . $date->format('Y-m-d H:i:s') . " (UTC)\n";
echo "Julian Date (UT): $jul_ut\n";

// Output the result for debugging
echo "Adjusted Julian Date: $jul_ut\n";

$planets = [];

// Calculate positions for planets, including North/South Node and Earth
for ($i = SE_SUN; $i <= SE_VESTA; $i++) {
    $xx = swe_calc_ut($jul_ut, $i, SEFLG_SPEED| SEFLG_ECLIPTIC);
    if ($xx['rc'] < 0) {
        $planets[] = array('name' => swe_get_planet_name($i), 'error' => 'Calculation failed');
        continue;
    }

    $declination = convert_to_dms($xx[1]); // Declination in DMS

    $planets[] = array(
        'name' => swe_get_planet_name($i),
        'lng' => convert_to_dms($xx[0]), // DMS format
        'declination' => $declination, // Declination in DMS
        'lat' => $xx[1],
        'speed' => $xx[3],
        'sign' => get_zodiac_sign($xx[0])
    );
}

// Add Earth
$earth = swe_calc_ut($jul_ut, SE_EARTH, SEFLG_SPEED| SEFLG_HELCTR);
if ($earth['rc'] >= 0) {
    $planets[] = array(
        'name' => 'Earth',
        'lng' => convert_to_dms($earth[0]), // DMS format
        'declination' => convert_to_dms($earth[1]),
        'lat' => $earth[1],
        'speed' => $earth[3],
        'sign' => get_zodiac_sign($earth[0])
    );
}

// Add Mean Node
$mean_node = swe_calc_ut($jul_ut, SE_MEAN_NODE, SEFLG_SPEED| SEFLG_ECLIPTIC);
if ($mean_node['rc'] >= 0) {
    $planets[] = array(
        'name' => 'Mean Node (North)',
        'lng' => convert_to_dms($mean_node[0]), // DMS format
        'declination' => convert_to_dms($mean_node[1]), // Declination in DMS
        'lat' => $mean_node[1],
        'speed' => $mean_node[3],
        'sign' => get_zodiac_sign($mean_node[0])
    );

    // Calculate South Node
$south_node_lng = fmod($mean_node[0] + 180, 360); // Opposite point
    $planets[] = array(
        'name' => 'South Node',
        'lng' => convert_to_dms($south_node_lng), // DMS format
        'declination' => convert_to_dms(-$mean_node[1]), // Inverted declination
        'lat' => -$mean_node[1], // Invert latitude
        'speed' => $mean_node[3],
        'sign' => get_zodiac_sign($south_node_lng)
    );
}

// Add True Node
$true_node = swe_calc_ut($jul_ut, SE_TRUE_NODE, SEFLG_SPEED| SEFLG_ECLIPTIC);
if ($true_node['rc'] >= 0) {
    $planets[] = array(
        'name' => 'True Node (North)',
        'lng' => convert_to_dms($true_node[0]), // DMS format
        'declination' => convert_to_dms($true_node[1]), // Declination in DMS
        'lat' => $true_node[1],
        'speed' => $true_node[3],
        'sign' => get_zodiac_sign($true_node[0])
    );
}




$houses_result = swe_houses($jul_ut, GEO_LAT, GEO_LNG, "P"); // P = Placidus
$houses = [];
echo "Used coordinates: Lat:".GEO_LAT."Long: ".GEO_LNG." \n";
// Calculate obliquity (eps)
$eps = swe_calc_ut($jul_ut, SE_ECL_NUT, SEFLG_SPEED)['xx'][0]; // Extract obliquity of ecliptic

for ($i = 1; $i <= 12; $i++) {
    $cusp_longitude = $houses_result['cusps'][$i];

    // Convert cusp to equatorial coordinates to get declination
    $equatorial_coords = swe_cotrans($cusp_longitude, 0, 1, $eps); // Pass obliquity as the last parameter
    $declination = $equatorial_coords[1]; // Declination in degrees

    $houses[] = array(
        'house' => $i,
        'lng' => convert_to_dms($cusp_longitude), // Longitude in DMS
        'declination' => convert_to_dms($declination), // Declination in DMS
        'sign' => get_zodiac_sign($cusp_longitude)
    );
}





// Output HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Calculations</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        table th, table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        table th { background-color: #f4f4f4; }
        h2 { color: #333; }
    </style>
</head>
<body>
<h1>Calculations</h1>

<h2>Planets</h2>
<table>
    <thead>
        <tr>
            <th>Planet</th>
            <th>Longitude (DMS)</th>
            <th>Latitude</th>
            <th>Declination (DMS)</th>
            <th>Speed</th>
            <th>Sign</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($planets as $planet): ?>
            <tr>
                <td><?= htmlspecialchars($planet['name']) ?></td>
                <td><?= $planet['lng'] ?></td>
                <td><?= isset($planet['lat']) ? number_format($planet['lat'], 4) . "°" : 'Error' ?></td>
                <td><?= isset($planet['declination']) ? $planet['declination'] : 'N/A' ?></td>
                <td><?= isset($planet['speed']) ? number_format($planet['speed'], 4) : 'Error' ?></td>
                <td><?= $planet['sign'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>House Cusps</h2>
<table>
    <thead>
        <tr>
            <th>House</th>
            <th>Longitude (DMS)</th>
            <th>Declination (DMS)</th>
            <th>Sign</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($houses as $house): ?>
            <tr>
                <td><?= $house['house'] ?></td>
                <td><?= $house['lng'] ?></td>
                <td><?= isset($house['declination']) ? $house['declination'] : 'N/A' ?></td>
                <td><?= $house['sign'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
